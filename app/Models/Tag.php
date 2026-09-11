<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
