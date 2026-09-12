<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Kontrol akses panel Filament.
     * - Panel 'admin' hanya bisa diakses oleh role=admin
     * - Panel 'kelola' hanya bisa diakses oleh user yang memiliki klaim tempat yang disetujui
     */
    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->role === 'admin';
        }

        if ($panel->getId() === 'kelola') {
            return $this->claims()->where('status', 'approved')->exists();
        }

        return false;
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'phone',
        'bio',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * URL avatar untuk ditampilkan di UI.
     * Fallback ke inisial nama jika tidak ada avatar.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return Storage::url($this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=1a6bbf&color=fff&bold=true&size=128';
    }

    /**
     * Destinasi yang sudah diklaim dan disetujui oleh user ini.
     */
    public function ownedPlaces(): HasMany
    {
        return $this->hasMany(Place::class, 'owner_id');
    }

    /**
     * Semua pengajuan klaim yang dilakukan oleh user ini.
     */
    public function claims(): HasMany
    {
        return $this->hasMany(PlaceClaim::class);
    }

    /**
     * Klaim yang masih menunggu persetujuan.
     */
    public function pendingClaim(): ?\App\Models\PlaceClaim
    {
        return $this->claims()->where('status', 'pending')->with('place')->first();
    }

    /**
     * Klaim yang disetujui (sudah menjadi mitra resmi).
     */
    public function approvedClaims()
    {
        return $this->claims()->where('status', 'approved')->with('place');
    }

    /**
     * Klaim terakhir yang ditolak.
     */
    public function lastRejectedClaim(): ?\App\Models\PlaceClaim
    {
        return $this->claims()->where('status', 'rejected')->latest()->with('place')->first();
    }

    /**
     * Destinasi yang di-wishlist oleh user ini.
     */
    public function wishlists()
    {
        return $this->belongsToMany(Place::class, 'wishlists')->withTimestamps();
    }

    /**
     * Ulasan yang ditulis oleh user ini.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Apakah user adalah mitra aktif (memiliki tempat terverifikasi).
     */
    public function isMitra(): bool
    {
        return $this->claims()->where('status', 'approved')->exists();
    }

    /**
     * Apakah user adalah admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
