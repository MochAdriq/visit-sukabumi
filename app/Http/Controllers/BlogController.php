<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::published()->with('author');

        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($category = $request->get('category')) {
            $query->where('category', $category);
        }

        $posts = $query->latest('published_at')->paginate(12)->withQueryString();

        // Get unique categories for filter
        $categories = BlogPost::published()->select('category')->distinct()->pluck('category');

        return view('blog.index', compact('posts', 'categories'));
    }

    public function show(BlogPost $post)
    {
        if ($post->status !== 'published') {
            $isAdmin = (auth()->check() && (auth()->user()->role === 'admin' || empty(auth()->user()->role)))
                || (class_exists(\Filament\Facades\Filament::class) && \Filament\Facades\Filament::auth()->check());

            if (!$isAdmin) {
                abort(404);
            }
        }

        $post->load(['author', 'places', 'comments.user']);

        $related = BlogPost::published()
            ->where('category', $post->category)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('blog.show', compact('post', 'related'));
    }
}
