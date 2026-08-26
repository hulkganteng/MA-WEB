<?php

namespace Tests\Feature;

use App\Models\Album;
use App\Models\Photo;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CmsGalleryTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_cms_gallery_pages_render_for_authorized_user(): void
    {
        $this->actingAs($this->admin());

        $this->get(route('admin.gallery.albums.index'))->assertOk()->assertSee('Kelola galeri foto');
        $this->get(route('admin.gallery.albums.create'))->assertOk()->assertSee('Tambah Album Foto');
        $this->get(route('admin.gallery.videos.index'))->assertOk()->assertSee('Kelola galeri video');
        $this->get(route('admin.gallery.videos.create'))->assertOk()->assertSee('Tambah Video Galeri');
    }

    public function test_admin_can_create_photo_album_with_multiple_photos_and_captions(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin())->post(route('admin.gallery.albums.store'), [
            'name' => 'Dokumentasi Matsama 2026',
            'category' => 'Kegiatan',
            'album_date' => '2026-08-26',
            'description' => 'Kegiatan Masa Ta\'aruf Siswa Madrasah tahun ajaran 2026/2027.',
            'status' => 'published',
            'cover' => UploadedFile::fake()->image('cover_matsama.jpg', 1200, 800),
            'photos' => [
                UploadedFile::fake()->image('foto1.jpg', 800, 600),
                UploadedFile::fake()->image('foto2.jpg', 800, 600),
            ],
            'captions' => [
                'Upacara pembukaan Matsama',
                'Pemberian materi keaswajaan',
            ],
        ]);

        $response->assertRedirect(route('admin.gallery.albums.index'))->assertSessionHasNoErrors();

        $album = Album::where('name', 'Dokumentasi Matsama 2026')->firstOrFail();
        $this->assertSame('published', $album->status);
        $this->assertCount(2, $album->photos);
        Storage::disk('public')->assertExists($album->cover);

        $photo1 = $album->photos()->where('caption', 'Upacara pembukaan Matsama')->first();
        $this->assertNotNull($photo1);
        Storage::disk('public')->assertExists($photo1->image);

        // Verify public gallery page displays the new album
        $this->get(route('gallery.photos'))->assertOk()->assertSee('Dokumentasi Matsama 2026');
        $this->get(route('gallery.album', $album))->assertOk()->assertSee('Upacara pembukaan Matsama');
    }

    public function test_admin_can_update_album_and_manage_photos(): void
    {
        Storage::fake('public');

        $album = Album::create([
            'name' => 'Album Lama',
            'slug' => 'album-lama',
            'description' => 'Deskripsi lama',
            'category' => 'Kegiatan',
            'album_date' => '2026-08-20',
            'status' => 'published',
            'cover' => 'gallery/albums/old_cover.jpg',
        ]);

        $photo = Photo::create([
            'album_id' => $album->id,
            'image' => 'gallery/photos/old_photo.jpg',
            'caption' => 'Caption awal',
            'order' => 1,
        ]);

        $response = $this->actingAs($this->admin())->put(route('admin.gallery.albums.update', $album), [
            'name' => 'Album Diperbarui',
            'category' => 'Pembelajaran',
            'album_date' => '2026-08-25',
            'description' => 'Deskripsi baru',
            'status' => 'published',
            'existing_captions' => [
                $photo->id => 'Caption diperbarui',
            ],
            'existing_orders' => [
                $photo->id => 2,
            ],
            'new_photos' => [
                UploadedFile::fake()->image('foto_baru.jpg', 800, 600),
            ],
            'new_captions' => [
                'Foto baru ditambahkan',
            ],
        ]);

        $response->assertRedirect(route('admin.gallery.albums.index'))->assertSessionHasNoErrors();

        $album->refresh();
        $this->assertSame('Album Diperbarui', $album->name);
        $this->assertSame('Caption diperbarui', $photo->fresh()->caption);
        $this->assertSame(2, $photo->fresh()->order);
        $this->assertCount(2, $album->photos);
    }

    public function test_admin_can_delete_single_photo_from_album(): void
    {
        Storage::fake('public');

        $album = Album::create([
            'name' => 'Album Test',
            'slug' => 'album-test',
            'status' => 'published',
        ]);

        $photo = Photo::create([
            'album_id' => $album->id,
            'image' => 'gallery/photos/photo_to_delete.jpg',
            'caption' => 'Foto akan dihapus',
            'order' => 1,
        ]);

        $response = $this->actingAs($this->admin())->delete(route('admin.gallery.photos.destroy', $photo));

        $response->assertRedirect()->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('photos', ['id' => $photo->id]);
    }

    public function test_admin_can_create_and_update_gallery_video(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin())->post(route('admin.gallery.videos.store'), [
            'title' => 'Video Profil Madrasah 2026',
            'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'provider' => 'youtube',
            'category' => 'Profil Madrasah',
            'video_date' => '2026-08-26',
            'description' => 'Video profil resmi MA Ma\'arif NU Assa\'adah.',
            'status' => 'published',
            'thumbnail' => UploadedFile::fake()->image('custom_thumb.jpg', 1280, 720),
        ]);

        $response->assertRedirect(route('admin.gallery.videos.index'))->assertSessionHasNoErrors();

        $video = Video::where('title', 'Video Profil Madrasah 2026')->firstOrFail();
        $this->assertSame('https://www.youtube.com/embed/dQw4w9WgXcQ', $video->embed_url);
        Storage::disk('public')->assertExists($video->getRawOriginal('thumbnail'));

        // Verify public video gallery displays the video
        $this->get(route('gallery.videos'))->assertOk()->assertSee('Video Profil Madrasah 2026');

        // Test updating video
        $updateResponse = $this->actingAs($this->admin())->put(route('admin.gallery.videos.update', $video), [
            'title' => 'Video Profil Madrasah 2026 (Revisi)',
            'url' => 'https://youtu.be/dQw4w9WgXcQ',
            'provider' => 'youtube',
            'category' => 'Profil',
            'video_date' => '2026-08-26',
            'description' => 'Deskripsi video revisi.',
            'status' => 'published',
        ]);

        $updateResponse->assertRedirect(route('admin.gallery.videos.index'))->assertSessionHasNoErrors();
        $this->assertSame('Video Profil Madrasah 2026 (Revisi)', $video->fresh()->title);
    }

    public function test_admin_can_delete_video(): void
    {
        $video = Video::create([
            'title' => 'Video Akan Dihapus',
            'slug' => 'video-akan-dihapus',
            'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'status' => 'published',
        ]);

        $response = $this->actingAs($this->admin())->delete(route('admin.gallery.videos.destroy', $video));
        $response->assertRedirect()->assertSessionHasNoErrors();

        $this->assertSoftDeleted('videos', ['id' => $video->id]);
    }

    private function admin(): User
    {
        return User::where('email', 'admin@ma-assaadah.sch.id')->firstOrFail();
    }
}
