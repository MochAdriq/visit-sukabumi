<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Place;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Halaman master listing untuk kategori Aktivitas
     */
    public function indexActivity()
    {
        $tags = Tag::where('type', 'activity')->orderBy('sort_order')->withCount('places')->get();
        return view('tag.index', [
            'type' => 'aktivitas',
            'title' => 'Apa yang Bisa Dilakukan di Sukabumi',
            'subtitle' => 'Temukan berbagai aktivitas seru untuk mengisi liburan Anda. Dari petualangan ekstrem hingga wisata santai bersama keluarga.',
            'heroImage' => asset('assets/images/3.jpg'), // A nice active photo
            'tags' => $tags
        ]);
    }

    /**
     * Halaman master listing untuk kategori Wisata
     */
    public function indexWisata()
    {
        $tags = Tag::where('type', 'wisata')->orderBy('sort_order')->withCount('places')->get();
        return view('tag.index', [
            'type' => 'wisata',
            'title' => 'Destinasi Wisata Memukau',
            'subtitle' => 'Eksplorasi keindahan alam tiada dua, dari pegunungan yang sejuk hingga pantai selatan yang eksotis.',
            'heroImage' => asset('assets/images/4.jpg'), // A nice nature photo
            'tags' => $tags
        ]);
    }

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
            ->with(['category', 'primaryImage', 'tags', 'reviews' => function($q) {
                $q->where('rating', '>=', 4)->orderByDesc('likes_count')->orderByDesc('rating')->take(1);
            }])
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
        $sort = $request->get('sort', 'recommended');
        match ($sort) {
            'highest_rated' => $query->orderByDesc('reviews_avg_rating'),
            'most_reviewed' => $query->orderByDesc('reviews_count'),
            'price_low'     => $query->orderBy('price'),
            'price_high'    => $query->orderByDesc('price'),
            default         => $query->orderByDesc('reviews_count'), // recommended fallback
        };

        $places = $query->paginate(12)->withQueryString();

        return view('tag.show', compact('tag', 'places', 'sort'));
    }
}
