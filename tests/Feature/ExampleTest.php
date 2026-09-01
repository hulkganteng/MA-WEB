<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_homepage_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Berita terbaru')
            ->assertSee('<link rel="canonical"', false)
            ->assertSee('application/ld+json', false);

        $this->assertSame(1, substr_count($response->getContent(), '<h1'));
    }

    public function test_crawler_endpoints_and_private_indexing_rules_are_available(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertSee('Disallow: /admin/')
            ->assertSee(route('sitemap'));

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('<urlset', false)
            ->assertSee(route('home'));

        $this->get('/cari')
            ->assertOk()
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow')
            ->assertSee('noindex, follow');
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
