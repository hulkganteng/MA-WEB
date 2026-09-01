<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Rules\SafeVideoUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $videos = Video::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $q = $request->string('q');
                $query->where(function ($qBuilder) use ($q) {
                    $qBuilder->where('title', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%")
                        ->orWhere('category', 'like', "%{$q}%");
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest('video_date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.gallery.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.gallery.videos.form', [
            'video' => new Video([
                'status' => 'published',
                'provider' => 'youtube',
                'video_date' => now()->toDateString(),
                'category' => 'Kegiatan',
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateVideo($request);
        $data['slug'] = $this->uniqueSlug(($data['slug'] ?? '') ?: $data['title']);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('gallery/videos/thumbnails', 'public');
        }

        $video = Video::create($data);
        activity_log('gallery.video.create', $video, ['title' => $video->title]);

        return redirect()->route('admin.gallery.videos.index')->with('flash', [
            'type' => 'success',
            'message' => 'Video galeri berhasil ditambahkan',
        ]);
    }

    public function edit(Video $video)
    {
        return view('admin.gallery.videos.form', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $data = $this->validateVideo($request, $video);
        $data['slug'] = $this->uniqueSlug(($data['slug'] ?? '') ?: $data['title'], $video);

        if ($request->hasFile('thumbnail')) {
            $rawThumbnail = $video->getRawOriginal('thumbnail');
            if ($rawThumbnail && ! str_starts_with($rawThumbnail, 'http') && Storage::disk('public')->exists($rawThumbnail)) {
                Storage::disk('public')->delete($rawThumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('gallery/videos/thumbnails', 'public');
        }

        $video->update($data);
        activity_log('gallery.video.update', $video, ['title' => $video->title]);

        return redirect()->route('admin.gallery.videos.index')->with('flash', [
            'type' => 'success',
            'message' => 'Video galeri berhasil diperbarui',
        ]);
    }

    public function destroy(Video $video)
    {
        activity_log('gallery.video.delete', $video, ['title' => $video->title]);
        $video->delete();

        return back()->with('flash', [
            'type' => 'success',
            'message' => 'Video galeri berhasil dipindahkan ke sampah',
        ]);
    }

    private function validateVideo(Request $request, ?Video $video = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:500', 'url', new SafeVideoUrl],
            'provider' => ['nullable', 'string', 'max:30'],
            'category' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:5000'],
            'video_date' => ['nullable', 'date'],
            'status' => ['required', Rule::in(Video::STATUSES)],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);
    }

    private function uniqueSlug(string $title, ?Video $ignore = null): string
    {
        $base = Str::slug($title) ?: Str::random(8);
        $slug = $base;
        $suffix = 2;
        while (Video::withTrashed()->where('slug', $slug)->when($ignore, fn ($query) => $query->whereKeyNot($ignore->id))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
