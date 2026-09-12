<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'icon_svg',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    protected static function booted()
    {
        static::saved(function ($tag) {
            Cache::forget('tags_page_activity');
            Cache::forget('tags_page_wisata');
            Cache::forget("tag_cover_{$tag->id}");
        });

        static::deleted(function ($tag) {
            Cache::forget('tags_page_activity');
            Cache::forget('tags_page_wisata');
            Cache::forget("tag_cover_{$tag->id}");
        });
    }

    /** Route model binding by slug */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function places(): BelongsToMany
    {
        return $this->belongsToMany(Place::class, 'place_tag');
    }

    /** Label tipe dalam Bahasa Indonesia */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'activity' => 'Apa yang Bisa Dilakukan',
            'wisata'   => 'Wisata',
            default    => ucfirst($this->type),
        };
    }

    /** URL gambar sampul dinamis (diambil dari salah satu tempat di dalamnya) */
    public function getCoverImageAttribute(): string
    {
        return Cache::remember("tag_cover_{$this->id}", 86400, function () {
            $place = $this->places()
                ->whereHas('primaryImage')
                ->with('primaryImage')
                ->first();

            if ($place && $place->primaryImage) {
                return Storage::url($place->primaryImage->image_path);
            }

            return $this->type === 'wisata' 
                ? asset('assets/images/12.jpg')
                : asset('assets/images/11.jpg');
        });
    }

    /** URL halaman listing tag ini */
    public function getUrlAttribute(): string
    {
        return match ($this->type) {
            'activity' => route('tag.show.activity', $this->slug),
            'wisata'   => route('tag.show.wisata', $this->slug),
            default    => '#',
        };
    }

    /** Scope hanya tag bertipe activity */
    public function scopeActivity($query)
    {
        return $query->where('type', 'activity')->orderBy('sort_order');
    }

    /** Scope hanya tag bertipe wisata */
    public function scopeWisata($query)
    {
        return $query->where('type', 'wisata')->orderBy('sort_order');
    }
}
