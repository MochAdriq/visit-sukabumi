@extends('layouts.app')

@section('title', 'Blog & Artikel — Visit Sukabumi')
@section('meta_description', 'Kumpulan panduan wisata, tips perjalanan, berita, dan inspirasi liburan di Sukabumi.')

@section('content')
<div class="min-h-screen bg-gray-50 font-sans text-gray-900 pb-16">
    @include('components.navbar')

    {{-- ── HERO HEADER ─────────────────────────────────────────────────── --}}
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16 text-center">
            <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 tracking-tight leading-tight">
                Jelajah & Cerita
            </h1>
            <p class="mt-4 text-gray-600 text-base md:text-xl max-w-2xl mx-auto leading-relaxed">
                Temukan panduan, tips perjalanan, dan cerita inspiratif untuk menyempurnakan liburanmu di Sukabumi.
            </p>
            
            {{-- Search Bar --}}
            <div class="mt-8 max-w-xl mx-auto">
                <form action="{{ route('blog.index') }}" method="GET" class="relative flex items-center">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari artikel atau panduan..." class="w-full pl-5 pr-14 py-3.5 rounded-full border border-gray-300 focus:ring-2 focus:ring-[#00aa6c] focus:border-[#00aa6c] outline-none transition-all text-sm md:text-base shadow-sm">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <button type="submit" class="absolute right-2 w-10 h-10 bg-[#1a6bbf] hover:bg-[#135a9e] text-white rounded-full flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <main class="pt-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- FILTER KATEGORI --}}
        <div class="flex flex-wrap items-center justify-center gap-2 mb-10">
            <a href="{{ route('blog.index') }}" class="px-5 py-2 text-sm font-semibold rounded-full border transition-all {{ !request('category') ? 'bg-gray-900 text-white border-gray-900 shadow-sm' : 'bg-white text-gray-600 border-gray-200 hover:border-gray-900 hover:text-gray-900' }}">
                Semua Artikel
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('blog.index', ['category' => $cat]) }}" class="px-5 py-2 text-sm font-semibold rounded-full border transition-all {{ request('category') === $cat ? 'bg-[#00aa6c] text-white border-[#00aa6c] shadow-sm' : 'bg-white text-gray-600 border-gray-200 hover:border-[#00aa6c] hover:text-[#00aa6c]' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        {{-- LISTING GRID --}}
        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                    <article class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col h-full">
                        <a href="{{ route('blog.show', $post->slug) }}" class="block relative aspect-[16/10] overflow-hidden bg-gray-100">
                            @if($post->image_path)
                                <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-gray-900 text-xs font-bold rounded-lg shadow-sm">
                                    {{ $post->category }}
                                </span>
                            </div>
                        </a>
                        <div class="p-6 flex flex-col flex-1">
                            <div class="flex items-center text-xs text-gray-500 mb-3 gap-3">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $post->published_at->format('d M Y') }}
                                </div>
                                @if($post->author)
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        {{ $post->author->name }}
                                    </div>
                                @endif
                            </div>
                            <a href="{{ route('blog.show', $post->slug) }}" class="block mb-3">
                                <h3 class="text-xl font-bold text-gray-900 leading-tight group-hover:text-[#1a6bbf] transition-colors line-clamp-2">
                                    {{ $post->title }}
                                </h3>
                            </a>
                            <p class="text-gray-600 text-sm leading-relaxed line-clamp-3 mb-5 flex-1">
                                {{ $post->excerpt }}
                            </p>
                            <a href="{{ route('blog.show', $post->slug) }}" class="inline-flex items-center gap-1 text-sm font-bold text-[#1a6bbf] hover:text-[#135a9e] transition-colors mt-auto">
                                Baca Selengkapnya 
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
            
            {{-- PAGINATION --}}
            <div class="mt-12">
                {{ $posts->links() }}
            </div>

        @else
            {{-- EMPTY STATE --}}
            <div class="bg-white rounded-3xl border border-gray-100 p-16 flex flex-col items-center justify-center text-center shadow-sm my-10 max-w-3xl mx-auto">
                <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Belum ada artikel</h3>
                <p class="text-gray-500 max-w-md mx-auto mb-8 text-lg">
                    @if(request('q') || request('category'))
                        Maaf, tidak ada artikel yang sesuai dengan kriteria pencarian Anda.
                    @else
                        Kami sedang menyiapkan konten-konten menarik untuk Anda. Mampir lagi nanti ya!
                    @endif
                </p>
                @if(request('q') || request('category'))
                    <a href="{{ route('blog.index') }}" class="inline-flex items-center justify-center px-8 py-3.5 border border-gray-300 shadow-sm text-sm font-bold rounded-full text-gray-900 bg-white hover:bg-gray-50 transition-colors">
                        Lihat Semua Artikel
                    </a>
                @endif
            </div>
        @endif

    </main>
</div>
@endsection
