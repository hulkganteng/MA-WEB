<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $achievements = Achievement::query()
            ->when($request->filled('q'), fn ($query) => $query->where(fn ($query) => $query->where('title', 'like', '%'.$request->string('q').'%')->orWhere('participant', 'like', '%'.$request->string('q').'%')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest('achieved_date')->paginate(15)->withQueryString();

        return view('admin.achievements.index', compact('achievements'));
    }

    public function create()
    {
        return view('admin.achievements.form', ['achievement' => new Achievement(['level' => 'kabupaten', 'status' => 'draft'])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['year'] = (int) str($data['achieved_date'])->before('-')->toString();
        $data['author_id'] = $request->user()->id;
        $data['cover'] = $request->file('cover')?->store('achievements', 'public');
        $achievement = Achievement::create($data);
        activity_log('achievement.create', $achievement, ['title' => $achievement->title]);

        return redirect()->route('admin.achievements.index')->with('flash', ['type' => 'success', 'message' => 'Prestasi ditambahkan']);
    }

    public function edit(Achievement $achievement)
    {
        return view('admin.achievements.form', compact('achievement'));
    }

    public function update(Request $request, Achievement $achievement)
    {
        $data = $this->validated($request);
        if ($achievement->title !== $data['title']) {
            $data['slug'] = $this->uniqueSlug($data['title'], $achievement);
        }
        $data['year'] = (int) str($data['achieved_date'])->before('-')->toString();
        if ($request->hasFile('cover')) {
            if ($achievement->cover) {
                Storage::disk('public')->delete($achievement->cover);
            }
            $data['cover'] = $request->file('cover')->store('achievements', 'public');
        }
        $achievement->update($data);
        activity_log('achievement.update', $achievement, ['title' => $achievement->title]);

        return redirect()->route('admin.achievements.index')->with('flash', ['type' => 'success', 'message' => 'Prestasi diperbarui']);
    }

    public function destroy(Achievement $achievement)
    {
        activity_log('achievement.delete', $achievement, ['title' => $achievement->title]);
        $achievement->delete();

        return back()->with('flash', ['type' => 'success', 'message' => 'Prestasi dipindahkan ke sampah']);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'participant' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:50'],
            'level' => ['required', Rule::in(Achievement::LEVELS)],
            'organizer' => ['nullable', 'string', 'max:255'],
            'rank' => ['nullable', 'string', 'max:255'],
            'achieved_date' => ['required', 'date'],
            'description' => ['nullable', 'string', 'max:5000'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'status' => ['required', Rule::in(['draft', 'published'])],
        ]);
    }

    private function uniqueSlug(string $title, ?Achievement $ignore = null): string
    {
        $base = Str::slug($title) ?: Str::random(8);
        $slug = $base;
        $suffix = 2;
        while (Achievement::withTrashed()->where('slug', $slug)->when($ignore, fn ($query) => $query->whereKeyNot($ignore->id))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
