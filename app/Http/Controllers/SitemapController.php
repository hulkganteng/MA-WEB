<?php
namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Response;
class SitemapController extends Controller { public function index(): Response { $urls = collect([route('home'), route('berita.index'), route('artikel.index'), route('pengumuman.index'), route('agenda.index'), route('contact')])->merge(Post::published()->get()->map(fn ($post) => route($post->type === 'artikel' ? 'artikel.show' : 'berita.show', $post))); return response()->view('sitemap', compact('urls'))->header('Content-Type', 'application/xml'); } }
