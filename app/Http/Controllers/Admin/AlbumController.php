<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AlbumController extends Controller
{
    public function index(Request $request)
    {
        $albums = Album::query()
            ->withCount('photos')
            ->when($request->filled('q'), function ($query) use ($request) {
                $q = $request->string('q');
                $query->where(function ($qBuilder) use ($q) {
                    $qBuilder->where('name', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%")
                        ->orWhere('category', 'like', "%{$q}%");
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest('album_date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.gallery.albums.index', compact('albums'));
    }

    public function create()
    {
        return view('admin.gallery.albums.form', [
            'album' => new Album([
                'status' => 'published',
                'album_date' => now()->toDateString(),
                'category' => 'Kegiatan',
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateAlbum($request);
        $data['slug'] = $this->uniqueSlug(($data['slug'] ?? '') ?: $data['name']);

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('gallery/albums', 'public');
        }

        $album = null;
        DB::transaction(function () use ($request, $data, &$album) {
            $photos = $request->file('photos', []);
            $captions = $request->input('captions', []);

            $album = Album::create($data);

            if (! empty($photos)) {
                $firstPhotoPath = null;
                foreach ($photos as $index => $photoFile) {
                    if ($photoFile && $photoFile->isValid()) {
                        $path = $photoFile->store('gallery/photos', 'public');
                        $caption = $captions[$index] ?? null;

                        Photo::create([
                            'album_id' => $album->id,
                            'image' => $path,
                            'caption' => $caption,
                            'order' => $index + 1,
                        ]);

                        if ($firstPhotoPath === null) {
                            $firstPhotoPath = $path;
                        }
                    }
                }

                if (empty($album->cover) && $firstPhotoPath) {
                    $album->update(['cover' => $firstPhotoPath]);
                }
            }
        });

        activity_log('gallery.album.create', $album, ['name' => $album->name]);

        return redirect()->route('admin.gallery.albums.index')->with('flash', [
            'type' => 'success',
            'message' => 'Album foto berhasil ditambahkan',
        ]);
    }

    public function edit(Album $album)
    {
        return view('admin.gallery.albums.form', [
            'album' => $album->load('photos'),
        ]);
    }

    public function update(Request $request, Album $album)
    {
        $data = $this->validateAlbum($request);
        $data['slug'] = $this->uniqueSlug(($data['slug'] ?? '') ?: $data['name'], $album);

        $oldCover = null;
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('gallery/albums', 'public');
            $oldCover = $album->cover;
        }

        DB::transaction(function () use ($request, $data, $album) {
            $album->update($data);

            // Handle deleted photos
            $deletedPhotoIds = $request->input('delete_photos', []);
            if (! empty($deletedPhotoIds)) {
                $photosToDelete = Photo::where('album_id', $album->id)
                    ->whereIn('id', $deletedPhotoIds)
                    ->get();

                foreach ($photosToDelete as $photo) {
                    if ($photo->image) {
                        Storage::disk('public')->delete($photo->image);
                    }
                    $photo->delete();
                }
            }

            // Update existing photo captions and orders
            $existingCaptions = $request->input('existing_captions', []);
            $existingOrders = $request->input('existing_orders', []);

            foreach ($album->photos()->get() as $photo) {
                if (in_array($photo->id, $deletedPhotoIds)) {
                    continue;
                }
                $updates = [];
                if (isset($existingCaptions[$photo->id])) {
                    $updates['caption'] = $existingCaptions[$photo->id];
                }
                if (isset($existingOrders[$photo->id])) {
                    $updates['order'] = (int) $existingOrders[$photo->id];
                }
                if (! empty($updates)) {
                    $photo->update($updates);
                }
            }

            // Add new uploaded photos
            $newPhotos = $request->file('new_photos', []);
            $newCaptions = $request->input('new_captions', []);
            $currentMaxOrder = (int) $album->photos()->max('order');

            if (! empty($newPhotos)) {
                foreach ($newPhotos as $index => $photoFile) {
                    if ($photoFile && $photoFile->isValid()) {
                        $path = $photoFile->store('gallery/photos', 'public');
                        $caption = $newCaptions[$index] ?? null;

                        Photo::create([
                            'album_id' => $album->id,
                            'image' => $path,
                            'caption' => $caption,
                            'order' => $currentMaxOrder + $index + 1,
                        ]);
                    }
                }
            }

            // If album has no cover but has photos, set first photo as cover
            if (empty($album->cover)) {
                $firstPhoto = $album->photos()->first();
                if ($firstPhoto) {
                    $album->update(['cover' => $firstPhoto->image]);
                }
            }
        });

        if ($oldCover) {
            Storage::disk('public')->delete($oldCover);
        }

        activity_log('gallery.album.update', $album, ['name' => $album->name]);

        return redirect()->route('admin.gallery.albums.index')->with('flash', [
            'type' => 'success',
            'message' => 'Album foto berhasil diperbarui',
        ]);
    }

    public function destroy(Album $album)
    {
        activity_log('gallery.album.delete', $album, ['name' => $album->name]);
        $album->delete();

        return back()->with('flash', [
            'type' => 'success',
            'message' => 'Album foto berhasil dipindahkan ke sampah',
        ]);
    }

    public function destroyPhoto(Photo $photo)
    {
        $album = $photo->album;
        if ($photo->image) {
            Storage::disk('public')->delete($photo->image);
        }
        $photo->delete();

        if ($album) {
            activity_log('gallery.photo.delete', $album, ['photo_id' => $photo->id]);
        }

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('flash', [
            'type' => 'success',
            'message' => 'Foto berhasil dihapus dari album',
        ]);
    }

    private function validateAlbum(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'category' => ['nullable', 'string', 'max:50'],
            'album_date' => ['nullable', 'date'],
            'status' => ['required', Rule::in(Album::STATUSES)],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'photos' => ['nullable', 'array'],
            'photos.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'captions' => ['nullable', 'array'],
            'captions.*' => ['nullable', 'string', 'max:255'],
            'new_photos' => ['nullable', 'array'],
            'new_photos.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'new_captions' => ['nullable', 'array'],
            'new_captions.*' => ['nullable', 'string', 'max:255'],
            'existing_captions' => ['nullable', 'array'],
            'existing_captions.*' => ['nullable', 'string', 'max:255'],
            'existing_orders' => ['nullable', 'array'],
            'existing_orders.*' => ['nullable', 'integer', 'min:0'],
            'delete_photos' => ['nullable', 'array'],
            'delete_photos.*' => ['nullable', 'integer'],
        ]);
    }

    private function uniqueSlug(string $title, ?Album $ignore = null): string
    {
        $base = Str::slug($title) ?: Str::random(8);
        $slug = $base;
        $suffix = 2;
        while (Album::withTrashed()->where('slug', $slug)->when($ignore, fn ($query) => $query->whereKeyNot($ignore->id))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
