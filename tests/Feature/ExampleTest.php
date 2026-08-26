<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_homepage_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Membentuk Generasi Berilmu')
            ->assertSee('Berita terbaru');
    }

    public function test_public_information_pages_are_available(): void
    {
        $paths = [
            '/profil',
            '/profil/visi-misi',
            '/profil/sambutan-kepala',
            '/profil/struktur-organisasi',
            '/guru',
            '/fasilitas',
            '/program',
            '/program/unggulan',
            '/akademik/kurikulum',
            '/akademik/kalender',
            '/kesiswaan/ekstrakurikuler',
            '/kesiswaan/organisasi',
            '/galeri/foto',
            '/galeri/video',
            '/alumni',
            '/download',
            '/kontak',
            '/cari?q=contoh',
        ];

        foreach ($paths as $path) {
            $this->get($path)->assertOk();
        }
    }
}
