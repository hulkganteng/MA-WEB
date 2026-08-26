<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use App\Rules\SafeButtonUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class HeroSlideController extends Controller
{
    public function index(Request $request)
    {
        $slides = HeroSlide::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $q = $request->string('q');
                $query->where(function ($qBuilder) use ($q) {
                    $qBuilder->where('title', 'like', "%{$q}%")
                        ->orWhere('subtitle', 'like', "%{$q}%")
                        ->orWhere('tagline', 'like', "%{$q}%");
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->orderBy('order')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.hero-slides.index', compact('slides'));
    }

    public function create()
    {
        $nextOrder = (int) (HeroSlide::max('order') ?? 0) + 1;

        return view('admin.hero-slides.form', [
            'slide' => new HeroSlide([
                'status' => 'published',
                'order' => $nextOrder,
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateSlide($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('hero-slides', 'public');
        }

        $slide = HeroSlide::create($data);
        activity_log('hero_slide.create', $slide, ['title' => $slide->title]);

        return redirect()->route('admin.hero-slides.index')->with('flash', [
            'type' => 'success',
            'message' => 'Slide hero berhasil ditambahkan',
        ]);
    }

    public function edit(HeroSlide $heroSlide)
    {
        return view('admin.hero-slides.form', [
            'slide' => $heroSlide,
        ]);
    }

    public function update(Request $request, HeroSlide $heroSlide)
    {
        $data = $this->validateSlide($request, $heroSlide);

        if ($request->hasFile('image')) {
            $rawImage = $heroSlide->getRawOriginal('image');
            if ($rawImage && !str_starts_with($rawImage, 'http') && Storage::disk('public')->exists($rawImage)) {
                Storage::disk('public')->delete($rawImage);
            }
            $data['image'] = $request->file('image')->store('hero-slides', 'public');
        }

        $heroSlide->update($data);
        activity_log('hero_slide.update', $heroSlide, ['title' => $heroSlide->title]);

        return redirect()->route('admin.hero-slides.index')->with('flash', [
            'type' => 'success',
            'message' => 'Slide hero berhasil diperbarui',
        ]);
    }

    public function destroy(HeroSlide $heroSlide)
    {
        activity_log('hero_slide.delete', $heroSlide, ['title' => $heroSlide->title]);
        $heroSlide->delete();

        return back()->with('flash', [
            'type' => 'success',
            'message' => 'Slide hero berhasil dipindahkan ke sampah',
        ]);
    }

    private function validateSlide(Request $request, ?HeroSlide $slide = null): array
    {
        $imageRules = $slide ? ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'] : ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'];

        return $request->validate([
            'title'                  => ['required', 'string', 'max:255'],
            'subtitle'               => ['nullable', 'string', 'max:500'],
            'tagline'                => ['nullable', 'string', 'max:100'],
            'image'                  => $imageRules,
            'button_text'            => ['nullable', 'string', 'max:50'],
            'button_url'             => ['nullable', 'string', 'max:255', new SafeButtonUrl()],
            'secondary_button_text'  => ['nullable', 'string', 'max:50'],
            'secondary_button_url'   => ['nullable', 'string', 'max:255', new SafeButtonUrl()],
            'order'                  => ['nullable', 'integer', 'min:0'],
            'status'                 => ['required', Rule::in(HeroSlide::STATUSES)],
        ]);
    }
}
