<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Download;
use App\Models\DownloadCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function index(Request $request)
    {
        $downloads = Download::published()->with('category')->when($request->filled('kategori'), fn ($query) => $query->whereHas('category', fn ($category) => $category->where('slug', $request->string('kategori'))))->latest('publish_date')->paginate(15)->withQueryString();

        return view('public.downloads.index', ['downloads' => $downloads, 'categories' => DownloadCategory::where('is_active', true)->orderBy('order')->get()]);
    }

    public function download(Download $download)
    {
        abort_unless($download->status === 'published' && Storage::disk('public')->exists($download->file), 404);
        $download->increment('downloads');

        return Storage::disk('public')->download($download->file, $download->file_name ?: basename($download->file));
    }
}
