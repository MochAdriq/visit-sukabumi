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
        $mustSees = Place::with(['category', 'primaryImage'])
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

        // 3. Popular Places grouped by Category Slug
        $targetSlugs = ['wisata-alam', 'wisata-pantai', 'kuliner'];
        
        $popularPlacesRaw = Place::with(['category', 'primaryImage'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->where('status', 'published')
            ->whereHas('category', function($q) use ($targetSlugs) {
                $q->whereIn('slug', $targetSlugs);
            })
            // We order by reviews count to simulate "Popularity"
            ->orderByDesc('reviews_count')
            ->get();
            
        // Group by category slug
        $popularPlaces = $popularPlacesRaw->groupBy(function($place) {
            return $place->category->slug;
        });

        // Ensure we always have arrays even if empty
        $popularAlam = $popularPlaces->get('wisata-alam', collect())->take(6);
        $popularPantai = $popularPlaces->get('wisata-pantai', collect())->take(6);
        $popularKuliner = $popularPlaces->get('kuliner', collect())->take(6);

        // 4. Explore Categories (Jelajahi Sukabumi)
        $exploreSlugs = [
            'wisata-alam' => [
                'title' => 'Wisata alam terbaik di Sukabumi',
                'subtitle' => 'Nikmati hamparan alam Sukabumi yang menakjubkan, dari hutan tropis, geopark, hingga air terjun tersembunyi.'
            ],
            'wisata-pantai' => [
                'title' => 'Tur & aktivitas wisata pantai',
                'subtitle' => 'Temukan pantai-pantai eksotis di Sukabumi Selatan dengan ombak, sunset, dan keindahan bawah laut yang luar biasa.'
            ],
            'kuliner' => [
                'title' => 'Kuliner & makanan khas Sukabumi',
                'subtitle' => 'Cicipi cita rasa otentik Sukabumi mulai dari Mie Kocok, Soto Mie, hingga jajanan pasar yang menggugah selera.'
            ],
            'wisata-budaya' => [
                'title' => 'Wisata budaya & sejarah Sukabumi',
                'subtitle' => 'Jelajahi situs bersejarah, desa wisata unik, dan kawasan alam memukau dalam satu perjalanan sehari yang tak terlupakan.'
            ]
        ];

        $exploreCategories = collect();
        $dbCategories = \App\Models\Category::whereIn('slug', array_keys($exploreSlugs))->get()->keyBy('slug');
        
        foreach ($exploreSlugs as $slug => $data) {
            if ($dbCategories->has($slug)) {
                $cat = $dbCategories->get($slug);
                // Pinjam foto dari tempat wisata paling populer di kategori ini
                $bestPlace = Place::where('category_id', $cat->id)
                    ->whereHas('primaryImage')
                    ->withCount('reviews')
                    ->orderByDesc('reviews_count')
                    ->first();
                    
                $cat->cover_image = $bestPlace ? $bestPlace->primaryImage->image_path : null;
                $cat->custom_title = $data['title'];
                $cat->custom_subtitle = $data['subtitle'];
                $exploreCategories->push($cat);
            }
        }

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

        return view('home', compact('mustSees', 'recentReviews', 'popularAlam', 'popularPantai', 'popularKuliner', 'exploreCategories', 'upcomingEvents', 'bannerImage'));
    }
}
