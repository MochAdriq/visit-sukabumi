<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Event;
use App\Models\BlogPost;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $places = Place::where('status', 'published')
            ->select('slug', 'updated_at')
            ->orderBy('updated_at', 'desc')
            ->get();

        $events = Event::where('is_active', true)
            ->select('slug', 'updated_at')
            ->orderBy('updated_at', 'desc')
            ->get();

        $posts = BlogPost::where('status', 'published')
            ->select('slug', 'updated_at', 'published_at')
            ->orderBy('published_at', 'desc')
            ->get();

        $content = view('sitemap', compact('places', 'events', 'posts'))->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }
}
