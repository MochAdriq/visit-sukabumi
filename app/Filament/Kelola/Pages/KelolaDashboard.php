<?php

namespace App\Filament\Kelola\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class KelolaDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.kelola.pages.kelola-dashboard';
    protected static ?string $navigationLabel = 'Ringkasan';
    protected static ?string $title = 'Ringkasan Destinasi';
    protected static ?int $navigationSort = 1;

    public $places;
    public $totalReviews;
    public $avgRating;
    public $wishlistCount;
    public $recentReviews;

    public function mount(): void
    {
        $user = Auth::user();

        $this->places = $user->ownedPlaces()
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->with('primaryImage')
            ->get();

        $placeIds = $this->places->pluck('id');

        $reviews = \App\Models\Review::whereIn('place_id', $placeIds);

        $this->totalReviews  = $reviews->count();
        $this->avgRating     = round($reviews->avg('rating') ?? 0, 1);
        $this->wishlistCount = \Illuminate\Support\Facades\DB::table('wishlists')
            ->whereIn('place_id', $placeIds)->count();

        $this->recentReviews = \App\Models\Review::with(['user', 'place'])
            ->whereIn('place_id', $placeIds)
            ->latest()
            ->take(5)
            ->get();
    }
}
