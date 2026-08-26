<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $facilities = Facility::query()
            ->when($request->filled('q'), fn ($query) => $query->where('name', 'like', '%'.$request->string('q').'%'))
            ->when($request->filled('status'), fn ($query) => $query->where('is_active', $request->string('status') === 'active'))
            ->orderBy('order')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.facilities.index', compact('facilities'));
    }

    public function create()
    {
        return view('admin.facilities.form', [
            'facility' => new Facility(['is_active' => true, 'order' => 0]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('facilities', 'public');
        }

        $facility = Facility::create($data);
        activity_log('facility.create', $facility, ['name' => $facility->name]);

        return redirect()->route('admin.facilities.index')->with('flash', ['type' => 'success', 'message' => 'Fasilitas sarpras berhasil ditambahkan']);
    }

    public function edit(Facility $facility)
    {
        return view('admin.facilities.form', compact('facility'));
    }

    public function update(Request $request, Facility $facility)
    {
        $data = $this->validated($request);
        if ($facility->name !== $data['name']) {
            $data['slug'] = $this->uniqueSlug($data['name'], $facility);
        }

        if ($request->hasFile('thumbnail')) {
            if ($facility->thumbnail) {
                Storage::disk('public')->delete($facility->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('facilities', 'public');
        }

        $facility->update($data);
        activity_log('facility.update', $facility, ['name' => $facility->name]);

        return redirect()->route('admin.facilities.index')->with('flash', ['type' => 'success', 'message' => 'Fasilitas sarpras berhasil diperbarui']);
    }

    public function destroy(Facility $facility)
    {
        activity_log('facility.delete', $facility, ['name' => $facility->name]);
        $facility->delete();

        return back()->with('flash', ['type' => 'success', 'message' => 'Fasilitas sarpras dipindahkan ke sampah']);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:5000'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'is_active' => ['required', 'boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    private function uniqueSlug(string $name, ?Facility $ignore = null): string
    {
        $base = Str::slug($name) ?: Str::random(8);
        $slug = $base;
        $suffix = 2;
        while (Facility::withTrashed()->where('slug', $slug)->when($ignore, fn ($query) => $query->whereKeyNot($ignore->id))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
