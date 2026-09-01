<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Announcement;
use App\Models\Download;
use App\Models\Event;
use App\Models\Extracurricular;
use App\Models\Page;
use App\Models\Post;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['q' => ['nullable', 'string', 'max:100']]);
        $term = trim((string) $request->query('q'));
        $like = "%{$term}%";
        $results = collect();
        if ($term !== '') {
            $results = collect([
                'Berita dan artikel' => Post::published()->where(fn ($q) => $q->where('title', 'like', $like)->orWhere('excerpt', 'like', $like))->limit(8)->get()->map(fn ($item) => ['title' => $item->title, 'description' => $item->excerpt, 'url' => route($item->type === 'artikel' ? 'artikel.show' : 'berita.show', $item)]),
                'Pengumuman' => Announcement::published()->active()->where(fn ($q) => $q->where('title', 'like', $like)->orWhere('body', 'like', $like))->limit(8)->get()->map(fn ($item) => ['title' => $item->title, 'description' => strip_tags($item->body), 'url' => route('pengumuman.show', $item)]),
                'Agenda' => Event::published()->where(fn ($q) => $q->where('title', 'like', $like)->orWhere('description', 'like', $like))->limit(8)->get()->map(fn ($item) => ['title' => $item->title, 'description' => $item->description, 'url' => route('agenda.show', $item)]),
                'Prestasi' => Achievement::published()->where(fn ($q) => $q->where('title', 'like', $like)->orWhere('participant', 'like', $like))->limit(8)->get()->map(fn ($item) => ['title' => $item->title, 'description' => $item->participant, 'url' => route('prestasi.index')]),
                'Guru dan tendik' => Teacher::public()->where(fn ($q) => $q->where('name', 'like', $like)->orWhere('subject', 'like', $like)->orWhere('position', 'like', $like))->limit(8)->get()->map(fn ($item) => ['title' => $item->name, 'description' => collect([$item->position, $item->subject])->filter()->join(' · '), 'url' => route('guru.index')]),
                'Halaman' => Page::where('status', 'published')->where(fn ($q) => $q->where('title', 'like', $like)->orWhere('body', 'like', $like))->limit(8)->get()->map(fn ($item) => ['title' => $item->title, 'description' => strip_tags($item->body), 'url' => route('pages.show', $item)]),
                'Dokumen' => Download::published()->where(fn ($q) => $q->where('name', 'like', $like)->orWhere('description', 'like', $like))->limit(8)->get()->map(fn ($item) => ['title' => $item->name, 'description' => $item->description, 'url' => route('downloads.show', $item)]),
                'Ekstrakurikuler' => Extracurricular::active()->where(fn ($q) => $q->where('name', 'like', $like)->orWhere('description', 'like', $like))->limit(8)->get()->map(fn ($item) => ['title' => $item->name, 'description' => $item->description, 'url' => route('extracurricular.show', $item)]),
            ])->filter(fn ($items) => $items->isNotEmpty());
        }

        return view('public.search', compact('results', 'term'));
    }
}
