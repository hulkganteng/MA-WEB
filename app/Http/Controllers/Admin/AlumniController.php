<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\AlumniSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        $submissionStatus = in_array($request->input('submission_status', 'pending'), AlumniSubmission::STATUSES, true)
            ? $request->input('submission_status', 'pending')
            : 'pending';
        $alumni = Alumni::query()
            ->when($request->filled('q'), fn ($query) => $query->where('name', 'like', '%'.$request->string('q').'%'))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->orderBy('order')->latest('graduation_year')->paginate(15, ['*'], 'alumni_page')->withQueryString();
        $submissions = AlumniSubmission::query()
            ->where('status', $submissionStatus)
            ->latest()->paginate(15, ['*'], 'submission_page')->withQueryString();
        $pendingCount = AlumniSubmission::where('status', 'pending')->count();

        return view('admin.alumni.index', compact('alumni', 'submissions', 'pendingCount'));
    }

    public function create()
    {
        return view('admin.alumni.form', ['alumnus' => new Alumni(['status' => 'verified', 'is_public' => true, 'order' => 0])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['is_public'] = $request->boolean('is_public');
        $data['photo'] = $request->file('photo')?->store('alumni', 'public');
        $alumnus = Alumni::create($data);
        activity_log('alumni.create', $alumnus, ['name' => $alumnus->name]);

        return redirect()->route('admin.alumni.index')->with('flash', ['type' => 'success', 'message' => 'Profil alumni ditambahkan']);
    }

    public function edit(Alumni $alumnus)
    {
        return view('admin.alumni.form', compact('alumnus'));
    }

    public function update(Request $request, Alumni $alumnus)
    {
        $data = $this->validated($request);
        if ($alumnus->name !== $data['name']) {
            $data['slug'] = $this->uniqueSlug($data['name'], $alumnus);
        }
        $data['is_public'] = $request->boolean('is_public');
        if ($request->hasFile('photo')) {
            if ($alumnus->photo) {
                Storage::disk('public')->delete($alumnus->photo);
            }
            $data['photo'] = $request->file('photo')->store('alumni', 'public');
        }
        $alumnus->update($data);
        activity_log('alumni.update', $alumnus, ['name' => $alumnus->name]);

        return redirect()->route('admin.alumni.index')->with('flash', ['type' => 'success', 'message' => 'Profil alumni diperbarui']);
    }

    public function destroy(Alumni $alumnus)
    {
        activity_log('alumni.delete', $alumnus, ['name' => $alumnus->name]);
        $alumnus->delete();

        return back()->with('flash', ['type' => 'success', 'message' => 'Profil alumni dipindahkan ke sampah']);
    }

    public function approve(AlumniSubmission $submission)
    {
        abort_unless($submission->status === 'pending', 422);
        $alumnus = DB::transaction(function () use ($submission) {
            $alumnus = Alumni::create([
                'name' => $submission->name, 'slug' => $this->uniqueSlug($submission->name),
                'graduation_year' => $submission->graduation_year, 'university' => $submission->university,
                'major' => $submission->major, 'occupation' => $submission->occupation,
                'company' => $submission->company, 'photo' => $submission->photo,
                'testimonial' => $submission->testimonial, 'status' => 'verified', 'is_public' => true, 'order' => 0,
            ]);
            $submission->update(['status' => 'approved']);

            return $alumnus;
        });
        activity_log('alumni.submission.approve', $alumnus, ['submission_id' => $submission->id]);

        return back()->with('flash', ['type' => 'success', 'message' => 'Registrasi disetujui dan profil alumni dipublikasikan']);
    }

    public function reject(AlumniSubmission $submission)
    {
        abort_unless($submission->status === 'pending', 422);
        $submission->update(['status' => 'rejected']);
        activity_log('alumni.submission.reject', $submission, ['name' => $submission->name]);

        return back()->with('flash', ['type' => 'success', 'message' => 'Registrasi alumni ditolak']);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'], 'graduation_year' => ['nullable', 'integer', 'min:1950', 'max:'.now()->year],
            'university' => ['nullable', 'string', 'max:255'], 'major' => ['nullable', 'string', 'max:255'],
            'occupation' => ['nullable', 'string', 'max:255'], 'company' => ['nullable', 'string', 'max:255'],
            'testimonial' => ['nullable', 'string', 'max:1500'], 'status' => ['required', Rule::in(Alumni::STATUSES)],
            'is_public' => ['nullable', 'boolean'], 'order' => ['required', 'integer', 'min:0', 'max:9999'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);
    }

    private function uniqueSlug(string $name, ?Alumni $ignore = null): string
    {
        $base = Str::slug($name) ?: Str::random(8);
        $slug = $base;
        $suffix = 2;
        while (Alumni::withTrashed()->where('slug', $slug)->when($ignore, fn ($query) => $query->whereKeyNot($ignore->id))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
