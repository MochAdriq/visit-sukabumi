<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Video extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'youtube_url',
        'youtube_id',
        'category',
        'description',
        'duration',
        'is_featured',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
        'sort_order'  => 'integer',
    ];

    protected static function booted()
    {
        static::saving(function ($video) {
            if (!empty($video->youtube_url)) {
                $video->youtube_id = self::extractYoutubeId($video->youtube_url);
            }
            if (empty($video->slug) && !empty($video->title)) {
                $video->slug = Str::slug($video->title);
            }
        });
    }

    public static function extractYoutubeId(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        $url = trim($url);

        // Pola berbagai format URL YouTube (watch, youtu.be, embed, shorts)
        $patterns = [
            '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/shorts\/)([^"&?\/ ]{11})/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        // Jika user hanya menginput ID 11 karakter
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $url)) {
            return $url;
        }

        return null;
    }

    public function getEmbedUrlAttribute(): string
    {
        $id = $this->youtube_id ?: self::extractYoutubeId($this->youtube_url);
        if (!$id) {
            return '';
        }

        return "https://www.youtube.com/embed/{$id}?rel=0&modestbranding=1&enablejsapi=1&origin=" . urlencode(url('/'));
    }

    public function getThumbnailUrlAttribute(): string
    {
        $id = $this->youtube_id ?: self::extractYoutubeId($this->youtube_url);
        if (!$id) {
            return asset('assets/images/og-default.jpg');
        }

        return "https://img.youtube.com/vi/{$id}/maxresdefault.jpg";
    }

    public function getHqThumbnailUrlAttribute(): string
    {
        $id = $this->youtube_id ?: self::extractYoutubeId($this->youtube_url);
        if (!$id) {
            return asset('assets/images/og-default.jpg');
        }

        return "https://img.youtube.com/vi/{$id}/hqdefault.jpg";
    }
}
