<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Event;

class AgendaController extends Controller
{
    public function index()
    {
        return view('public.events.index', ['events' => Event::published()->orderByRaw('start_date < ? ASC', [now()->toDateString()])->orderBy('start_date')->paginate(10)]);
    }

    public function show(Event $event)
    {
        abort_unless($event->status === 'published', 404);
        return view('public.events.show', compact('event'));
    }
}
