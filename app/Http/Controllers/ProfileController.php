<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil pengguna.
     */
    public function show()
    {
        $user = Auth::user()->load(['claims.place', 'wishlists', 'reviews.place']);

        // Data untuk 3 tab profil
        $pendingClaim   = $user->claims->where('status', 'pending')->first();
        $approvedClaims = $user->claims->where('status', 'approved');
        $rejectedClaim  = $user->claims->where('status', 'rejected')->sortByDesc('updated_at')->first();
        $wishlistedPlaces = $user->wishlists;
        $userReviews    = $user->reviews->whereNotNull('place_id')->take(10);

        return view('profile.show', compact(
            'user',
            'pendingClaim',
            'approvedClaims',
            'rejectedClaim',
            'wishlistedPlaces',
            'userReviews'
        ));
    }

    /**
     * Update informasi profil pengguna.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'phone'  => ['nullable', 'string', 'max:20'],
            'bio'    => ['nullable', 'string', 'max:500'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $data = [
            'name'  => $request->name,
            'phone' => $request->phone,
            'bio'   => $request->bio,
        ];

        // Upload avatar baru
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Ganti password pengguna.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak cocok.'])->withFragment('tab-keamanan');
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password berhasil diperbarui.')->withFragment('tab-keamanan');
    }
}
