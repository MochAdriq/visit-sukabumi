<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::where('is_active', true)
            ->orderBy('start_date', 'asc')
            ->paginate(12)
            ->withQueryString();

        return view('event.index', compact('events'));
    }

    public function show(string $slug)
    {
        $event = Event::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('event.show', compact('event'));
    }
}
