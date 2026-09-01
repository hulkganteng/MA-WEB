<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Teacher;

class ProfileController extends Controller
{
    private function page(string $slug, string $title, string $description)
    {
        return view('public.profile.page', ['page' => Page::where('slug', $slug)->where('status', 'published')->first(), 'title' => $title, 'description' => $description]);
    }

    public function about()
    {
        return $this->page('tentang-madrasah', 'Tentang madrasah', 'Mengenal identitas, nilai, dan lingkungan MA Ma’arif NU Assa’adah.');
    }

    public function history()
    {
        return $this->page('sejarah', 'Sejarah madrasah', 'Perjalanan dan perkembangan MA Ma’arif NU Assa’adah.');
    }

    public function visiMisi()
    {
        return $this->page('visi-misi', 'Visi dan misi', 'Arah pendidikan dan nilai yang menjadi landasan madrasah.');
    }

    public function sambutan()
    {
        return view('public.profile.principal');
    }

    public function structure()
    {
        $members = Teacher::where('is_in_structure', true)
            ->where('is_active', true)
            ->where(fn ($query) => $query->whereNull('structure_parent_id')->orWhereDoesntHave('parent'))
            ->with(['children' => fn ($query) => $query->where('is_in_structure', true)->where('is_active', true)])
            ->orderBy('structure_order')
            ->get();

        return view('public.profile.structure', compact('members'));
    }
}
