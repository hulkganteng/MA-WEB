<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $type = in_array($request->query('type'), Post::TYPES, true) ? $request->query('type') : 'berita';
        abort_unless($request->user()->can(($type === 'artikel' ? 'articles' : 'posts').'.view'), 403);

        $posts = Post::ofType($type)->with(['category', 'author'])
            ->when($request->filled('q'), fn ($query) => $query->where('title', 'like', '%'.$request->string('q').'%'))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest()->paginate(15)->withQueryString();

        return view('admin.posts.index', compact('posts', 'type'));
    }

    public function create(Request $request)
    {
        $type = in_array($request->query('type'), Post::TYPES, true) ? $request->query('type') : 'berita';
        abort_unless($request->user()->can(($type === 'artikel' ? 'articles' : 'posts').'.create'), 403);

        return view('admin.posts.form', ['post' => new Post(['type' => $type, 'status' => 'draft']), 'type' => $type, 'categories' => PostCategory::where('is_active', true)->orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $this->authorizeType($request, $data['type'], 'create');
        $tags = $data['tags'] ?? '';
        unset($data['tags']);
        $data['slug'] = $this->uniqueSlug($data['slug'] ?: $data['title']);
        $data['author_id'] = $request->user()->id;
        $data['body'] = clean($data['body']);
        $data['cover'] = $request->file('cover')?->store('posts', 'public');
        $data['og_image'] = $request->file('og_image')?->store('posts/og', 'public');
        $post = Post::create($data);
        $this->syncTags($post, $tags);
        activity_log('create', $post, ['title' => $post->title]);

        return redirect()->route('admin.posts.index', ['type' => $post->type])->with('flash', ['type' => 'success', 'message' => ucfirst($post->type).' dibuat']);
    }

    public function edit(Request $request, Post $post)
    {
        $this->authorizeType($request, $post->type, 'update');
        return view('admin.posts.form', ['post' => $post->load('tags'), 'type' => $post->type, 'categories' => PostCategory::where('is_active', true)->orderBy('name')->get()]);
    }

    public function update(Request $request, Post $post)
    {
        $this->authorizeType($request, $post->type, 'update');
        $data = $this->validated($request, $post);
        abort_unless($data['type'] === $post->type, 422);
        $tags = $data['tags'] ?? '';
        unset($data['tags']);
        $data['slug'] = $this->uniqueSlug($data['slug'] ?: $data['title'], $post);
        $data['body'] = clean($data['body']);
        foreach (['cover', 'og_image'] as $field) {
            if ($request->hasFile($field)) {
                if ($post->{$field}) Storage::disk('public')->delete($post->{$field});
                $data[$field] = $request->file($field)->store($field === 'cover' ? 'posts' : 'posts/og', 'public');
            } else unset($data[$field]);
        }
        $post->update($data);
        $this->syncTags($post, $tags);
        activity_log('update', $post, ['title' => $post->title]);

        return redirect()->route('admin.posts.index', ['type' => $post->type])->with('flash', ['type' => 'success', 'message' => ucfirst($post->type).' diperbarui']);
    }

    public function destroy(Request $request, Post $post)
    {
        $this->authorizeType($request, $post->type, 'delete');
        activity_log('delete', $post, ['title' => $post->title]);
        $post->delete();
        return back()->with('flash', ['type' => 'success', 'message' => ucfirst($post->type).' dipindahkan ke sampah']);
    }

    private function validated(Request $request, ?Post $post = null): array
    {
        return $request->validate([
            'type' => ['required', Rule::in(Post::TYPES)], 'title' => ['required','string','max:255'],
            'slug' => ['nullable','string','max:255'], 'post_category_id' => ['nullable','exists:post_categories,id'],
            'excerpt' => ['nullable','string','max:500'], 'body' => ['required','string'],
            'status' => ['required', Rule::in(Post::STATUSES)], 'is_featured' => ['nullable','boolean'],
            'published_at' => ['nullable','date'], 'tags' => ['nullable','string','max:500'],
            'cover' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:3072'],
            'og_image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:3072'],
            'seo_title' => ['nullable','string','max:255'], 'seo_description' => ['nullable','string','max:320'], 'seo_keywords' => ['nullable','string','max:500'],
        ]) + ['is_featured' => false];
    }

    private function authorizeType(Request $request, string $type, string $action): void
    {
        abort_unless($request->user()->can(($type === 'artikel' ? 'articles' : 'posts').'.'.$action), 403);
    }

    private function uniqueSlug(string $value, ?Post $ignore = null): string
    {
        $base = Str::slug($value) ?: Str::random(8); $slug = $base; $i = 2;
        while (Post::withTrashed()->where('slug', $slug)->when($ignore, fn ($q) => $q->whereKeyNot($ignore->id))->exists()) $slug = $base.'-'.$i++;
        return $slug;
    }

    private function syncTags(Post $post, string $value): void
    {
        $ids = collect(explode(',', $value))->map(fn ($tag) => trim($tag))->filter()->unique()->map(fn ($name) => Tag::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name])->id);
        $post->tags()->sync($ids);
    }
}
