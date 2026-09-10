<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::where('is_active', true);

        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('location_name', 'like', "%{$searchTerm}%");
            });
        }

        // Top upcoming events for the Travelers Choice section (limit 4)
        $topEvents = (clone $query)->orderBy('start_date', 'asc')->take(4)->get();

        // All other events paginated
        $events = $query->orderBy('start_date', 'asc')
            ->paginate(12)
            ->withQueryString();

        return view('event.index', compact('events', 'topEvents'));
    }

    public function show(string $slug)
    {
        $event = Event::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('event.show', compact('event'));
    }
}
