<?php

namespace Tests\Feature;

use App\Models\OrganizationMember;
use App\Models\Page;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CmsImageUploadTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_teacher_photo_is_saved_to_public_storage(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())->post(route('admin.teachers.store'), [
            'name' => 'Guru dengan Foto',
            'type' => 'guru',
            'position' => 'Guru',
            'subject' => 'Bahasa Indonesia',
            'education' => 'S1 Pendidikan',
            'order' => 1,
            'is_active' => 1,
            'is_public' => 1,
            'photo' => UploadedFile::fake()->image('guru.jpg', 600, 750),
        ])->assertSessionHasNoErrors();

        $teacher = Teacher::where('name', 'Guru dengan Foto')->firstOrFail();
        Storage::disk('public')->assertExists($teacher->photo);
    }

    public function test_post_and_profile_covers_are_saved_to_public_storage(): void
    {
        Storage::fake('public');
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.posts.store'), [
            'type' => 'berita',
            'title' => 'Berita Bergambar',
            'body' => '<p>Isi berita.</p>',
            'status' => 'draft',
            'cover' => UploadedFile::fake()->image('cover.png', 1200, 675),
            'og_image' => UploadedFile::fake()->image('og.webp', 1200, 630),
        ])->assertRedirect(route('admin.posts.index', ['type' => 'berita']))->assertSessionHasNoErrors();

        $post = Post::where('title', 'Berita Bergambar')->firstOrFail();
        Storage::disk('public')->assertExists([$post->cover, $post->og_image]);

        $this->put(route('admin.profile.pages.update', 'tentang'), [
            'title' => 'Tentang Madrasah',
            'body' => '<p>Profil madrasah.</p>',
            'status' => 'published',
            'cover' => UploadedFile::fake()->image('profil.jpg', 1200, 675),
        ])->assertSessionHasNoErrors();

        Storage::disk('public')->assertExists(Page::where('slug', 'tentang-madrasah')->firstOrFail()->cover);
    }

    public function test_principal_and_organization_photos_are_saved_to_public_storage(): void
    {
        Storage::fake('public');
        $admin = $this->admin();

        $this->actingAs($admin)->put(route('admin.profile.principal.update'), [
            'name' => 'Kepala Madrasah',
            'position' => 'Kepala',
            'speech' => '<p>Sambutan.</p>',
            'photo' => UploadedFile::fake()->image('kepala.jpg', 600, 750),
        ])->assertSessionHasNoErrors();
        Storage::disk('public')->assertExists(Setting::get('principal.photo'));

        $this->post(route('admin.profile.structure.store'), [
            'name' => 'Pimpinan Struktur',
            'position' => 'Ketua',
            'order' => 1,
            'is_active' => 1,
            'photo' => UploadedFile::fake()->image('struktur.png', 600, 600),
        ])->assertSessionHasNoErrors();

        Storage::disk('public')->assertExists(OrganizationMember::where('name', 'Pimpinan Struktur')->firstOrFail()->photo);
    }

    public function test_website_setting_images_are_saved_to_public_storage(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())->put(route('admin.settings.update'), [
            'site_name' => 'MA Assa’adah',
            'site_tagline' => 'Madrasah unggul',
            'academic_year' => '2026/2027',
            'copyright' => 'MA Assa’adah',
            'address' => 'Gresik',
            'email' => 'admin@example.test',
            'phone' => '031000000',
            'whatsapp' => '0812000000',
            'maps_url' => 'https://maps.google.com',
            'hours' => 'Senin–Jumat',
            'hero_title' => 'Selamat datang',
            'hero_subtitle' => 'Website resmi madrasah.',
            'principal_name' => 'Kepala Madrasah',
            'principal_position' => 'Kepala',
            'principal_speech' => 'Sambutan.',
            'seo_title' => 'MA Assa’adah',
            'seo_description' => 'Website resmi MA Assa’adah.',
            'whatsapp_message' => 'Halo.',
            'logo' => UploadedFile::fake()->image('logo.png', 512, 512),
            'favicon' => UploadedFile::fake()->image('favicon.png', 64, 64),
            'principal_photo' => UploadedFile::fake()->image('kepala.webp', 600, 750),
        ])->assertSessionHasNoErrors();

        Storage::disk('public')->assertExists([
            Setting::get('site.logo'),
            Setting::get('site.favicon'),
            Setting::get('principal.photo'),
        ]);
    }

    public function test_unsupported_file_gets_a_clear_upload_error(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())->post(route('admin.teachers.store'), [
            'name' => 'Guru File Tidak Valid',
            'type' => 'guru',
            'order' => 1,
            'is_active' => 1,
            'is_public' => 1,
            'photo' => UploadedFile::fake()->create('foto.svg', 20, 'image/svg+xml'),
        ])->assertSessionHasErrors('photo');

        $this->assertDatabaseMissing('teachers', ['name' => 'Guru File Tidak Valid']);
    }

    private function admin(): User
    {
        return User::where('email', 'admin@ma-assaadah.sch.id')->firstOrFail();
    }
}
