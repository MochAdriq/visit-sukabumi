<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = [
        'place_id',
        'name',
        'description',
        'type',
        'price',
        'date',
        'quota',
        'is_active',
    ];

    protected $casts = [
        'date' => 'datetime',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }
}
