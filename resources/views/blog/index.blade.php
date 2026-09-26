@extends('layouts.app')

@section('title', 'Jurnal & Berita Wisata — Visit Sukabumi')
@section('meta_description', 'Portal berita, panduan wisata, eksplorasi alam, kuliner legendaris, dan cerita perjalanan autentik di Sukabumi.')

@section('content')
<div class="min-h-screen bg-[#fcfcfd] text-gray-900 font-sans pb-16 antialiased selection:bg-emerald-100 selection:text-emerald-900">
    @include('components.navbar')

    {{-- ── 1. SUB-CHANNEL EDITORIAL RIBBON (KANAL BAR KOMPAS LIFESTYLE) ────── --}}
    <section class="bg-white border-b border-gray-200 sticky top-0 z-30 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14 gap-4 overflow-x-auto no-scrollbar">
                
                {{-- Channel Brand / Label --}}
                <div class="flex items-center gap-2 shrink-0 pr-4 border-r border-gray-200">
                    <span class="text-xs font-black uppercase tracking-widest text-emerald-800">
                        Jurnal Wisata
                    </span>
                </div>

                {{-- Channel Links (Strict Anti-Slop: Plain typography with underline indicator, NO pill capsules) --}}
                <nav class="flex items-center gap-1 sm:gap-2 text-sm font-semibold whitespace-nowrap flex-1 overflow-x-auto no-scrollbar py-2">
                    <a href="{{ route('blog.index') }}" 
                       class="px-3 py-2 transition-colors border-b-2 {{ !request('category') ? 'border-emerald-700 text-emerald-800 font-bold' : 'border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300' }}">
                        Semua
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('blog.index', ['category' => $cat->category]) }}" 
                           class="px-3 py-2 transition-colors border-b-2 {{ request('category') === $cat->category ? 'border-emerald-700 text-emerald-800 font-bold' : 'border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300' }}">
                            {{ $cat->category }}
                        </a>
                    @endforeach
                </nav>

                {{-- Compact Search Trigger / Input --}}
                <div class="shrink-0 hidden md:block">
                    <form action="{{ route('blog.index') }}" method="GET" class="relative flex items-center">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <input type="text" 
                               name="q" 
                               value="{{ request('q') }}" 
                               placeholder="Cari artikel..." 
                               class="w-48 lg:w-64 pl-8 pr-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-md focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 transition-all placeholder-gray-400">
                        <button type="submit" class="absolute left-2.5 text-gray-400 hover:text-gray-600" aria-label="Cari">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">

        {{-- ── FILTER / SEARCH ACTIVE BANNER ────────────────────────────────── --}}
        @if($isFiltered)
            <div class="mb-8 pb-5 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Hasil Pencarian & Filter</span>
                    <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight mt-1">
                        @if(request('q') && request('category'))
                            Topik "{{ request('category') }}" dengan kata kunci "{{ request('q') }}"
                        @elseif(request('q'))
                            Pencarian: "{{ request('q') }}"
                        @elseif(request('category'))
                            Kategori: {{ request('category') }}
                        @else
                            Arsip Artikel
                        @endif
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">Menampilkan {{ $posts->total() }} artikel terpublikasi</p>
                </div>
                <div>
                    <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-600 hover:text-emerald-700 bg-gray-100 hover:bg-gray-200 px-3.5 py-2 rounded-md transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Reset Filter
                    </a>
                </div>
            </div>
        @endif

        {{-- ── 2. HERO EDITORIAL SHOWCASE (KOMPAS ASYMMETRICAL 3-COLUMN) ───── --}}
        @if(!$isFiltered && $headlinePost)
            <section class="mb-14 pb-12 border-b border-gray-200">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    {{-- 2A. PRIMARY HEADLINE (Left 7 Cols) --}}
                    <div class="lg:col-span-5 flex flex-col">
                        @php
                            $headlineImg = $headlinePost->image_path 
                                ? (str_starts_with($headlinePost->image_path, 'http') ? $headlinePost->image_path : Storage::url($headlinePost->image_path)) 
                                : ($headlinePost->youtube_thumbnail_url ?? null);
                        @endphp
                        <article class="group flex flex-col h-full">
                            <a href="{{ route('blog.show', $headlinePost->slug) }}" class="block relative aspect-[16/10] overflow-hidden rounded-xl bg-gray-100 mb-4 shadow-xs">
                                @if($headlineImg)
                                    <img src="{{ $headlineImg }}" 
                                         alt="{{ $headlinePost->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif

                                @if($headlinePost->youtube_id || $headlinePost->category === 'Video')
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/10 transition-colors pointer-events-none">
                                        <div class="w-12 h-12 rounded-full bg-white/95 text-emerald-800 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                            <svg class="w-5 h-5 ml-0.5 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        </div>
                                    </div>
                                @endif
                            </a>

                            <div class="flex flex-col flex-1">
                                {{-- Anti-Slop: Plain Text Category Kicker --}}
                                <div class="mb-2">
                                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">
                                        {{ $headlinePost->category }}
                                    </span>
                                </div>

                                <a href="{{ route('blog.show', $headlinePost->slug) }}" class="block mb-2.5">
                                    <h2 class="text-2xl sm:text-3xl font-black text-gray-900 leading-tight group-hover:text-emerald-700 transition-colors">
                                        {{ $headlinePost->title }}
                                    </h2>
                                </a>

                                <p class="text-gray-600 text-sm sm:text-base leading-relaxed line-clamp-3 mb-4 flex-1">
                                    {{ $headlinePost->excerpt ?? Str::limit(strip_tags($headlinePost->content), 150) }}
                                </p>

                                <div class="flex items-center text-xs text-gray-500 gap-2 mt-auto pt-2 border-t border-gray-100">
                                    @if($headlinePost->author_display_name)
                                        <span class="font-semibold text-gray-700">{{ $headlinePost->author_display_name }}</span>
                                        <span>•</span>
                                    @endif
                                    <time datetime="{{ $headlinePost->published_at ?? $headlinePost->created_at }}">
                                        {{ ($headlinePost->published_at ?? $headlinePost->created_at)->translatedFormat('d F Y') }}
                                    </time>
                                </div>
                            </div>
                        </article>
                    </div>

                    {{-- 2B. SECONDARY HEADLINES (Middle 4 Cols - Stack of 4) --}}
                    <div class="lg:col-span-4 flex flex-col divide-y divide-gray-100 border-t lg:border-t-0 lg:border-l border-gray-100 pt-6 lg:pt-0 lg:pl-6">
                        @foreach($subHeadlinePosts as $subPost)
                            @php
                                $subImg = $subPost->image_path 
                                    ? (str_starts_with($subPost->image_path, 'http') ? $subPost->image_path : Storage::url($subPost->image_path)) 
                                    : ($subPost->youtube_thumbnail_url ?? null);
                            @endphp
                            <article class="group py-3 first:pt-0 last:pb-0 flex items-start gap-3.5">
                                <a href="{{ route('blog.show', $subPost->slug) }}" class="block relative w-24 h-18 sm:w-28 sm:h-20 shrink-0 overflow-hidden rounded-lg bg-gray-100 shadow-2xs">
                                    @if($subImg)
                                        <img src="{{ $subImg }}" 
                                             alt="{{ $subPost->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif

                                    @if($subPost->youtube_id || $subPost->category === 'Video')
                                        <div class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/10 transition-colors pointer-events-none">
                                            <div class="w-7 h-7 rounded-full bg-white/95 text-emerald-800 flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                                <svg class="w-3 h-3 ml-0.5 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                            </div>
                                        </div>
                                    @endif
                                </a>

                                <div class="flex-1 min-w-0">
                                    <div class="mb-0.5">
                                        <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700">
                                            {{ $subPost->category }}
                                        </span>
                                    </div>
                                    <a href="{{ route('blog.show', $subPost->slug) }}" class="block">
                                        <h3 class="text-xs sm:text-sm font-bold text-gray-900 leading-snug group-hover:text-emerald-700 transition-colors line-clamp-2">
                                            {{ $subPost->title }}
                                        </h3>
                                    </a>
                                    <div class="text-[11px] text-gray-400 mt-1">
                                        {{ ($subPost->published_at ?? $subPost->created_at)->translatedFormat('d M Y') }}
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    {{-- 2C. TERPOPULER RANKING 1-5 (Right 3 Cols - Kompas Side Ranking) --}}
                    <div class="lg:col-span-3 border-t lg:border-t-0 lg:border-l border-gray-100 pt-6 lg:pt-0 lg:pl-6 flex flex-col">
                        <div class="flex items-center justify-between mb-4 pb-2 border-b-2 border-gray-900">
                            <h2 class="text-sm font-black uppercase tracking-wider text-gray-900">
                                Terpopuler
                            </h2>
                            <span class="text-[11px] font-semibold text-gray-400">Paling Dibaca</span>
                        </div>

                        <div class="flex flex-col divide-y divide-gray-100 flex-1">
                            @foreach($popularPosts as $index => $popPost)
                                <article class="group py-3 first:pt-0 last:pb-0 flex items-start gap-3">
                                    <span class="text-2xl font-black text-gray-300 group-hover:text-emerald-600 transition-colors w-6 text-center leading-none pt-0.5 shrink-0">
                                        {{ $index + 1 }}
                                    </span>
                                    <div class="flex-1 min-w-0">
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 block mb-0.5">
                                            {{ $popPost->category }}
                                        </span>
                                        <a href="{{ route('blog.show', $popPost->slug) }}" class="block">
                                            <h3 class="text-xs sm:text-sm font-bold text-gray-900 leading-snug group-hover:text-emerald-700 transition-colors line-clamp-2">
                                                {{ $popPost->title }}
                                            </h3>
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>

                </div>
            </section>
        @endif

        {{-- ── 3. SECTION "PILIHAN UNTUKMU" (EDITORIAL GRID 3 KOLOM) ───────── --}}
        @if(!$isFiltered && $curatedPosts->isNotEmpty())
            <section class="mb-14 pb-12 border-b border-gray-200">
                <div class="flex items-center justify-between mb-6 pb-2.5 border-b border-gray-200">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-emerald-600 rounded-xs"></span>
                        <h2 class="text-base sm:text-lg font-black uppercase tracking-wider text-gray-900">
                            Pilihan Untukmu
                        </h2>
                    </div>
                    <span class="text-xs text-gray-500 font-medium">Rekomendasi Editor</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                    @foreach($curatedPosts as $curated)
                        @php
                            $cImg = $curated->image_path 
                                ? (str_starts_with($curated->image_path, 'http') ? $curated->image_path : Storage::url($curated->image_path)) 
                                : ($curated->youtube_thumbnail_url ?? null);
                        @endphp
                        <article class="group flex flex-col">
                            <a href="{{ route('blog.show', $curated->slug) }}" class="block relative aspect-[16/10] overflow-hidden rounded-xl bg-gray-100 mb-3.5 shadow-2xs">
                                @if($cImg)
                                    <img src="{{ $cImg }}" 
                                         alt="{{ $curated->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif

                                @if($curated->youtube_id || $curated->category === 'Video')
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/10 transition-colors pointer-events-none">
                                        <div class="w-10 h-10 rounded-full bg-white/95 text-emerald-800 flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                            <svg class="w-4 h-4 ml-0.5 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        </div>
                                    </div>
                                @endif
                            </a>

                            <div class="mb-1.5">
                                <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">
                                    {{ $curated->category }}
                                </span>
                            </div>

                            <a href="{{ route('blog.show', $curated->slug) }}" class="block mb-2">
                                <h3 class="text-base font-bold text-gray-900 group-hover:text-emerald-700 transition-colors leading-snug line-clamp-2">
                                    {{ $curated->title }}
                                </h3>
                            </a>

                            <p class="text-xs sm:text-sm text-gray-600 line-clamp-2 mb-3 leading-relaxed">
                                {{ $curated->excerpt ?? Str::limit(strip_tags($curated->content), 100) }}
                            </p>

                            <div class="text-[11px] text-gray-400 mt-auto pt-2 border-t border-gray-100 flex items-center justify-between">
                                <span>{{ ($curated->published_at ?? $curated->created_at)->translatedFormat('d F Y') }}</span>
                                <span class="font-medium text-emerald-700 group-hover:translate-x-0.5 transition-transform flex items-center gap-1">
                                    Baca 
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- ── 4. MAIN FEED (TERKINI 68% : STICKY SIDEBAR 32%) ─────────────── --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            {{-- 4A. MAIN CONTENT STREAM (Left 8 Cols ~67%) --}}
            <div class="lg:col-span-8">
                
                {{-- Stream Header & Mobile Search Bar --}}
                <div class="flex items-center justify-between mb-6 pb-2.5 border-b-2 border-gray-900">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-4 bg-emerald-700 rounded-xs"></span>
                        <h2 class="text-lg sm:text-xl font-black uppercase tracking-wider text-gray-900">
                            {{ $isFiltered ? 'Daftar Artikel' : 'Terkini' }}
                        </h2>
                    </div>
                    <span class="text-xs text-gray-500 font-medium">Update Wawasan Wisata</span>
                </div>

                {{-- Mobile-only search form --}}
                <div class="block md:hidden mb-6">
                    <form action="{{ route('blog.index') }}" method="GET" class="relative flex items-center">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <input type="text" 
                               name="q" 
                               value="{{ request('q') }}" 
                               placeholder="Cari artikel atau panduan wisata..." 
                               class="w-full pl-9 pr-4 py-2.5 text-sm bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 shadow-2xs">
                        <button type="submit" class="absolute left-3 text-gray-400" aria-label="Cari">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </form>
                </div>

                {{-- Horizontal Media List Stream --}}
                @if($posts->count() > 0)
                    <div class="divide-y divide-gray-100">
                        @foreach($posts as $post)
                            @php
                                $feedImg = $post->image_path 
                                    ? (str_starts_with($post->image_path, 'http') ? $post->image_path : Storage::url($post->image_path)) 
                                    : ($post->youtube_thumbnail_url ?? null);
                            @endphp
                            <article class="group py-6 first:pt-0 flex flex-col sm:flex-row gap-5 items-start">
                                
                                {{-- Thumbnail Horizontal --}}
                                <a href="{{ route('blog.show', $post->slug) }}" class="block relative w-full sm:w-56 md:w-64 aspect-[16/10] shrink-0 overflow-hidden rounded-xl bg-gray-100 shadow-2xs">
                                    @if($feedImg)
                                        <img src="{{ $feedImg }}" 
                                             alt="{{ $post->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif

                                    @if($post->youtube_id || $post->category === 'Video')
                                        <div class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/10 transition-colors pointer-events-none">
                                            <div class="w-10 h-10 rounded-full bg-white/95 text-emerald-800 flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                                <svg class="w-4 h-4 ml-0.5 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                            </div>
                                        </div>
                                    @endif
                                </a>

                                {{-- Text Content --}}
                                <div class="flex-1 min-w-0 flex flex-col h-full">
                                    {{-- Anti-Slop: Plain category kicker --}}
                                    <div class="mb-1.5">
                                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">
                                            {{ $post->category }}
                                        </span>
                                    </div>

                                    <a href="{{ route('blog.show', $post->slug) }}" class="block mb-2">
                                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 group-hover:text-emerald-700 transition-colors leading-snug line-clamp-2">
                                            {{ $post->title }}
                                        </h3>
                                    </a>

                                    <p class="text-gray-600 text-sm leading-relaxed line-clamp-2 mb-3">
                                        {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 140) }}
                                    </p>

                                    <div class="flex items-center text-xs text-gray-400 gap-2 mt-auto">
                                        @if($post->author_display_name)
                                            <span class="font-medium text-gray-600">{{ $post->author_display_name }}</span>
                                            <span>•</span>
                                        @endif
                                        <time datetime="{{ $post->published_at ?? $post->created_at }}">
                                            {{ ($post->published_at ?? $post->created_at)->translatedFormat('d F Y') }}
                                        </time>
                                    </div>
                                </div>

                            </article>
                        @endforeach
                    </div>

                    {{-- Pagination Links --}}
                    <div class="mt-10 pt-6 border-t border-gray-200">
                        {{ $posts->links() }}
                    </div>

                @else
                    {{-- Empty State --}}
                    <div class="bg-white rounded-2xl border border-gray-200 p-12 text-center my-6 shadow-2xs">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Belum Ada Artikel</h3>
                        <p class="text-sm text-gray-500 max-w-sm mx-auto mb-6">
                            @if(request('q') || request('category'))
                                Tidak ditemukan artikel dengan kriteria pencarian saat ini. Silakan coba kata kunci atau filter lain.
                            @else
                                Konten jurnal dan panduan wisata terbaru sedang disiapkan oleh tim redaksi kami.
                            @endif
                        </p>
                        @if(request('q') || request('category'))
                            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-1.5 px-5 py-2.5 text-xs font-bold text-gray-900 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors">
                                Lihat Semua Artikel
                            </a>
                        @endif
                    </div>
                @endif

            </div>

            {{-- 4B. STICKY SIDEBAR (Right 4 Cols ~33%) --}}
            <aside class="lg:col-span-4 space-y-8">
                
                {{-- Widget 1: Destinasi Wisata Pilihan --}}
                @if($recommendedPlaces->isNotEmpty())
                    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-2xs">
                        <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-100">
                            <h3 class="text-xs font-black uppercase tracking-wider text-gray-900">
                                Destinasi Sukabumi
                            </h3>
                            <a href="{{ route('place.index') }}" class="text-[11px] font-bold text-emerald-700 hover:underline">
                                Eksplor Semua
                            </a>
                        </div>

                        <div class="space-y-4">
                            @foreach($recommendedPlaces as $place)
                                @php
                                    $pImg = $place->primaryImage 
                                        ? (str_starts_with($place->primaryImage->image_path, 'http') ? $place->primaryImage->image_path : Storage::url($place->primaryImage->image_path)) 
                                        : null;
                                @endphp
                                <a href="{{ route('place.show', $place->slug) }}" class="group flex items-center gap-3.5">
                                    <div class="w-16 h-16 shrink-0 rounded-lg overflow-hidden bg-gray-100 shadow-2xs">
                                        @if($pImg)
                                            <img src="{{ $pImg }}" 
                                                 alt="{{ $place->name }}" 
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 block truncate">
                                            {{ $place->category->name ?? 'Destinasi' }}
                                        </span>
                                        <h4 class="text-xs sm:text-sm font-bold text-gray-900 group-hover:text-emerald-700 transition-colors truncate">
                                            {{ $place->name }}
                                        </h4>
                                        <p class="text-[11px] text-gray-500 mt-0.5 truncate flex items-center gap-1">
                                            <svg class="w-3 h-3 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            </svg>
                                            {{ $place->district ?? 'Sukabumi' }}
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Widget 2: Kategori & Topik --}}
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-2xs">
                    <h3 class="text-xs font-black uppercase tracking-wider text-gray-900 pb-3 mb-4 border-b border-gray-100">
                        Kategori Wisata
                    </h3>
                    <div class="space-y-1.5">
                        @foreach($categories as $cat)
                            <a href="{{ route('blog.index', ['category' => $cat->category]) }}" 
                               class="flex items-center justify-between py-2 px-2.5 rounded-lg text-xs font-medium transition-colors {{ request('category') === $cat->category ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-gray-700 hover:bg-gray-50 hover:text-emerald-700' }}">
                                <span>{{ $cat->category }}</span>
                                <span class="text-[11px] text-gray-400 {{ request('category') === $cat->category ? 'text-emerald-700' : '' }}">
                                    {{ $cat->count }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Widget 3: Sponsor / Promosi Pariwisata --}}
                @php
                    $sidebarAd = \App\Models\Advertisement::getRandomAd('sidebar', 'blog');
                @endphp
                @if($sidebarAd)
                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-2xs">
                        <div class="text-[10px] uppercase font-bold tracking-wider text-gray-400 text-center mb-2">
                            Sponsor Visit Sukabumi
                        </div>
                        <a href="{{ $sidebarAd->link ?? '#' }}" target="_blank" rel="noopener noreferrer" class="block overflow-hidden rounded-lg">
                            <img src="{{ Storage::url($sidebarAd->image_path) }}" alt="{{ $sidebarAd->title ?? 'Iklan' }}" class="w-full h-auto object-cover rounded-lg hover:opacity-95 transition-opacity">
                        </a>
                    </div>
                @else
                    {{-- Default Tourism CTA Widget --}}
                    <div class="bg-gradient-to-br from-emerald-800 to-teal-900 text-white p-6 rounded-xl shadow-xs">
                        <span class="text-[10px] font-extrabold uppercase tracking-widest text-emerald-300 block mb-2">
                            Jelajahi Sukabumi
                        </span>
                        <h4 class="text-base font-black leading-snug mb-2">
                            Punya Rekomendasi Tempat Wisata Unik?
                        </h4>
                        <p class="text-xs text-emerald-100/90 leading-relaxed mb-4">
                            Bagikan cerita atau daftarkan tempat wisatamu untuk masuk ke direktori resmi pariwisata Visit Sukabumi.
                        </p>
                        <a href="{{ route('place.index') }}" class="inline-flex items-center justify-center w-full py-2 px-4 bg-white text-emerald-900 text-xs font-bold rounded-lg hover:bg-emerald-50 transition-colors shadow-2xs">
                            Jelajahi Direktori Destinasi
                        </a>
                    </div>
                @endif

            </aside>

        </div>

    </main>
</div>

@include('components.footer')
@endsection
