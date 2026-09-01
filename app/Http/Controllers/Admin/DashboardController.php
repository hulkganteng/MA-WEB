<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Album;
use App\Models\Alumni;
use App\Models\Announcement;
use App\Models\ContactMessage;
use App\Models\Download;
use App\Models\Event;
use App\Models\HeroSlide;
use App\Models\Post;
use App\Models\Teacher;
use App\Models\Video;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $postCounts = Schema::hasTable('posts')
            ? Post::query()
                ->whereIn('type', ['berita', 'artikel'])
                ->selectRaw('type, COUNT(*) as aggregate')
                ->groupBy('type')
                ->pluck('aggregate', 'type')
            : collect();

        return view('admin.dashboard', [
            'stats' => [
                'Berita' => (int) $postCounts->get('berita', 0),
                'Artikel' => (int) $postCounts->get('artikel', 0),
                'Pengumuman' => Schema::hasTable('announcements') ? Announcement::count() : 0,
                'Agenda aktif' => Schema::hasTable('events') ? Event::upcoming()->count() : 0,
                'Slide hero' => Schema::hasTable('hero_slides') ? HeroSlide::count() : 0,
                'Galeri foto' => Schema::hasTable('albums') ? Album::count() : 0,
                'Galeri video' => Schema::hasTable('videos') ? Video::count() : 0,
                'Guru dan tendik' => Schema::hasTable('teachers') ? Teacher::public()->count() : 0,
                'Alumni' => Schema::hasTable('alumni') ? Alumni::public()->count() : 0,
                'Pesan baru' => Schema::hasTable('contact_messages') ? ContactMessage::where('is_read', false)->count() : 0,
                'Dokumen' => Schema::hasTable('downloads') ? Download::count() : 0,
            ],

            'recentPosts' => Post::with('author')->latest()->limit(6)->get(),
            'activities' => ActivityLog::with('user')->latest()->limit(8)->get(),
        ]);
    }
}
