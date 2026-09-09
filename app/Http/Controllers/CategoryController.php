<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Place;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        // Get top 4 places in this category (for "Best of the Best" / "Top Ranked")
        $topPlaces = Place::with(['category', 'primaryImage'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('status', 'published')
            ->where('category_id', $category->id)
            ->orderByDesc('reviews_avg_rating')
            ->orderByDesc('reviews_count')
            ->take(4)
            ->get();

        // Get another set of places for "Recommended for you" / "Travelers Choice"
        $recommendedPlaces = Place::with(['category', 'primaryImage'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('status', 'published')
            ->where('category_id', $category->id)
            ->whereNotIn('id', $topPlaces->pluck('id'))
            ->inRandomOrder()
            ->take(8)
            ->get();

        return view('category.show', compact('category', 'topPlaces', 'recommendedPlaces'));
    }
}
