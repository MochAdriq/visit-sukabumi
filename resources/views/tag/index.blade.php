@extends('layouts.app')

@section('title', $title . ' — Visit Sukabumi')

@section('content')
<div class="min-h-screen bg-white font-sans text-gray-900 pb-16">
    @include('components.navbar')

    {{-- HERO BANNER --}}
    <div class="w-full h-[350px] md:h-[450px] relative">
        <div class="absolute inset-0">
            <img src="{{ $heroImage }}" alt="{{ $title }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
        </div>
        
        <div class="absolute inset-0 flex flex-col items-center justify-end pb-12 md:pb-16 px-4 text-center">
            <div class="max-w-4xl mx-auto">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-white text-xs font-bold uppercase tracking-widest mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Explore Sukabumi
                </div>
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4 tracking-tight drop-shadow-lg leading-tight">
                    {{ $title }}
                </h1>
                <p class="text-white/90 text-sm md:text-lg max-w-2xl mx-auto drop-shadow-md">
                    {{ $subtitle }}
                </p>
            </div>
        </div>
    </div>

    {{-- GRID KATEGORI --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 relative z-20">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @foreach($tags as $tag)
                <a href="{{ $tag->url }}" class="group relative block w-full aspect-square rounded-2xl md:rounded-[2rem] overflow-hidden shadow-lg border border-white/10 hover:shadow-2xl transition-all duration-300">
                    {{-- Cover Image --}}
                    <img src="{{ $tag->cover_image }}" alt="{{ $tag->name }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    
                    {{-- Gradient Overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-black/10 group-hover:from-black/80 transition-colors"></div>
                    
                    {{-- Content --}}
                    <div class="absolute inset-0 p-5 md:p-6 flex flex-col justify-end">
                        <div class="transform transition-transform duration-300 translate-y-0 group-hover:-translate-y-2">
                            <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center mb-3 shadow-sm border border-white/30 text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {!! $tag->icon_svg !!}
                                </svg>
                            </div>
                            <h3 class="text-xl md:text-2xl font-bold text-white mb-1 drop-shadow-md leading-tight">
                                {{ $tag->name }}
                            </h3>
                            <div class="flex items-center gap-1.5 text-white/80 text-sm font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $tag->places_count ?? 0 }} Destinasi
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@include('components.footer')
@endsection
