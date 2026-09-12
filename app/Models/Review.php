<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = ['user_id', 'place_id', 'event_id', 'rating', 'content', 'visit_type', 'image_path', 'likes_count', 'official_response', 'official_responded_at'];

    protected $casts = [
        'official_responded_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function likes()
    {
        return $this->hasMany(ReviewLike::class);
    }

    public function isLikedBy($user): bool
    {
        if (!$user) {
            return false;
        }

        $userId = is_numeric($user) ? $user : $user->id;
        return $this->likes()->where('user_id', $userId)->exists();
    }
}
