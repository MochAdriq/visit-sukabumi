<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Place;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Halaman listing places berdasarkan tag.
     * Digunakan untuk kedua tipe route:
     *   /aktivitas/{tag:slug}
     *   /wisata/{tag:slug}
     */
    public function show(Request $request, Tag $tag)
    {
        $query = Place::query()
            ->where('status', 'published')
            ->whereHas('tags', fn ($q) => $q->where('tag_id', $tag->id))
            ->with(['category', 'primaryImage', 'tags'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        // Filter pencarian
        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('district', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sort = $request->get('sort', 'popular');
        match ($sort) {
            'rating'   => $query->orderByDesc('reviews_avg_rating'),
            'newest'   => $query->latest(),
            'name'     => $query->orderBy('name'),
            default    => $query->orderByDesc('reviews_count'),
        };

        $places = $query->paginate(12)->withQueryString();

        // Tag lain satu tipe untuk sidebar/navigasi lintas tag
        $relatedTags = Tag::where('type', $tag->type)
            ->where('id', '!=', $tag->id)
            ->orderBy('sort_order')
            ->get();

        return view('tag.show', compact('tag', 'places', 'relatedTags', 'sort'));
    }
}
