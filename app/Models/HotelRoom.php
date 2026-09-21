<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class HotelRoom extends Model
{
    protected $fillable = [
        'place_id',
        'name',
        'description',
        'price_per_night',
        'total_rooms',
        'max_guests',
        'facilities',
        'images',
        'is_active',
    ];

    protected $casts = [
        'price_per_night' => 'decimal:2',
        'total_rooms' => 'integer',
        'max_guests' => 'integer',
        'facilities' => 'array',
        'images' => 'array',
        'is_active' => 'boolean',
    ];

    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }

    public function bookings(): MorphMany
    {
        return $this->morphMany(Booking::class, 'bookable');
    }
}
