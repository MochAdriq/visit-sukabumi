<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Place extends Model
{
    protected $fillable = [
        // Core
        'category_id', 'name', 'slug', 'description',
        'address', 'district', 'latitude', 'longitude', 'status',
        'price', 'phone', 'website', 'open_hours', 'duration', 'ticket_info',
        'facilities', 'nearby_places',

        // Master Toggles
        'has_ticket', 'has_accommodation', 'has_restaurant',
        'has_tour_package', 'has_accessibility_warning', 'has_general_price',

        // Tiket
        'ticket_price', 'ticket_booking_url', 'ticket_terms',

        // Penginapan
        'hotel_star', 'hotel_facilities', 'hotel_booking_url',

        // Restoran
        'restaurant_is_halal', 'restaurant_menu_url', 'restaurant_reservation_url',

        // Paket Tur
        'tour_packages', 'tour_meeting_point', 'tour_guide_contact',

        // Aksesibilitas
        'accessibility_note', 'accessibility_type',
    ];

    protected $casts = [
        'facilities'       => 'array',
        'hotel_facilities' => 'array',
        'tour_packages'    => 'array',
        'has_ticket'                => 'boolean',
        'has_accommodation'         => 'boolean',
        'has_restaurant'            => 'boolean',
        'has_tour_package'          => 'boolean',
        'has_accessibility_warning' => 'boolean',
        'has_general_price'         => 'boolean',
        'restaurant_is_halal'       => 'boolean',
    ];

    /** Route model binding by slug instead of id */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function placeImages(): HasMany
    {
        return $this->hasMany(PlaceImage::class);
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(PlaceImage::class)->where('is_primary', true)->latestOfMany();
    }

    /** Average rating from reviews (0–5) */
    public function avgRating(): float
    {
        return round($this->reviews->avg('rating') ?? 0, 1);
    }

    /**
     * Get the users who wishlisted this place.
     */
    public function wishlistedBy()
    {
        return $this->belongsToMany(User::class, 'wishlists')->withTimestamps();
    }
}
