<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Setting;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    private const SECTIONS = [
        'tentang' => ['slug' => 'tentang-madrasah', 'title' => 'Tentang Madrasah', 'public_route' => 'about'],
        'sejarah' => ['slug' => 'sejarah', 'title' => 'Sejarah Madrasah', 'public_route' => 'sejarah'],
        'visi-misi' => ['slug' => 'visi-misi', 'title' => 'Visi dan Misi', 'public_route' => 'visi-misi'],
    ];

    public function index()
    {
        $pages = Page::whereIn('slug', array_column(self::SECTIONS, 'slug'))->get()->keyBy('slug');
        $sections = collect(self::SECTIONS)->map(fn ($section, $key) => $section + ['key' => $key, 'page' => $pages->get($section['slug'])]);
        $principalComplete = filled(Setting::get('principal.name')) && filled(Setting::get('principal.speech'));
        $memberCount = Teacher::where('is_in_structure', true)->count();

        return view('admin.profile.index', compact('sections', 'principalComplete', 'memberCount'));
    }

    public function edit(string $section)
    {
        $config = $this->section($section);
        $page = Page::where('slug', $config['slug'])->first() ?? new Page([
            'title' => $config['title'], 'slug' => $config['slug'], 'status' => 'draft', 'template' => 'default',
        ]);

        return view('admin.profile.page-form', compact('section', 'config', 'page'));
    }

    public function update(Request $request, string $section)
    {
        $config = $this->section($section);
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'status' => ['required', Rule::in(Page::STATUSES)],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:320'],
        ]);
        $page = Page::withTrashed()->where('slug', $config['slug'])->first();
        if ($page?->trashed()) {
            $page->restore();
        }
        $page ??= new Page(['slug' => $config['slug'], 'template' => 'default', 'order' => 0]);
        $data['body'] = clean($data['body']);
        $data['author_id'] = $request->user()->id;
        if ($request->hasFile('cover')) {
            if ($page->cover) {
                Storage::disk('public')->delete($page->cover);
            }
            $data['cover'] = $request->file('cover')->store('pages', 'public');
        }
        $page->fill($data)->save();
        activity_log('profile.page.update', $page, ['section' => $section]);

        return redirect()->route('admin.profile.index')->with('flash', ['type' => 'success', 'message' => $config['title'].' diperbarui']);
    }

    private function section(string $section): array
    {
        abort_unless(isset(self::SECTIONS[$section]), 404);

        return self::SECTIONS[$section];
    }
}
