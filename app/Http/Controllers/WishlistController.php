<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Auth::user()->wishlists()->with(['category', 'primaryImage'])->get();
        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle(Place $place)
    {
        $user = Auth::user();
        
        if ($user->wishlists()->where('place_id', $place->id)->exists()) {
            $user->wishlists()->detach($place->id);
            return back()->with('success', 'Destinasi dihapus dari wishlist.');
        } else {
            $user->wishlists()->attach($place->id);
            return back()->with('success', 'Destinasi berhasil ditambahkan ke wishlist!');
        }
    }
}
