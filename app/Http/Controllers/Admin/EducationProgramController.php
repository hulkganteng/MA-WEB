<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EducationProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EducationProgramController extends Controller
{
    public function index(Request $request)
    {
        $programs = EducationProgram::query()
            ->when($request->filled('q'), fn ($query) => $query->where('name', 'like', '%'.$request->string('q').'%'))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->orderBy('order')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.programs.form', [
            'program' => new EducationProgram(['status' => 'active', 'order' => 0]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('programs', 'public');
        }

        $prog = EducationProgram::create($data);
        activity_log('program.create', $prog, ['name' => $prog->name]);

        return redirect()->route('admin.programs.index')->with('flash', ['type' => 'success', 'message' => 'Program pendidikan berhasil ditambahkan']);
    }

    public function edit(EducationProgram $program)
    {
        return view('admin.programs.form', compact('program'));
    }

    public function update(Request $request, EducationProgram $program)
    {
        $data = $this->validated($request);
        if ($program->name !== $data['name']) {
            $data['slug'] = $this->uniqueSlug($data['name'], $program);
        }

        if ($request->hasFile('cover')) {
            if ($program->cover) {
                Storage::disk('public')->delete($program->cover);
            }
            $data['cover'] = $request->file('cover')->store('programs', 'public');
        }

        $program->update($data);
        activity_log('program.update', $program, ['name' => $program->name]);

        return redirect()->route('admin.programs.index')->with('flash', ['type' => 'success', 'message' => 'Program pendidikan berhasil diperbarui']);
    }

    public function destroy(EducationProgram $program)
    {
        activity_log('program.delete', $program, ['name' => $program->name]);
        $program->delete();

        return back()->with('flash', ['type' => 'success', 'message' => 'Program pendidikan dipindahkan ke sampah']);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'icon' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:5000'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'status' => ['required', Rule::in(EducationProgram::STATUSES)],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    private function uniqueSlug(string $name, ?EducationProgram $ignore = null): string
    {
        $base = Str::slug($name) ?: Str::random(8);
        $slug = $base;
        $suffix = 2;
        while (EducationProgram::withTrashed()->where('slug', $slug)->when($ignore, fn ($query) => $query->whereKeyNot($ignore->id))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
