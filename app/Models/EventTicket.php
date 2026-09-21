<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class EventTicket extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'description',
        'price',
        'quota',
        'available_quota',
        'sale_start_at',
        'sale_end_at',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quota' => 'integer',
        'available_quota' => 'integer',
        'sale_start_at' => 'datetime',
        'sale_end_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function bookings(): MorphMany
    {
        return $this->morphMany(Booking::class, 'bookable');
    }
}
