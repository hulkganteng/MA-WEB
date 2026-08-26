<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CurriculumController extends Controller
{
    public function index(Request $request)
    {
        $curriculums = Curriculum::query()
            ->when($request->filled('q'), fn ($query) => $query->where('title', 'like', '%'.$request->string('q').'%'))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->orderBy('order')
            ->orderBy('title')
            ->paginate(15)
            ->withQueryString();

        return view('admin.curriculums.index', compact('curriculums'));
    }

    public function create()
    {
        return view('admin.curriculums.form', [
            'curriculum' => new Curriculum(['status' => 'active', 'order' => 0, 'academic_year' => '2026/2027']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $data['document'] = $file->store('curriculums', 'public');
            $data['document_name'] = $file->getClientOriginalName();
        }

        $curriculum = Curriculum::create($data);
        activity_log('curriculum.create', $curriculum, ['title' => $curriculum->title]);

        return redirect()->route('admin.curriculums.index')->with('flash', ['type' => 'success', 'message' => 'Kurikulum berhasil ditambahkan']);
    }

    public function edit(Curriculum $curriculum)
    {
        return view('admin.curriculums.form', compact('curriculum'));
    }

    public function update(Request $request, Curriculum $curriculum)
    {
        $data = $this->validated($request);
        if ($curriculum->title !== $data['title']) {
            $data['slug'] = $this->uniqueSlug($data['title'], $curriculum);
        }

        if ($request->hasFile('document')) {
            if ($curriculum->document) {
                Storage::disk('public')->delete($curriculum->document);
            }
            $file = $request->file('document');
            $data['document'] = $file->store('curriculums', 'public');
            $data['document_name'] = $file->getClientOriginalName();
        }

        $curriculum->update($data);
        activity_log('curriculum.update', $curriculum, ['title' => $curriculum->title]);

        return redirect()->route('admin.curriculums.index')->with('flash', ['type' => 'success', 'message' => 'Kurikulum berhasil diperbarui']);
    }

    public function destroy(Curriculum $curriculum)
    {
        activity_log('curriculum.delete', $curriculum, ['title' => $curriculum->title]);
        $curriculum->delete();

        return back()->with('flash', ['type' => 'success', 'message' => 'Kurikulum dipindahkan ke sampah']);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'academic_year' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:5000'],
            'document' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,zip', 'max:10240'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    private function uniqueSlug(string $title, ?Curriculum $ignore = null): string
    {
        $base = Str::slug($title) ?: Str::random(8);
        $slug = $base;
        $suffix = 2;
        while (Curriculum::withTrashed()->where('slug', $slug)->when($ignore, fn ($query) => $query->whereKeyNot($ignore->id))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
