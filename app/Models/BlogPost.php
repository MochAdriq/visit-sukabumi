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
        'youtube_url',
        'youtube_id',
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
            if (!empty($post->youtube_url)) {
                $post->youtube_id = self::extractYoutubeId($post->youtube_url);
            }
        });
    }

    public static function extractYoutubeId(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        $url = trim($url);
        $patterns = [
            '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/shorts\/)([^"&?\/ ]{11})/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        if (strlen($url) === 11 && preg_match('/^[a-zA-Z0-9_-]{11}$/', $url)) {
            return $url;
        }

        return null;
    }

    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        return $this->youtube_id ? "https://www.youtube-nocookie.com/embed/{$this->youtube_id}?rel=0" : null;
    }

    public function getYoutubeThumbnailUrlAttribute(): ?string
    {
        return $this->youtube_id ? "https://img.youtube.com/vi/{$this->youtube_id}/maxresdefault.jpg" : null;
    }

    public function getEmbedUrlAttribute(): ?string
    {
        return $this->youtube_embed_url;
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->youtube_thumbnail_url ?? ($this->image_path ? asset('storage/' . $this->image_path) : null);
    }

    public function getHqThumbnailUrlAttribute(): ?string
    {
        return $this->youtube_id ? "https://img.youtube.com/vi/{$this->youtube_id}/hqdefault.jpg" : $this->thumbnail_url;
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
