<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class OrganizationMemberController extends Controller
{
    public function index(Request $request)
    {
        $members = OrganizationMember::with('parent')->orderBy('parent_id')->orderBy('order')->orderBy('name')->get();
        $editing = $request->filled('edit') ? OrganizationMember::findOrFail($request->integer('edit')) : new OrganizationMember(['is_active' => true, 'order' => 0]);
        $parents = OrganizationMember::whereNull('parent_id')->whereKeyNot($editing->id)->orderBy('order')->get();

        return view('admin.profile.structure', compact('members', 'editing', 'parents'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['photo'] = $request->file('photo')?->store('organization', 'public');
        $member = OrganizationMember::create($data);
        activity_log('structure.create', $member, ['name' => $member->name]);

        return redirect()->route('admin.profile.structure.index')->with('flash', ['type' => 'success', 'message' => 'Anggota struktur ditambahkan']);
    }

    public function update(Request $request, OrganizationMember $organizationMember)
    {
        $data = $this->validated($request, $organizationMember);
        if ($organizationMember->children()->exists() && filled($data['parent_id'])) {
            return back()->withInput()->withErrors(['parent_id' => 'Anggota yang memiliki bawahan harus tetap berada di tingkat utama.']);
        }
        if ($request->hasFile('photo')) {
            if ($organizationMember->photo) {
                Storage::disk('public')->delete($organizationMember->photo);
            }
            $data['photo'] = $request->file('photo')->store('organization', 'public');
        }
        $organizationMember->update($data);
        activity_log('structure.update', $organizationMember, ['name' => $organizationMember->name]);

        return redirect()->route('admin.profile.structure.index')->with('flash', ['type' => 'success', 'message' => 'Anggota struktur diperbarui']);
    }

    public function destroy(OrganizationMember $organizationMember)
    {
        if ($organizationMember->photo) {
            Storage::disk('public')->delete($organizationMember->photo);
        }
        activity_log('structure.delete', $organizationMember, ['name' => $organizationMember->name]);
        $organizationMember->delete();

        return redirect()->route('admin.profile.structure.index')->with('flash', ['type' => 'success', 'message' => 'Anggota struktur dihapus']);
    }

    private function validated(Request $request, ?OrganizationMember $member = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable', 'integer', Rule::exists('organization_members', 'id')->whereNull('parent_id'), Rule::notIn(array_filter([$member?->id]))],
            'order' => ['required', 'integer', 'min:0', 'max:9999'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
