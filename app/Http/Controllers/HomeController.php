<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Must Sees
        $mustSees = Place::with(['category', 'primaryImage', 'placeImages'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->where('status', 'published')
            ->inRandomOrder()
            ->limit(4)
            ->get();
            
        // 2. Recent Reviews (Cerita Traveler)
        $recentReviews = Review::with(['user', 'place', 'event'])
            ->whereNotNull('content')
            ->latest()
            ->limit(12)
            ->get();

        // 3. Pilihan Terbaik (Curated by Admin via is_featured toggle)
        $bestChoices = Place::with(['category', 'primaryImage', 'placeImages'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->where('status', 'published')
            ->where('is_featured', true)
            ->latest()
            ->limit(5)
            ->get();

        // Fallback jika yang di-toggle is_featured di admin belum sampai 5
        if ($bestChoices->count() < 5) {
            $existingIds = $bestChoices->pluck('id')->toArray();
            $fillers = Place::with(['category', 'primaryImage', 'placeImages'])
                ->withCount('reviews')
                ->withAvg('reviews', 'rating')
                ->where('status', 'published')
                ->whereNotIn('id', $existingIds)
                ->orderByDesc('reviews_avg_rating')
                ->orderByDesc('reviews_count')
                ->limit(5 - $bestChoices->count())
                ->get();

            $bestChoices = $bestChoices->concat($fillers);
        }

        // 4. Destinasi Terpopuler (All-in-One: 5 tempat paling hits by review count & rating)
        $popularPlaces = Place::with(['category', 'primaryImage', 'placeImages'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->where('status', 'published')
            ->orderByDesc('reviews_count')
            ->orderByDesc('reviews_avg_rating')
            ->limit(5)
            ->get();

        // 4b. Kuliner Terpopuler (5 tempat kuliner rating & ulasan tertinggi)
        $popularCulinaries = Place::with(['category', 'primaryImage', 'placeImages'])
            ->whereHas('category', function($q) {
                $q->where('slug', 'kuliner');
            })
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->where('status', 'published')
            ->orderByDesc('reviews_count')
            ->orderByDesc('reviews_avg_rating')
            ->limit(5)
            ->get();

        // 5. Upcoming Events
        $upcomingEvents = \App\Models\Event::where('is_active', true)
            ->where('start_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->limit(20)
            ->get();

        // 6. Banner Image (Aktivitas Seru)
        $bannerPlace = Place::whereHas('category', function($q) {
                $q->where('slug', 'aktivitas-seru');
            })
            ->whereHas('primaryImage')
            ->inRandomOrder()
            ->first();
            
        $bannerImage = $bannerPlace ? $bannerPlace->primaryImage->image_path : null;

        // 7. Categories for Hero Quick Filter Pills
        $categories = \App\Models\Category::all();

        // 8. Dynamic Homepage Advertisement (Banner Promo Tengah Acak)
        $homeAd = \App\Models\Advertisement::getRandomAd('homepage_middle', 'home');

        // 9. Featured Videos (Sukabumi Dalam Lensa)
        $featuredVideos = \App\Models\Video::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->limit(4)
            ->get();

        // Fallback jika belum ada yang di-set featured, ambil video aktif terbaru
        if ($featuredVideos->isEmpty()) {
            $featuredVideos = \App\Models\Video::where('is_active', true)
                ->orderBy('sort_order', 'asc')
                ->orderBy('id', 'desc')
                ->limit(4)
                ->get();
        }

        return view('home', compact('mustSees', 'recentReviews', 'bestChoices', 'popularPlaces', 'popularCulinaries', 'upcomingEvents', 'bannerImage', 'categories', 'homeAd', 'featuredVideos'));
    }
}
