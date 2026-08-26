<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $announcements = Announcement::query()->when($request->filled('q'), fn ($query) => $query->where('title', 'like', '%'.$request->string('q').'%'))->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))->latest('publish_date')->paginate(15)->withQueryString();

        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.form', ['announcement' => new Announcement(['status' => 'draft', 'publish_date' => now()])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['author_id'] = $request->user()->id;
        $data['body'] = clean($data['body']);
        if ($request->hasFile('attachment')) {
            $data['attachment_name'] = $request->file('attachment')->getClientOriginalName();
            $data['attachment'] = $request->file('attachment')->store('announcements', 'public');
        }
        $data['is_important'] = $request->boolean('is_important');
        $announcement = Announcement::create($data);
        activity_log('announcement.create', $announcement, ['title' => $announcement->title]);

        return redirect()->route('admin.announcements.index')->with('flash', ['type' => 'success', 'message' => 'Pengumuman ditambahkan']);
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.form', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $data = $this->validated($request);
        if ($announcement->title !== $data['title']) {
            $data['slug'] = $this->uniqueSlug($data['title'], $announcement);
        }
        $data['body'] = clean($data['body']);
        $data['is_important'] = $request->boolean('is_important');
        if ($request->hasFile('attachment')) {
            if ($announcement->attachment) {
                Storage::disk('public')->delete($announcement->attachment);
            }
            $data['attachment_name'] = $request->file('attachment')->getClientOriginalName();
            $data['attachment'] = $request->file('attachment')->store('announcements', 'public');
        }
        $announcement->update($data);
        activity_log('announcement.update', $announcement, ['title' => $announcement->title]);

        return redirect()->route('admin.announcements.index')->with('flash', ['type' => 'success', 'message' => 'Pengumuman diperbarui']);
    }

    public function destroy(Announcement $announcement)
    {
        activity_log('announcement.delete', $announcement, ['title' => $announcement->title]);
        $announcement->delete();

        return back()->with('flash', ['type' => 'success', 'message' => 'Pengumuman dipindahkan ke sampah']);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'], 'body' => ['required', 'string'],
            'publish_date' => ['required', 'date'], 'start_date' => ['nullable', 'date'], 'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_important' => ['nullable', 'boolean'], 'status' => ['required', Rule::in(Announcement::STATUSES)],
            'attachment' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:5120'],
            'seo_title' => ['nullable', 'string', 'max:255'], 'seo_description' => ['nullable', 'string', 'max:320'],
        ]);
    }

    private function uniqueSlug(string $title, ?Announcement $ignore = null): string
    {
        $base = Str::slug($title) ?: Str::random(8);
        $slug = $base;
        $suffix = 2;
        while (Announcement::withTrashed()->where('slug', $slug)->when($ignore, fn ($query) => $query->whereKeyNot($ignore->id))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
