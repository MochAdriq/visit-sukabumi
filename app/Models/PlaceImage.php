<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlaceImage extends Model
{
    protected $fillable = ['place_id', 'image_path', 'is_primary', 'copyright_name', 'copyright_link'];

    protected $attributes = [
        'is_primary' => false,
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (PlaceImage $image) {
            $image->is_primary = (bool) ($image->is_primary ?? false);
        });
    }

    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }
}
