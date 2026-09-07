<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Place extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'description',
        'address', 'latitude', 'longitude', 'status',
        'price', 'phone', 'website', 'open_hours', 'duration', 'ticket_info',
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
}
