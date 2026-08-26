<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->string('status')->toString() === 'trash' ? Teacher::onlyTrashed() : Teacher::query();
        $teachers = $query
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = '%'.$request->string('q')->toString().'%';
                $query->where(fn ($query) => $query->where('name', 'like', $term)->orWhere('position', 'like', $term)->orWhere('subject', 'like', $term));
            })
            ->when(in_array($request->string('type')->toString(), Teacher::TYPES, true), fn ($query) => $query->where('type', $request->string('type')->toString()))
            ->when($request->string('status')->toString() === 'published', fn ($query) => $query->where('is_active', true)->where('is_public', true))
            ->when($request->string('status')->toString() === 'hidden', fn ($query) => $query->where(fn ($query) => $query->where('is_active', false)->orWhere('is_public', false)))
            ->orderBy('type')->orderBy('order')->orderBy('name')
            ->paginate(15)->withQueryString();

        return view('admin.teachers.index', compact('teachers'));
    }

    public function create(Request $request)
    {
        return view('admin.teachers.form', ['teacher' => new Teacher([
            'type' => in_array($request->string('type')->toString(), Teacher::TYPES, true) ? $request->string('type')->toString() : 'guru',
            'is_active' => true, 'is_public' => true, 'order' => 0,
        ])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['photo'] = $request->file('photo')?->store('teachers', 'public');
        $teacher = Teacher::create($data);
        activity_log('teacher.create', $teacher, ['name' => $teacher->name, 'type' => $teacher->type]);

        return redirect()->route('admin.teachers.index', ['type' => $teacher->type])->with('flash', ['type' => 'success', 'message' => $this->typeLabel($teacher).' ditambahkan']);
    }

    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.form', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $data = $this->validated($request);
        if ($teacher->name !== $data['name']) {
            $data['slug'] = $this->uniqueSlug($data['name'], $teacher);
        }
        if ($request->hasFile('photo')) {
            if ($teacher->photo) {
                Storage::disk('public')->delete($teacher->photo);
            }
            $data['photo'] = $request->file('photo')->store('teachers', 'public');
        }
        $teacher->update($data);
        activity_log('teacher.update', $teacher, ['name' => $teacher->name, 'type' => $teacher->type]);

        return redirect()->route('admin.teachers.index', ['type' => $teacher->type])->with('flash', ['type' => 'success', 'message' => $this->typeLabel($teacher).' diperbarui']);
    }

    public function destroy(Teacher $teacher)
    {
        activity_log('teacher.delete', $teacher, ['name' => $teacher->name, 'type' => $teacher->type]);
        $teacher->delete();

        return back()->with('flash', ['type' => 'success', 'message' => $this->typeLabel($teacher).' dipindahkan ke sampah']);
    }

    public function restore(int $teacher)
    {
        $teacher = Teacher::onlyTrashed()->findOrFail($teacher);
        $teacher->restore();
        activity_log('teacher.restore', $teacher, ['name' => $teacher->name, 'type' => $teacher->type]);

        return redirect()->route('admin.teachers.index', ['status' => 'trash'])->with('flash', ['type' => 'success', 'message' => $this->typeLabel($teacher).' dipulihkan']);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(Teacher::TYPES)],
            'position' => ['nullable', 'string', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'education' => ['nullable', 'string', 'max:255'],
            'order' => ['required', 'integer', 'min:0', 'max:9999'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'is_active' => ['nullable', 'boolean'],
            'is_public' => ['nullable', 'boolean'],
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_public'] = $request->boolean('is_public');

        return $data;
    }

    private function uniqueSlug(string $name, ?Teacher $ignore = null): string
    {
        $base = Str::slug($name) ?: Str::random(8);
        $slug = $base;
        $suffix = 2;
        while (Teacher::withTrashed()->where('slug', $slug)->when($ignore, fn ($query) => $query->whereKeyNot($ignore->id))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }

    private function typeLabel(Teacher $teacher): string
    {
        return $teacher->type === 'guru' ? 'Guru' : 'Tenaga kependidikan';
    }
}
