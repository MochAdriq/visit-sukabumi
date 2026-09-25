<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Advertisement extends Model
{
    protected $fillable = [
        'title',
        'image_path',
        'url',
        'position',
        'format',
        'target_pages',
        'sort_order',
        'open_in_new_tab',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'open_in_new_tab' => 'boolean',
        'sort_order' => 'integer',
        'target_pages' => 'array',
    ];

    public static function getCurrentPageKey(): string
    {
        if (request()->is('/') || request()->routeIs('home')) {
            return 'home';
        }
        if (request()->is('place/*') || request()->routeIs('place.show')) {
            return 'place_detail';
        }
        if (request()->is('wisata*') || request()->is('aktivitas*') || request()->is('penginapan*') || request()->is('kuliner*') || request()->is('place*') || request()->routeIs('place.*')) {
            return 'places';
        }
        if (request()->is('event*') || request()->routeIs('event.*')) {
            return 'events';
        }
        if (request()->is('blog*') || request()->is('panduan-wisata*') || request()->routeIs('blog.*') || request()->routeIs('guide.*')) {
            return 'blog';
        }
        return 'other';
    }

    public static function getRandomAd(string $slotType = 'landscape', ?string $pageKey = null, ?string $forcedFormat = null): ?self
    {
        // Hindari iklan di halaman admin, dinas, mitra, atau autentikasi
        if (request()->is('admin*') || request()->is('kelola*') || request()->is('dinas*') || request()->is('login*') || request()->is('register*')) {
            return null;
        }

        // Tentukan format yang dipatenkan:
        // place_sidebar / portrait wajib PORTRAIT, slot lainnya wajib LANDSCAPE
        $expectedFormat = $forcedFormat ?: (($slotType === 'place_sidebar' || $slotType === 'portrait') ? 'portrait' : 'landscape');
        $page = $pageKey ?: self::getCurrentPageKey();

        return self::where('is_active', true)
            ->where('format', $expectedFormat)
            ->where(function ($query) use ($page) {
                $query->whereNull('target_pages')
                    ->orWhereJsonContains('target_pages', 'all')
                    ->orWhereJsonContains('target_pages', $page);
            })
            ->inRandomOrder()
            ->first();
    }

    public function getImageUrlAttribute(): string
    {
        if (empty($this->image_path)) {
            return asset('images/ads/adsvis.gif');
        }

        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }

        if (str_starts_with($this->image_path, 'images/')) {
            return asset($this->image_path);
        }

        return Storage::url($this->image_path);
    }
}
