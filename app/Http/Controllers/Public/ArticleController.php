<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;

class ArticleController extends Controller
{
    public function index()
    {
        return view('public.posts.index', [
            'title' => 'Artikel',
            'description' => 'Wawasan pendidikan, keislaman, dan pengembangan karakter.',
            'posts' => Post::published()->ofType('artikel')->with('category')->latest('published_at')->paginate(9),
            'categories' => collect(),
            'type' => 'artikel',
        ]);
    }

    public function show(Post $post)
    {
        abort_unless($post->type === 'artikel' && $post->status === 'published' && (! $post->published_at || $post->published_at->isPast()), 404);
        $post->increment('views');

        return view('public.posts.show', [
            'post' => $post->load(['category', 'tags', 'author']),
            'related' => Post::published()->ofType('artikel')->whereKeyNot($post->id)->latest('published_at')->limit(3)->get(),
            'section' => 'Artikel',
        ]);
    }
}
