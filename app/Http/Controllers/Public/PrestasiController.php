<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;

class PrestasiController extends Controller
{
    public function index(Request $request)
    {
        $achievements = Achievement::published()
            ->when($request->filled('tingkat'), fn ($query) => $query->where('level', $request->string('tingkat')))
            ->when($request->filled('tahun'), fn ($query) => $query->where('year', $request->integer('tahun')))
            ->when($request->filled('kategori'), fn ($query) => $query->where('category', $request->string('kategori')))
            ->latest('achieved_date')->paginate(12)->withQueryString();

        return view('public.achievements.index', [
            'achievements' => $achievements,
            'years' => Achievement::published()->whereNotNull('year')->distinct()->orderByDesc('year')->pluck('year'),
            'categories' => Achievement::published()->distinct()->orderBy('category')->pluck('category'),
        ]);
    }
}
