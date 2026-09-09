<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'start_date',
        'end_date',
        'location_name',
        'image_path',
        'is_active',
        'whats_included',
        'what_to_expect',
        'meeting_and_pickup',
        'cancellation_policy',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function itineraries()
    {
        return $this->hasMany(EventItinerary::class)->orderBy('order_num');
    }
}
