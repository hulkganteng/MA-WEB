<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Album;
use App\Models\Alumni;
use App\Models\Announcement;
use App\Models\Event;
use App\Models\Extracurricular;
use App\Models\FeaturedProgram;
use App\Models\HeroSlide;
use App\Models\Page;
use App\Models\Post;
use App\Models\Teacher;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        $heroSlides = Schema::hasTable('hero_slides')
            ? HeroSlide::published()->orderBy('order')->latest('id')->get()
            : collect();

        return view('public.home', [
            'heroSlides' => $heroSlides,

            'featuredPost' => Post::published()->ofType('berita')->where('is_featured', true)->latest('published_at')->first(),
            'posts' => Post::published()->ofType('berita')->with('category')->latest('published_at')->limit(6)->get(),
            'announcements' => Announcement::published()->active()->latest('is_important')->latest('publish_date')->limit(4)->get(),
            'events' => Event::published()->upcoming()->orderBy('start_date')->limit(4)->get(),
            'achievements' => Achievement::published()->latest('achieved_date')->limit(3)->get(),
            'programs' => FeaturedProgram::active()->orderBy('order')->limit(4)->get(),
            'extracurriculars' => Extracurricular::active()->orderBy('order')->limit(6)->get(),
            'albums' => Album::published()->withCount('photos')->latest('album_date')->limit(4)->get(),
            'alumni' => Alumni::public()->orderBy('order')->limit(3)->get(),
            'aboutPage' => Page::where('slug', 'tentang-madrasah')->where('status', 'published')->first(),
            'teacherCount' => Teacher::public()->where('type', 'guru')->count(),
        ]);
    }
}

