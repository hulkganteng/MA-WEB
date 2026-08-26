<?php

namespace Tests\Feature;

use App\Models\OrganizationMember;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CmsIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_admin_can_publish_news_and_it_appears_on_public_website(): void
    {
        $admin = User::where('email', 'admin@ma-assaadah.sch.id')->firstOrFail();

        $response = $this->actingAs($admin)->post(route('admin.posts.store'), [
            'type' => 'berita',
            'title' => 'Berita dari CMS',
            'slug' => 'berita-dari-cms',
            'excerpt' => 'Ringkasan berita yang dibuat melalui CMS.',
            'body' => '<p>Konten berita dari CMS.</p>',
            'status' => 'published',
            'published_at' => now()->format('Y-m-d H:i:s'),
            'is_featured' => false,
        ]);

        $response->assertRedirect(route('admin.posts.index', ['type' => 'berita']));
        $post = Post::where('slug', 'berita-dari-cms')->firstOrFail();

        $this->get(route('berita.show', $post))
            ->assertOk()
            ->assertSee('Berita dari CMS')
            ->assertSee('Konten berita dari CMS');
    }

    public function test_admin_cms_pages_render(): void
    {
        $admin = User::where('email', 'admin@ma-assaadah.sch.id')->firstOrFail();

        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk()->assertSee('Ringkasan website');
        $this->get(route('admin.posts.index', ['type' => 'berita']))->assertOk()->assertSee('Kelola berita');
        $this->get(route('admin.posts.create', ['type' => 'artikel']))->assertOk()->assertSee('Tambah artikel');
        $this->get(route('admin.pages.index'))->assertOk()->assertSee('Kelola halaman');
        $this->get(route('admin.profile.index'))->assertOk()->assertSee('Kelola profil madrasah');
        $this->get(route('admin.profile.pages.edit', 'tentang'))->assertOk()->assertSee('Tentang Madrasah');
        $this->get(route('admin.profile.principal.edit'))->assertOk()->assertSee('Sambutan kepala madrasah');
        $this->get(route('admin.profile.structure.index'))->assertOk()->assertSee('Struktur organisasi');
        $this->get(route('admin.settings.edit'))->assertOk()->assertSee('Pengaturan website');
        $this->get(route('admin.account.edit'))->assertOk()->assertSee('Akun saya');
    }

    public function test_admin_can_update_profile_page_and_publish_it(): void
    {
        $admin = User::where('email', 'admin@ma-assaadah.sch.id')->firstOrFail();

        $this->actingAs($admin)->put(route('admin.profile.pages.update', 'tentang'), [
            'title' => 'Tentang Madrasah Kami',
            'body' => '<p>Profil resmi diperbarui dari menu profil CMS.</p>',
            'status' => 'published',
            'seo_title' => 'Tentang MA Assa’adah',
            'seo_description' => 'Profil resmi madrasah.',
        ])->assertRedirect(route('admin.profile.index'));

        $this->assertDatabaseHas('pages', ['slug' => 'tentang-madrasah', 'status' => 'published']);
        $this->get(route('about'))->assertOk()->assertSee('Profil resmi diperbarui dari menu profil CMS.');
    }

    public function test_admin_can_update_principal_profile(): void
    {
        $admin = User::where('email', 'admin@ma-assaadah.sch.id')->firstOrFail();

        $this->actingAs($admin)->put(route('admin.profile.principal.update'), [
            'name' => 'Dr. Kepala Baru',
            'position' => 'Kepala Madrasah',
            'speech' => '<p>Sambutan terbaru dari CMS profil.</p>',
        ])->assertRedirect(route('admin.profile.index'));

        $this->get(route('sambutan'))->assertOk()->assertSee('Dr. Kepala Baru')->assertSee('Sambutan terbaru dari CMS profil.');
    }

    public function test_admin_can_manage_public_organization_structure(): void
    {
        $admin = User::where('email', 'admin@ma-assaadah.sch.id')->firstOrFail();

        $this->actingAs($admin)->post(route('admin.profile.structure.store'), [
            'name' => 'Ketua Struktur',
            'position' => 'Kepala Madrasah',
            'order' => 1,
            'is_active' => 1,
        ])->assertRedirect(route('admin.profile.structure.index'));

        $parent = OrganizationMember::where('name', 'Ketua Struktur')->firstOrFail();
        $this->post(route('admin.profile.structure.store'), [
            'name' => 'Anggota Tersembunyi',
            'position' => 'Staf',
            'parent_id' => $parent->id,
            'order' => 2,
        ])->assertRedirect(route('admin.profile.structure.index'));

        $this->get(route('structure'))->assertOk()->assertSee('Ketua Struktur')->assertDontSee('Anggota Tersembunyi');
    }

    public function test_unknown_profile_section_returns_not_found(): void
    {
        $admin = User::where('email', 'admin@ma-assaadah.sch.id')->firstOrFail();
        $this->actingAs($admin)->get(route('admin.profile.pages.edit', 'tidak-ada'))->assertNotFound();
    }

    public function test_admin_can_update_global_settings_used_by_homepage(): void
    {
        $admin = User::where('email', 'admin@ma-assaadah.sch.id')->firstOrFail();
        $response = $this->actingAs($admin)->put(route('admin.settings.update'), [
            'site_name' => 'MA CMS Terintegrasi', 'site_tagline' => 'Tagline pengujian', 'academic_year' => '2026/2027', 'copyright' => 'Madrasah',
            'address' => 'Gresik', 'email' => 'admin@example.test', 'phone' => '031000000', 'whatsapp' => '0812000000', 'maps_url' => 'https://maps.google.com', 'hours' => 'Senin–Jumat',
            'hero_title' => 'Judul dari pengaturan CMS', 'hero_subtitle' => 'Subjudul dari pengaturan CMS.',
            'principal_name' => 'Kepala Madrasah', 'principal_position' => 'Kepala', 'principal_speech' => 'Sambutan.',
            'seo_title' => 'SEO Madrasah', 'seo_description' => 'Deskripsi SEO madrasah untuk pengujian.', 'whatsapp_message' => 'Halo.',
        ]);

        $response->assertRedirect();
        $this->get(route('home'))->assertOk()->assertSee('Judul dari pengaturan CMS');
    }

    public function test_admin_can_change_own_password(): void
    {
        $admin = User::where('email', 'admin@ma-assaadah.sch.id')->firstOrFail();

        $this->actingAs($admin)->put(route('admin.account.update'), [
            'name' => $admin->name, 'email' => $admin->email,
            'current_password' => 'password', 'password' => 'KataSandiBaru123', 'password_confirmation' => 'KataSandiBaru123',
        ])->assertRedirect();

        $this->assertTrue(Hash::check('KataSandiBaru123', $admin->fresh()->password));
    }

    public function test_guest_cannot_access_cms(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
    }

    public function test_user_without_permission_cannot_access_cms(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
    }
}
