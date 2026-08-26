<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicCalendar;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AcademicCalendarController extends Controller
{
    public function index(Request $request)
    {
        $calendars = AcademicCalendar::query()
            ->when($request->filled('q'), fn ($query) => $query->where('title', 'like', '%'.$request->string('q').'%'))
            ->when($request->filled('category'), fn ($query) => $query->where('category', $request->string('category')))
            ->orderBy('start_date', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.calendars.index', compact('calendars'));
    }

    public function create()
    {
        return view('admin.calendars.form', [
            'calendar' => new AcademicCalendar([
                'category' => 'akademik',
                'academic_year' => '2026/2027',
                'start_date' => now(),
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);

        $cal = AcademicCalendar::create($data);
        activity_log('calendar.create', $cal, ['title' => $cal->title]);

        return redirect()->route('admin.calendars.index')->with('flash', ['type' => 'success', 'message' => 'Agenda kalender akademik berhasil ditambahkan']);
    }

    public function edit(AcademicCalendar $calendar)
    {
        return view('admin.calendars.form', compact('calendar'));
    }

    public function update(Request $request, AcademicCalendar $calendar)
    {
        $data = $this->validated($request);
        if ($calendar->title !== $data['title']) {
            $data['slug'] = $this->uniqueSlug($data['title'], $calendar);
        }

        $calendar->update($data);
        activity_log('calendar.update', $calendar, ['title' => $calendar->title]);

        return redirect()->route('admin.calendars.index')->with('flash', ['type' => 'success', 'message' => 'Agenda kalender akademik berhasil diperbarui']);
    }

    public function destroy(AcademicCalendar $calendar)
    {
        activity_log('calendar.delete', $calendar, ['title' => $calendar->title]);
        $calendar->delete();

        return back()->with('flash', ['type' => 'success', 'message' => 'Agenda kalender dipindahkan ke sampah']);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::in(AcademicCalendar::CATEGORIES)],
            'academic_year' => ['nullable', 'string', 'max:50'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'description' => ['nullable', 'string', 'max:5000'],
        ]);
    }

    private function uniqueSlug(string $title, ?AcademicCalendar $ignore = null): string
    {
        $base = Str::slug($title) ?: Str::random(8);
        $slug = $base;
        $suffix = 2;
        while (AcademicCalendar::withTrashed()->where('slug', $slug)->when($ignore, fn ($query) => $query->whereKeyNot($ignore->id))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
