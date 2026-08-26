<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        return view('public.announcements.index', ['announcements' => Announcement::published()->active()->latest('is_important')->latest('publish_date')->paginate(10)]);
    }

    public function show(Announcement $announcement)
    {
        abort_unless(Announcement::published()->active()->whereKey($announcement)->exists(), 404);

        return view('public.announcements.show', compact('announcement'));
    }
}
