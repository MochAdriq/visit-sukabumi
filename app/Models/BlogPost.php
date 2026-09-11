<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image_path',
        'author_id',
        'author_name',
        'category',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (BlogPost $post) {
            if ($post->status === 'published' && is_null($post->published_at)) {
                $post->published_at = now();
            }
        });
    }

    /** Route model binding by slug */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function places(): BelongsToMany
    {
        return $this->belongsToMany(Place::class, 'blog_post_place');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(BlogComment::class, 'blog_post_id')->where('is_approved', true)->latest();
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    public function getExcerptAttribute(): string
    {
        return Str::limit(strip_tags($this->content), 120);
    }

    public function getAuthorDisplayNameAttribute(): string
    {
        return $this->author_name ?: ($this->author?->name ?? 'Admin Visit Sukabumi');
    }
}
