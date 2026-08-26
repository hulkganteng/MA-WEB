<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::query()->when($request->filled('q'), fn ($query) => $query->where('title', 'like', '%'.$request->string('q').'%'))->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))->latest('start_date')->paginate(15)->withQueryString();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.form', ['event' => new Event(['category' => 'kegiatan', 'status' => 'draft', 'start_date' => now(), 'end_date' => now()])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['author_id'] = $request->user()->id;
        $data['cover'] = $request->file('cover')?->store('events', 'public');
        $event = Event::create($data);
        activity_log('event.create', $event, ['title' => $event->title]);

        return redirect()->route('admin.events.index')->with('flash', ['type' => 'success', 'message' => 'Agenda ditambahkan']);
    }

    public function edit(Event $event)
    {
        return view('admin.events.form', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $this->validated($request);
        if ($event->title !== $data['title']) {
            $data['slug'] = $this->uniqueSlug($data['title'], $event);
        }
        if ($request->hasFile('cover')) {
            if ($event->cover) {
                Storage::disk('public')->delete($event->cover);
            }
            $data['cover'] = $request->file('cover')->store('events', 'public');
        }
        $event->update($data);
        activity_log('event.update', $event, ['title' => $event->title]);

        return redirect()->route('admin.events.index')->with('flash', ['type' => 'success', 'message' => 'Agenda diperbarui']);
    }

    public function destroy(Event $event)
    {
        activity_log('event.delete', $event, ['title' => $event->title]);
        $event->delete();

        return back()->with('flash', ['type' => 'success', 'message' => 'Agenda dipindahkan ke sampah']);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'], 'description' => ['nullable', 'string', 'max:5000'],
            'location' => ['nullable', 'string', 'max:255'], 'start_date' => ['required', 'date'], 'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'start_time' => ['nullable', 'date_format:H:i'], 'end_time' => ['nullable', 'date_format:H:i', 'after:start_time'],
            'category' => ['required', Rule::in(Event::CATEGORIES)], 'status' => ['required', Rule::in(Event::STATUSES)],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);
    }

    private function uniqueSlug(string $title, ?Event $ignore = null): string
    {
        $base = Str::slug($title) ?: Str::random(8);
        $slug = $base;
        $suffix = 2;
        while (Event::withTrashed()->where('slug', $slug)->when($ignore, fn ($query) => $query->whereKeyNot($ignore->id))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
