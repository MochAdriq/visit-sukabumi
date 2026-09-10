<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $fillable = [
        'title',
        'image_path',
        'url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
