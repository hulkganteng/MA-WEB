<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::published()->ofType('berita')->with('category')
            ->when($request->filled('kategori'), fn ($query) => $query->whereHas('category', fn ($category) => $category->where('slug', $request->string('kategori'))))
            ->latest('published_at')->paginate(9)->withQueryString();

        return view('public.posts.index', [
            'title' => 'Berita',
            'description' => 'Kabar terbaru, kegiatan, dan informasi dari lingkungan madrasah.',
            'posts' => $posts,
            'categories' => PostCategory::orderBy('name')->get(),
            'type' => 'berita',
        ]);
    }

    public function show(Post $post)
    {
        abort_unless($post->type === 'berita' && $post->status === 'published' && (! $post->published_at || $post->published_at->isPast()), 404);
        $post->increment('views');

        return view('public.posts.show', [
            'post' => $post->load(['category', 'tags', 'author']),
            'related' => Post::published()->ofType('berita')->whereKeyNot($post->id)->latest('published_at')->limit(3)->get(),
            'section' => 'Berita',
        ]);
    }
}
