<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Event;
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

    public function storeEvent(Request $request, Event $event)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'nullable|string|max:1000',
            'visit_type' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
        ]);

        // Cek apakah user sudah mereview event ini
        $existingReview = Review::where('user_id', Auth::id())
                                ->where('event_id', $event->id)
                                ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk event ini.');
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reviews', 'public');
        }

        Review::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'rating' => $validated['rating'],
            'content' => $validated['content'],
            'visit_type' => $validated['visit_type'],
            'image_path' => $imagePath,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil ditambahkan.');
    }

    public function toggleLike(Review $review)
    {
        $userId = Auth::id();
        $existing = \App\Models\ReviewLike::where('user_id', $userId)
            ->where('review_id', $review->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $review->decrement('likes_count');
            $liked = false;
        } else {
            \App\Models\ReviewLike::create([
                'user_id' => $userId,
                'review_id' => $review->id,
            ]);
            $review->increment('likes_count');
            $liked = true;
        }

        $freshCount = max(0, (int) $review->fresh()->likes_count);

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likes_count' => $freshCount,
        ]);
    }
}
