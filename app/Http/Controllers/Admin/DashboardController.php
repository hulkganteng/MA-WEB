<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Alumni;
use App\Models\Announcement;
use App\Models\ContactMessage;
use App\Models\Download;
use App\Models\Event;
use App\Models\Post;
use App\Models\Teacher;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'stats' => [
                'Berita' => Post::ofType('berita')->count(),
                'Artikel' => Post::ofType('artikel')->count(),
                'Pengumuman' => Announcement::count(),
                'Agenda aktif' => Event::upcoming()->count(),
                'Guru dan tendik' => Teacher::public()->count(),
                'Alumni' => Alumni::public()->count(),
                'Pesan baru' => ContactMessage::where('is_read', false)->count(),
                'Dokumen' => Download::count(),
            ],
            'recentPosts' => Post::with('author')->latest()->limit(6)->get(),
            'activities' => ActivityLog::with('user')->latest()->limit(8)->get(),
        ]);
    }
}
