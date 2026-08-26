<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentOrganization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StudentOrganizationController extends Controller
{
    public function index(Request $request)
    {
        $organizations = StudentOrganization::query()
            ->when($request->filled('q'), fn ($query) => $query->where('name', 'like', '%'.$request->string('q').'%'))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->orderBy('order')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.organizations.index', compact('organizations'));
    }

    public function create()
    {
        return view('admin.organizations.form', [
            'organization' => new StudentOrganization(['status' => 'active', 'order' => 0]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('organizations', 'public');
        }
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('organizations', 'public');
        }

        $org = StudentOrganization::create($data);
        activity_log('organization.create', $org, ['name' => $org->name]);

        return redirect()->route('admin.organizations.index')->with('flash', ['type' => 'success', 'message' => 'Organisasi siswa berhasil ditambahkan']);
    }

    public function edit(StudentOrganization $organization)
    {
        return view('admin.organizations.form', compact('organization'));
    }

    public function update(Request $request, StudentOrganization $organization)
    {
        $data = $this->validated($request);
        if ($organization->name !== $data['name']) {
            $data['slug'] = $this->uniqueSlug($data['name'], $organization);
        }

        if ($request->hasFile('logo')) {
            if ($organization->logo) {
                Storage::disk('public')->delete($organization->logo);
            }
            $data['logo'] = $request->file('logo')->store('organizations', 'public');
        }

        if ($request->hasFile('photo')) {
            if ($organization->photo) {
                Storage::disk('public')->delete($organization->photo);
            }
            $data['photo'] = $request->file('photo')->store('organizations', 'public');
        }

        $organization->update($data);
        activity_log('organization.update', $organization, ['name' => $organization->name]);

        return redirect()->route('admin.organizations.index')->with('flash', ['type' => 'success', 'message' => 'Organisasi siswa berhasil diperbarui']);
    }

    public function destroy(StudentOrganization $organization)
    {
        activity_log('organization.delete', $organization, ['name' => $organization->name]);
        $organization->delete();

        return back()->with('flash', ['type' => 'success', 'message' => 'Organisasi siswa dipindahkan ke sampah']);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'structure' => ['nullable', 'string', 'max:5000'],
            'work_program' => ['nullable', 'string', 'max:5000'],
            'activities' => ['nullable', 'string', 'max:5000'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    private function uniqueSlug(string $name, ?StudentOrganization $ignore = null): string
    {
        $base = Str::slug($name) ?: Str::random(8);
        $slug = $base;
        $suffix = 2;
        while (StudentOrganization::withTrashed()->where('slug', $slug)->when($ignore, fn ($query) => $query->whereKeyNot($ignore->id))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
