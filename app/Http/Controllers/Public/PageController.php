<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    public function show(Page $page)
    {
        abort_unless($page->status === 'published', 404);

        $canonicalRoutes = [
            'tentang-madrasah' => 'about',
            'sejarah' => 'sejarah',
            'visi-misi' => 'visi-misi',
        ];

        if (isset($canonicalRoutes[$page->slug])) {
            return redirect()->route($canonicalRoutes[$page->slug], [], 301);
        }

        return view('public.page', compact('page'));
    }
}
