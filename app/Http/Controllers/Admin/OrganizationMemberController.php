<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrganizationMemberController extends Controller
{
    public function index(Request $request)
    {
        $members = Teacher::where('is_in_structure', true)->with('parent')->orderBy('structure_parent_id')->orderBy('structure_order')->orderBy('name')->get();
        $editing = $request->filled('edit') ? Teacher::where('is_in_structure', true)->findOrFail($request->integer('edit')) : null;
        $parents = Teacher::where('is_in_structure', true)->whereNull('structure_parent_id')->when($editing, fn ($query) => $query->whereKeyNot($editing->id))->orderBy('structure_order')->get();
        $teachers = Teacher::where('is_active', true)->where('is_in_structure', false)->orderBy('type')->orderBy('order')->orderBy('name')->get();

        return view('admin.profile.structure', compact('members', 'editing', 'parents', 'teachers'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $member = Teacher::findOrFail($data['teacher_id']);
        $member->update([
            'is_in_structure' => true,
            'structure_parent_id' => $data['structure_parent_id'] ?? null,
            'structure_order' => $data['structure_order'],
        ]);
        activity_log('structure.create', $member, ['name' => $member->name]);

        return redirect()->route('admin.profile.structure.index')->with('flash', ['type' => 'success', 'message' => 'Anggota struktur ditambahkan']);
    }

    public function update(Request $request, Teacher $teacher)
    {
        abort_unless($teacher->is_in_structure, 404);
        $data = $this->validated($request, $teacher);
        if ($teacher->children()->where('is_in_structure', true)->exists() && filled($data['structure_parent_id'])) {
            return back()->withInput()->withErrors(['structure_parent_id' => 'Anggota yang memiliki bawahan harus tetap berada di tingkat utama.']);
        }
        $teacher->update([
            'structure_parent_id' => $data['structure_parent_id'] ?? null,
            'structure_order' => $data['structure_order'],
        ]);
        activity_log('structure.update', $teacher, ['name' => $teacher->name]);

        return redirect()->route('admin.profile.structure.index')->with('flash', ['type' => 'success', 'message' => 'Anggota struktur diperbarui']);
    }

    public function destroy(Teacher $teacher)
    {
        abort_unless($teacher->is_in_structure, 404);
        $teacher->children()->update(['structure_parent_id' => null]);
        $teacher->update(['is_in_structure' => false, 'structure_parent_id' => null, 'structure_order' => 0]);
        activity_log('structure.delete', $teacher, ['name' => $teacher->name]);

        return redirect()->route('admin.profile.structure.index')->with('flash', ['type' => 'success', 'message' => 'Anggota struktur dihapus']);
    }

    private function validated(Request $request, ?Teacher $member = null): array
    {
        $data = $request->validate([
            'teacher_id' => [$member ? 'nullable' : 'required', 'integer', Rule::exists('teachers', 'id')->where(fn ($query) => $query->whereNull('deleted_at')->where('is_active', true)->where('is_in_structure', false))],
            'structure_parent_id' => ['nullable', 'integer', Rule::exists('teachers', 'id')->where(fn ($query) => $query->whereNull('deleted_at')->where('is_in_structure', true)->whereNull('structure_parent_id')), Rule::notIn(array_filter([$member?->id]))],
            'structure_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);

        return $data;
    }
}
