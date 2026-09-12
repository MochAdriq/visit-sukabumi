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

        // Filter khusus "Tempat Menginap"
        $type = $request->query('type');
        if ($type === 'penginapan') {
            $query->where('has_accommodation', true);
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
        $currentType = $type;

        return view('place.index', compact('places', 'currentCategory', 'allCategories', 'currentType'));
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

        // Auto-detect Destinasi & Titik Terdekat via koordinat GPS (Haversine formula)
        $nearbyPlaces = collect();
        if ($place->latitude && $place->longitude && (float)$place->latitude != 0 && (float)$place->longitude != 0) {
            $lat = (float) $place->latitude;
            $lng = (float) $place->longitude;

            $nearbyPlaces = Place::select('*')
                ->selectRaw(
                    '(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',
                    [$lat, $lng, $lat]
                )
                ->where('status', 'published')
                ->where('id', '!=', $place->id)
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->where('latitude', '!=', 0)
                ->where('longitude', '!=', 0)
                ->orderBy('distance', 'asc')
                ->with(['primaryImage', 'placeImages', 'category'])
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->limit(4)
                ->get();
        }

        // Fallback cerdas jika tempat belum ada koordinat atau hasil < 4
        if ($nearbyPlaces->count() < 4) {
            $existingIds = $nearbyPlaces->pluck('id')->push($place->id)->toArray();
            $query = Place::where('status', 'published')
                ->whereNotIn('id', $existingIds)
                ->with(['primaryImage', 'placeImages', 'category'])
                ->withAvg('reviews', 'rating')
                ->withCount('reviews');

            if ($place->district) {
                $query->where('district', $place->district);
            }

            $fillers = $query->limit(4 - $nearbyPlaces->count())->get();

            // Jika masih kurang, ambil destinasi terpopuler lainnya
            if ($nearbyPlaces->count() + $fillers->count() < 4) {
                $allUsedIds = array_merge($existingIds, $fillers->pluck('id')->toArray());
                $moreFillers = Place::where('status', 'published')
                    ->whereNotIn('id', $allUsedIds)
                    ->with(['primaryImage', 'placeImages', 'category'])
                    ->withAvg('reviews', 'rating')
                    ->withCount('reviews')
                    ->limit(4 - ($nearbyPlaces->count() + $fillers->count()))
                    ->get();
                $fillers = $fillers->concat($moreFillers);
            }

            $nearbyPlaces = $nearbyPlaces->concat($fillers);
        }

        return view('place.show', compact('place', 'related', 'nearbyPlaces'));
    }

    /**
     * Get 5 closest places based on visitor's latitude and longitude
     */
    public function nearby(Request $request)
    {
        $lat = $request->query('lat');
        $lng = $request->query('lng');

        if (!is_numeric($lat) || !is_numeric($lng)) {
            return response()->json([
                'success' => false,
                'message' => 'Koordinat lokasi tidak valid.',
            ], 400);
        }

        $lat = (float) $lat;
        $lng = (float) $lng;

        // Haversine formula
        $places = Place::select('*')
            ->selectRaw(
                '(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',
                [$lat, $lng, $lat]
            )
            ->where('status', 'published')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where('latitude', '!=', 0)
            ->where('longitude', '!=', 0)
            ->orderBy('distance', 'asc')
            ->with(['primaryImage', 'placeImages', 'category'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->limit(5)
            ->get();

        // If places with coordinates are fewer than 5, supplement with popular places
        if ($places->count() < 5) {
            $existingIds = $places->pluck('id')->toArray();
            $fillers = Place::where('status', 'published')
                ->whereNotIn('id', $existingIds)
                ->with(['primaryImage', 'placeImages', 'category'])
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->orderByDesc('reviews_count')
                ->limit(5 - $places->count())
                ->get();

            $places = $places->concat($fillers);
        }

        $data = $places->map(function ($place) {
            $dist = isset($place->distance) ? round((float) $place->distance, 1) : null;
            return [
                'id' => $place->id,
                'name' => $place->name,
                'slug' => $place->slug,
                'url' => route('place.show', $place->slug),
                'cover_image' => $place->cover_image_url,
                'rating' => round($place->reviews_avg_rating ?? 0, 1),
                'reviews_count' => $place->reviews_count ?? 0,
                'distance' => $dist,
                'distance_formatted' => $dist !== null ? ($dist < 1 ? round($dist * 1000) . ' m' : $dist . ' km') : null,
                'has_general_price' => (bool) $place->has_general_price,
                'price_formatted' => $place->has_general_price && $place->price ? 'Mulai Rp ' . number_format($place->price, 0, ',', '.') : null,
                'district' => $place->district,
                'category_name' => $place->category?->name,
                'is_featured' => (bool) $place->is_featured,
                'badge_label' => $place->badge_label,
                'description' => \Illuminate\Support\Str::limit(strip_tags($place->description ?? ''), 90),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
