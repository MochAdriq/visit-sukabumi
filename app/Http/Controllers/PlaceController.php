<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Category;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function index(Request $request)
    {
        $categorySlug = $request->query('category');
        $currentCategory = null;

        $query = Place::with(['category', 'primaryImage'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('status', 'published');

        if ($categorySlug) {
            $currentCategory = Category::where('slug', $categorySlug)->first();
            if ($currentCategory) {
                $query->where('category_id', $currentCategory->id);
            }
        }

        if ($request->filled('q')) {
            $search = $request->query('q');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('district', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $places = $query->latest()->paginate(12)->withQueryString();
        $allCategories = Category::all();

        return view('place.index', compact('places', 'currentCategory', 'allCategories'));
    }

    public function show(Place $place)
    {
        if ($place->status !== 'published') {
            $isAdmin = (auth()->check() && (auth()->user()->role === 'admin' || empty(auth()->user()->role)))
                || (class_exists(\Filament\Facades\Filament::class) && \Filament\Facades\Filament::auth()->check());

            if (!$isAdmin) {
                abort(404);
            }
        }

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
