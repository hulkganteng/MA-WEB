<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\OrganizationMember;
use App\Models\Page;

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
        return view('public.profile.structure', ['members' => OrganizationMember::where('is_active', true)->whereNull('parent_id')->with(['children' => fn ($query) => $query->where('is_active', true)])->orderBy('order')->get()]);
    }
}
