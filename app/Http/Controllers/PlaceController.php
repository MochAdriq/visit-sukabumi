<?php

namespace App\Http\Controllers;

use App\Models\Place;

class PlaceController extends Controller
{
    public function index()
    {
        $places = Place::with(['category', 'primaryImage'])
            ->where('status', 'published')
            ->latest()
            ->paginate(12);

        return view('place.index', compact('places'));
    }

    public function show(Place $place)
    {
        $place->load([
            'category',
            'placeImages',
            'reviews.user',
        ]);

        $related = Place::with(['category', 'primaryImage'])
            ->where('category_id', $place->category_id)
            ->where('id', '!=', $place->id)
            ->where('status', 'published')
            ->limit(4)
            ->get();

        return view('place.show', compact('place', 'related'));
    }
}
