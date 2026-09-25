<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategory = $request->get('category', 'all');

        $categories = [
            'all'           => 'Semua Video',
            'Wisata Alam'   => 'Wisata Alam & Geopark',
            'Budaya & Event'=> 'Budaya & Event',
            'Kuliner'       => 'Kuliner',
            'Dokumentasi'   => 'Dokumentasi Resmi',
        ];

        $query = Video::where('is_active', true);

        if ($selectedCategory !== 'all' && !empty($selectedCategory)) {
            $query->where('category', $selectedCategory);
        }

        $videos = $query->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(12)
            ->withQueryString();

        $featuredVideo = null;
        if ($videos->currentPage() === 1 && $selectedCategory === 'all') {
            $featuredVideo = Video::where('is_active', true)
                ->where('is_featured', true)
                ->orderBy('sort_order', 'asc')
                ->first();
        }

        return view('video.index', compact('videos', 'categories', 'selectedCategory', 'featuredVideo'));
    }
}
