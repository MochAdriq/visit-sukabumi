<?php

namespace App\Filament\Kelola\Pages;

use App\Models\Booking;
use App\Models\HotelRoom;
use App\Models\Place;
use App\Models\Review;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KelolaDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.kelola.pages.kelola-dashboard';
    protected static ?string $navigationLabel = 'Dashboard Mitra';
    protected static ?string $title = 'Ringkasan Usaha & Tamu';
    protected static ?int $navigationSort = 0;

    public $places;
    public $primaryPlace;
    public $events;
    public $primaryEvent;
    public $hasPlaces = false;
    public $hasEvents = false;
    public $totalReviews = 0;
    public $avgRating = 0.0;
    public $wishlistCount = 0;
    public $totalBookings = 0;
    public $paidRevenue = 0;
    public $todayCheckIns = 0;
    public $activeRoomsCount = 0;
    public $activeTicketsCount = 0;
    public $pendingBookingsCount = 0;
    public $recentReviews;
    public $recentBookings;

    public function mount(): void
    {
        $user = Auth::user();
        if (!$user) return;

        $this->hasPlaces = $user->hasPlaceAccess() && ($user->role === 'admin' || $user->ownedPlaces()->exists());
        $this->hasEvents = $user->hasEventAccess() && ($user->role === 'admin' || $user->events()->exists());

        if ($user->role === 'admin' && !$user->ownedPlaces()->exists()) {
            $this->places = Place::query()
                ->withCount('reviews')
                ->withAvg('reviews', 'rating')
                ->with('primaryImage')
                ->take(5)
                ->get();
            $placeIds = Place::pluck('id');
            $roomIds = HotelRoom::pluck('id');
        } else {
            $this->places = $user->ownedPlaces()
                ->withCount('reviews')
                ->withAvg('reviews', 'rating')
                ->with('primaryImage')
                ->get();
            $placeIds = $this->places->pluck('id');
            $roomIds = HotelRoom::whereIn('place_id', $placeIds)->pluck('id');
        }

        $this->primaryPlace = $this->places->first();
        $this->activeRoomsCount = HotelRoom::whereIn('place_id', $placeIds)->where('is_active', true)->count();

        // Events
        if ($user->role === 'admin' && !$user->events()->exists()) {
            $this->events = \App\Models\Event::withCount('tickets')->latest()->take(5)->get();
            $myEventIds = \App\Models\Event::pluck('id');
        } else {
            $this->events = $user->events()->withCount('tickets')->latest()->get();
            $myEventIds = $this->events->pluck('id');
        }
        $this->primaryEvent = $this->events->first();
        $ticketIds = \App\Models\EventTicket::whereIn('event_id', $myEventIds)->pluck('id');
        $this->activeTicketsCount = \App\Models\EventTicket::whereIn('event_id', $myEventIds)->where('is_active', true)->count();

        // Reviews & Wishlist
        $reviews = Review::whereIn('place_id', $placeIds);
        $this->totalReviews  = $reviews->count();
        $this->avgRating     = round($reviews->avg('rating') ?? 0, 1);
        $this->wishlistCount = DB::table('wishlists')->whereIn('place_id', $placeIds)->count();

        $this->recentReviews = Review::with(['user', 'place'])
            ->whereIn('place_id', $placeIds)
            ->latest()
            ->take(5)
            ->get();

        // Bookings Query
        $bookingQuery = Booking::where(function ($query) use ($placeIds, $roomIds, $ticketIds) {
            $query->where(function ($q) use ($roomIds) {
                $q->where('bookable_type', HotelRoom::class)
                  ->whereIn('bookable_id', $roomIds);
            })->orWhere(function ($q) use ($placeIds) {
                $q->where('bookable_type', Place::class)
                  ->whereIn('bookable_id', $placeIds);
            })->orWhere(function ($q) use ($ticketIds) {
                $q->where('bookable_type', \App\Models\EventTicket::class)
                  ->whereIn('bookable_id', $ticketIds);
            });
        });

        $this->totalBookings = (clone $bookingQuery)->count();
        $this->paidRevenue   = (float) (clone $bookingQuery)->where('payment_status', 'paid')->sum('subtotal_amount');
        $this->todayCheckIns = (clone $bookingQuery)->whereDate('check_in_date', Carbon::today())->where('payment_status', 'paid')->count();
        $this->pendingBookingsCount = (clone $bookingQuery)->where('payment_status', 'pending')->count();

        $this->recentBookings = (clone $bookingQuery)->latest('created_at')->take(5)->get();
    }
}
