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

        $isFiltered = $request->filled('q') || $request->filled('category') || ((int)$request->get('page', 1) > 1);

        // Showcase editorial (headline + subheadlines + pilihan) aktif di landing utama tanpa filter
        $headlinePost = null;
        $subHeadlinePosts = collect();
        $curatedPosts = collect();

        if (!$isFiltered) {
            $showcasePosts = BlogPost::published()
                ->with('author')
                ->latest('published_at')
                ->limit(8)
                ->get();

            $headlinePost = $showcasePosts->first();
            $subHeadlinePosts = $showcasePosts->slice(1, 4)->values();
            $curatedPosts = $showcasePosts->slice(5, 3)->values();
        }

        // Aliran artikel terkini dengan paginasi
        $posts = $query->latest('published_at')->paginate(10)->withQueryString();

        // 5 Artikel Terpopuler untuk sidebar ranking ala Kompas.com
        $popularPosts = BlogPost::published()
            ->withCount('comments')
            ->orderByDesc('comments_count')
            ->latest('published_at')
            ->limit(5)
            ->get();

        // Destinasi wisata Sukabumi pilihan untuk widget sidebar
        $recommendedPlaces = \App\Models\Place::where('status', 'published')
            ->with(['primaryImage', 'category'])
            ->inRandomOrder()
            ->limit(4)
            ->get();

        // Daftar kategori unik beserta jumlah artikel untuk menu ribbon & sidebar
        $categories = BlogPost::published()
            ->select('category')
            ->selectRaw('count(*) as count')
            ->groupBy('category')
            ->orderBy('category')
            ->get();

        return view('blog.index', compact(
            'posts',
            'categories',
            'headlinePost',
            'subHeadlinePosts',
            'curatedPosts',
            'popularPosts',
            'recommendedPlaces',
            'isFiltered'
        ));
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

        $post->load(['author', 'places.primaryImage', 'comments.user']);

        $related = BlogPost::published()
            ->where('category', $post->category)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->limit(4)
            ->get();

        // 5 Artikel Terpopuler untuk widget ranking Kompas.com
        $popularPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->withCount('comments')
            ->orderByDesc('comments_count')
            ->latest('published_at')
            ->limit(5)
            ->get();

        // Destinasi unggulan untuk widget sidebar
        $recommendedPlaces = \App\Models\Place::where('status', 'published')
            ->with(['primaryImage', 'category'])
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('blog.show', compact('post', 'related', 'popularPosts', 'recommendedPlaces'));
    }
}
