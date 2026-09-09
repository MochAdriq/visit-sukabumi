<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventItinerary extends Model
{
    protected $fillable = [
        'event_id',
        'title',
        'description',
        'duration_text',
        'image_path',
        'latitude',
        'longitude',
        'order_num',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
