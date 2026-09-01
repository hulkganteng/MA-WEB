<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Announcement;
use App\Models\EducationProgram;
use App\Models\Event;
use App\Models\Extracurricular;
use App\Models\FeaturedProgram;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $staticRoutes = [
            'home', 'about', 'sejarah', 'visi-misi', 'sambutan', 'structure',
            'berita.index', 'artikel.index', 'pengumuman.index', 'agenda.index',
            'prestasi.index', 'programs', 'programs.featured', 'curriculum',
            'academic-calendar', 'extracurricular', 'organizations', 'guru.index',
            'facilities', 'gallery.photos', 'gallery.videos', 'alumni.index',
            'downloads.index', 'contact',
        ];

        $urls = collect($staticRoutes)->map(fn (string $name) => [
            'loc' => route($name),
            'changefreq' => $name === 'home' ? 'daily' : 'weekly',
            'priority' => $name === 'home' ? '1.0' : '0.7',
        ]);

        $urls = $urls
            ->merge(Post::published()->get(['id', 'slug', 'type', 'updated_at'])->map(fn (Post $post) => [
                'loc' => route($post->type === 'artikel' ? 'artikel.show' : 'berita.show', $post),
                'lastmod' => $post->updated_at?->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ]))
            ->merge(Announcement::published()->active()->get(['id', 'slug', 'updated_at'])->map(fn (Announcement $item) => [
                'loc' => route('pengumuman.show', $item),
                'lastmod' => $item->updated_at?->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ]))
            ->merge(Event::published()->get(['id', 'slug', 'updated_at'])->map(fn (Event $event) => [
                'loc' => route('agenda.show', $event),
                'lastmod' => $event->updated_at?->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ]))
            ->merge(EducationProgram::active()->get(['id', 'slug', 'updated_at'])->map(fn (EducationProgram $program) => [
                'loc' => route('programs.show', $program),
                'lastmod' => $program->updated_at?->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ]))
            ->merge(FeaturedProgram::active()->get(['id', 'slug', 'updated_at'])->map(fn (FeaturedProgram $program) => [
                'loc' => route('programs.featured.show', $program),
                'lastmod' => $program->updated_at?->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ]))
            ->merge(Extracurricular::active()->get(['id', 'slug', 'updated_at'])->map(fn (Extracurricular $item) => [
                'loc' => route('extracurricular.show', $item),
                'lastmod' => $item->updated_at?->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ]))
            ->merge(Album::published()->get(['id', 'slug', 'updated_at'])->map(fn (Album $album) => [
                'loc' => route('gallery.album', $album),
                'lastmod' => $album->updated_at?->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ]))
            ->merge(Page::where('status', 'published')
                ->whereNotIn('slug', ['tentang-madrasah', 'sejarah', 'visi-misi'])
                ->get(['id', 'slug', 'updated_at'])
                ->map(fn (Page $page) => [
                    'loc' => route('pages.show', $page),
                    'lastmod' => $page->updated_at?->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.6',
                ]));

        $latestContent = $urls->pluck('lastmod')->filter()->max();
        if ($latestContent) {
            $urls->transform(function (array $url) use ($latestContent) {
                if ($url['loc'] === route('home')) {
                    $url['lastmod'] = $latestContent;
                }

                return $url;
            });
        }

        return response()->view('sitemap', compact('urls'))
            ->header('Content-Type', 'application/xml; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    public function robots(): Response
    {
        $content = implode("\n", [
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin/',
            'Disallow: /api/',
            'Disallow: /cari',
            'Disallow: /alumni/registrasi',
            '',
            'Sitemap: '.route('sitemap'),
            '',
        ]);

        return response($content, 200)
            ->header('Content-Type', 'text/plain; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }
}
