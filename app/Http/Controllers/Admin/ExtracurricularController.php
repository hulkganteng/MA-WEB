<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ExtracurricularController extends Controller
{
    public function index(Request $request)
    {
        $extracurriculars = Extracurricular::query()
            ->when($request->filled('q'), fn ($query) => $query->where(fn ($q) => $q->where('name', 'like', '%'.$request->string('q').'%')->orWhere('mentor', 'like', '%'.$request->string('q').'%')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->orderBy('order')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.extracurriculars.index', compact('extracurriculars'));
    }

    public function create()
    {
        return view('admin.extracurriculars.form', [
            'extracurricular' => new Extracurricular(['status' => 'active', 'order' => 0]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('extracurriculars', 'public');
        }

        $extra = Extracurricular::create($data);
        activity_log('extracurricular.create', $extra, ['name' => $extra->name]);

        return redirect()->route('admin.extracurriculars.index')->with('flash', ['type' => 'success', 'message' => 'Ekstrakurikuler berhasil ditambahkan']);
    }

    public function edit(Extracurricular $extracurricular)
    {
        return view('admin.extracurriculars.form', compact('extracurricular'));
    }

    public function update(Request $request, Extracurricular $extracurricular)
    {
        $data = $this->validated($request);
        if ($extracurricular->name !== $data['name']) {
            $data['slug'] = $this->uniqueSlug($data['name'], $extracurricular);
        }

        if ($request->hasFile('photo')) {
            if ($extracurricular->photo) {
                Storage::disk('public')->delete($extracurricular->photo);
            }
            $data['photo'] = $request->file('photo')->store('extracurriculars', 'public');
        }

        $extracurricular->update($data);
        activity_log('extracurricular.update', $extracurricular, ['name' => $extracurricular->name]);

        return redirect()->route('admin.extracurriculars.index')->with('flash', ['type' => 'success', 'message' => 'Ekstrakurikuler berhasil diperbarui']);
    }

    public function destroy(Extracurricular $extracurricular)
    {
        activity_log('extracurricular.delete', $extracurricular, ['name' => $extracurricular->name]);
        $extracurricular->delete();

        return back()->with('flash', ['type' => 'success', 'message' => 'Ekstrakurikuler dipindahkan ke sampah']);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:50'],
            'mentor' => ['nullable', 'string', 'max:255'],
            'schedule' => ['nullable', 'string', 'max:255'],
            'achievements' => ['nullable', 'string', 'max:5000'],
            'description' => ['nullable', 'string', 'max:5000'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'status' => ['required', Rule::in(Extracurricular::STATUSES)],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    private function uniqueSlug(string $name, ?Extracurricular $ignore = null): string
    {
        $base = Str::slug($name) ?: Str::random(8);
        $slug = $base;
        $suffix = 2;
        while (Extracurricular::withTrashed()->where('slug', $slug)->when($ignore, fn ($query) => $query->whereKeyNot($ignore->id))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
