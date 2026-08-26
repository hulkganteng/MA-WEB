<?php

namespace Tests\Feature;

use App\Models\HeroSlide;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HeroSlideTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_admin_can_view_hero_slides_index_and_create(): void
    {
        $this->actingAs($this->admin());

        $this->get(route('admin.hero-slides.index'))->assertOk()->assertSee('Kelola Hero Slider');
        $this->get(route('admin.hero-slides.create'))->assertOk()->assertSee('Tambah Slide Hero');
    }

    public function test_admin_can_create_hero_slide_with_image(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin())->post(route('admin.hero-slides.store'), [
            'title' => 'Slide Baru Dari Admin',
            'subtitle' => 'Deskripsi slide baru yang dikelola dari CMS.',
            'tagline' => 'Program Unggulan',
            'image' => UploadedFile::fake()->image('banner_hero.jpg', 1920, 1080),
            'button_text' => 'Pelajari Selengkapnya',
            'button_url' => '/profil',
            'secondary_button_text' => 'Kontak Kami',
            'secondary_button_url' => '/kontak',
            'order' => 1,
            'status' => 'published',
        ]);

        $response->assertRedirect(route('admin.hero-slides.index'))->assertSessionHasNoErrors();

        $slide = HeroSlide::where('title', 'Slide Baru Dari Admin')->firstOrFail();
        $this->assertSame('published', $slide->status);
        $this->assertSame('Program Unggulan', $slide->tagline);
        Storage::disk('public')->assertExists($slide->getRawOriginal('image'));

        // Verify public landing page renders the new slide
        $this->get(route('home'))->assertOk()->assertSee('Slide Baru Dari Admin');
    }

    public function test_admin_can_update_hero_slide(): void
    {
        Storage::fake('public');

        $slide = HeroSlide::create([
            'title' => 'Judul Awal',
            'subtitle' => 'Subtitle awal',
            'image' => 'hero-slides/old_banner.jpg',
            'status' => 'published',
            'order' => 1,
        ]);

        $response = $this->actingAs($this->admin())->put(route('admin.hero-slides.update', $slide), [
            'title' => 'Judul Setelah Diperbarui',
            'subtitle' => 'Subtitle diperbarui',
            'tagline' => 'Tagline Baru',
            'order' => 2,
            'status' => 'published',
        ]);

        $response->assertRedirect(route('admin.hero-slides.index'))->assertSessionHasNoErrors();
        $this->assertSame('Judul Setelah Diperbarui', $slide->fresh()->title);
        $this->assertSame('Tagline Baru', $slide->fresh()->tagline);
        $this->assertSame(2, $slide->fresh()->order);
    }

    public function test_admin_can_delete_hero_slide(): void
    {
        $slide = HeroSlide::create([
            'title' => 'Slide Untuk Dihapus',
            'image' => 'hero-slides/banner.jpg',
            'status' => 'published',
            'order' => 1,
        ]);

        $response = $this->actingAs($this->admin())->delete(route('admin.hero-slides.destroy', $slide));
        $response->assertRedirect()->assertSessionHasNoErrors();

        $this->assertSoftDeleted('hero_slides', ['id' => $slide->id]);
    }

    private function admin(): User
    {
        return User::where('email', 'admin@ma-assaadah.sch.id')->firstOrFail();
    }
}
