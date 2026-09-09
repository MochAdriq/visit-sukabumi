<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Place $place)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'nullable|string|max:1000',
            'visit_type' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
        ]);

        // Cek apakah user sudah mereview tempat ini
        $existingReview = Review::where('user_id', Auth::id())
                                ->where('place_id', $place->id)
                                ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk tempat ini.');
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reviews', 'public');
        }

        Review::create([
            'user_id' => Auth::id(),
            'place_id' => $place->id,
            'rating' => $validated['rating'],
            'content' => $validated['content'],
            'visit_type' => $validated['visit_type'],
            'image_path' => $imagePath,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil ditambahkan.');
    }
}
