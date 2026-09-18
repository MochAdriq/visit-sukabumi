@extends('layouts.app')

@section('title', $title . ' — Visit Sukabumi')
@section('meta_description', $subtitle)

@section('content')
<div class="min-h-screen bg-white font-sans text-gray-900 pb-16">
    @include('components.navbar')

    {{-- ══════════════════════════════════════════
         1. HERO SECTION (Immersive & Premium)
    ══════════════════════════════════════════ --}}
    <section class="relative h-[80vh] min-h-[580px] w-full flex items-center justify-center overflow-hidden">
        {{-- Background Image --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ $heroImage }}" alt="{{ $title }}" fetchpriority="high" class="w-full h-full object-cover filter brightness-[0.55] transform scale-105 hover:scale-110 transition-transform duration-[20s] ease-out">
        </div>
        
        {{-- Elegant Multi-Stop Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-[#0a192f] via-black/45 to-black/30 z-10"></div>
        
        {{-- Hero Content --}}
        <div class="relative z-20 text-center px-4 max-w-4xl mx-auto mt-12">
            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black text-white tracking-tight leading-tight drop-shadow-2xl mb-4 uppercase">
                {{ $title }}
            </h1>
            
            <p class="text-base sm:text-xl text-gray-200 font-medium max-w-2xl mx-auto leading-relaxed drop-shadow-md mb-8">
                {{ $subtitle }}
            </p>

            <div class="flex items-center justify-center">
                <a href="#kategori-grid" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full bg-[#00aa6c] hover:bg-[#008a57] text-white font-bold text-sm md:text-base transition-all shadow-xl hover:shadow-2xl hover:-translate-y-0.5">
                    <span>Lihat Pilihan Kategori</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                </a>
            </div>
        </div>

        {{-- Scroll Indicator --}}
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex flex-col items-center animate-bounce">
            <span class="text-white/70 text-[11px] font-bold tracking-widest uppercase mb-1.5">Jelajahi</span>
            <svg class="w-5 h-5 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </section>

    {{-- ══════════════════════════════════════════
         2. BREADCRUMBS STRIP
    ══════════════════════════════════════════ --}}
    <div class="border-b border-gray-100 py-3.5 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs md:text-sm text-gray-500 gap-2 items-center flex-wrap">
                <a href="{{ url('/') }}" class="hover:text-[#1a6bbf] transition-colors font-medium">Home</a>
                <span class="text-gray-300">›</span>
                <span class="font-bold text-gray-900">{{ $type === 'wisata' ? 'Wisata' : 'Apa yang Bisa Dilakukan' }}</span>
            </nav>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         3. GRID KATEGORI
    ══════════════════════════════════════════ --}}
    <section id="kategori-grid" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 scroll-mt-20">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold tracking-widest uppercase text-[#1a6bbf] block mb-2">Pilihan Eksplorasi</span>
            <h2 class="text-2xl md:text-3xl font-black text-gray-900 mb-3">Temukan Pengalaman Impian Anda</h2>
            <p class="text-gray-500 text-sm md:text-base">Pilih kategori favorit untuk melihat daftar destinasi terbaik yang telah terverifikasi.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($tags as $tag)
                <a href="{{ $tag->url }}" class="group relative block w-full aspect-square rounded-3xl overflow-hidden shadow-md border border-gray-100 hover:shadow-2xl transition-all duration-500 hover:-translate-y-1.5">
                    {{-- Cover Image --}}
                    <img src="{{ $tag->cover_image }}" alt="{{ $tag->name }}" loading="lazy" decoding="async" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    
                    {{-- Gradient Overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/35 to-black/10 group-hover:from-black/85 transition-colors"></div>
                    
                    {{-- Content --}}
                    <div class="absolute inset-0 p-6 flex flex-col justify-end">
                        <div class="transform transition-transform duration-300 translate-y-0 group-hover:-translate-y-1.5">
                            <div class="w-11 h-11 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center mb-3.5 shadow-sm border border-white/30 text-white group-hover:bg-[#00aa6c] group-hover:border-[#00aa6c] transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {!! $tag->icon_svg !!}
                                </svg>
                            </div>
                            <h3 class="text-xl md:text-2xl font-black text-white mb-1 drop-shadow-md leading-tight group-hover:text-cyan-200 transition-colors">
                                {{ $tag->name }}
                            </h3>
                            @if($tag->description)
                                <p class="text-white/80 text-xs md:text-sm line-clamp-2 leading-relaxed mb-3 font-normal drop-shadow-xs">
                                    {{ $tag->description }}
                                </p>
                            @endif
                            <div class="flex items-center gap-1.5 text-white/90 text-xs font-semibold">
                                <svg class="w-3.5 h-3.5 text-[#00aa6c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>{{ $tag->places_count ?? 0 }} Destinasi Terdaftar</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ══════════════════════════════════════════
         4. MOSAIK EKSPLORASI (Bento Grid Visual)
    ══════════════════════════════════════════ --}}
    <section class="py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-gray-100">
        <div class="text-center mb-14">
            <span class="text-xs font-bold tracking-widest uppercase text-[#1a6bbf] block mb-2">Potret Tatar Pasundan</span>
            <h2 class="text-3xl sm:text-4xl font-black text-gray-900 mb-3">Mosaik Keindahan Sukabumi</h2>
            <p class="text-gray-500 text-sm sm:text-base max-w-xl mx-auto">Dari amfiteater alam purba UNESCO hingga pesona rimbun hutan dan ombak samudra.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 h-auto md:h-[480px]">
            {{-- Geopark Ciletuh --}}
            <div class="group relative rounded-3xl overflow-hidden h-[260px] md:h-full lg:col-span-2 shadow-md">
                <img src="{{ asset('assets/images/4.jpg') }}" alt="UNESCO Geopark Ciletuh Sukabumi" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-950/90 via-gray-900/30 to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6">
                    <span class="text-xs font-bold text-amber-300 uppercase tracking-wider block mb-1">Warisan Dunia</span>
                    <h3 class="text-2xl font-bold text-white mb-1.5">UNESCO Global Geopark Ciletuh</h3>
                    <p class="text-gray-300 text-xs sm:text-sm">Amfiteater tapal kuda raksasa dan deretan air terjun megah yang menghadap samudra lepas.</p>
                </div>
            </div>
            
            {{-- Situ Gunung Highland --}}
            <div class="group relative rounded-3xl overflow-hidden h-[260px] md:h-full shadow-md">
                <img src="{{ asset('assets/images/3.jpg') }}" alt="Highland & Situ Gunung Sukabumi" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-950/90 via-gray-900/30 to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6">
                    <span class="text-xs font-bold text-cyan-300 uppercase tracking-wider block mb-1">Highland & Rimba</span>
                    <h3 class="text-xl font-bold text-white mb-1.5">Situ Gunung & Gede</h3>
                    <p class="text-gray-300 text-xs sm:text-sm">Jembatan gantung terpanjang, danau berkabut, dan udara dingin pegunungan.</p>
                </div>
            </div>

            {{-- Pantai & Samudra --}}
            <div class="group relative rounded-3xl overflow-hidden h-[260px] md:h-full shadow-md">
                <img src="{{ asset('assets/images/5.jpg') }}" alt="Pesisir Samudra & Pantai Sukabumi" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-950/90 via-gray-900/30 to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6">
                    <span class="text-xs font-bold text-emerald-300 uppercase tracking-wider block mb-1">Samudra Hindia</span>
                    <h3 class="text-xl font-bold text-white mb-1.5">Pesisir & Petualangan</h3>
                    <p class="text-gray-300 text-xs sm:text-sm">Gulungan ombak legendaris Cimaja dan arung jeram deras sungai Citarik.</p>
                </div>
            </div>
        </div>
    </section>

    @include('components.footer')
</div>
@endsection
