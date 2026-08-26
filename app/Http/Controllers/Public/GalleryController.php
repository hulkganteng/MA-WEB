<?php
namespace App\Http\Controllers\Public;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Video;
class GalleryController extends Controller {
    public function photos() { return view('public.gallery.photos', ['albums' => Album::published()->withCount('photos')->latest('album_date')->paginate(12)]); }
    public function album(Album $album) { abort_unless($album->status === 'published', 404); return view('public.gallery.album', ['album' => $album->load('photos')]); }
    public function videos() { return view('public.gallery.videos', ['videos' => Video::published()->latest('video_date')->paginate(12)]); }
}
