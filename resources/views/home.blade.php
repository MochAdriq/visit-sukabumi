@extends('layouts.app')

{{-- \u2550\u2550 SEO META: Homepage \u2550\u2550 --}}
@section('title', 'Visit Sukabumi - Panduan digital untuk menjelajah Sukabumi')
@section('meta_description', 'Visit Sukabumi adalah platform digital yang menghubungkan wisatawan, pelaku bisnis, dan pemerintah dalam satu ekosistem pariwisata. Temukan destinasi wisata, event, kuliner, dan penginapan terbaik di Sukabumi.')
@section('canonical', url('/'))
@section('og_type', 'website')
@section('og_title', 'Visit Sukabumi - Panduan digital untuk menjelajah Sukabumi')
@section('og_description', 'Visit Sukabumi adalah platform digital yang menghubungkan wisatawan, pelaku bisnis, dan pemerintah dalam satu ekosistem pariwisata. Temukan destinasi wisata alam, pantai, geopark, event, kuliner, dan penginapan terbaik di Kabupaten Sukabumi.')
@section('og_image', asset('assets/images/og-default.jpg'))
@section('og_image_alt', 'Visit Sukabumi - Panduan digital untuk menjelajah Sukabumi')

{{-- ══ JSON-LD: Organization + WebSite ══ --}}
@push('structured_data')
@php
    $homeSchema = [
        [
            '@type' => 'Organization',
            'name' => 'Visit Sukabumi',
            'url' => url('/'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset('assets/images/logo.png'),
            ],
            'sameAs' => [],
            'description' => 'Visit Sukabumi adalah platform digital yang menghubungkan wisatawan, pelaku bisnis, dan pemerintah dalam satu ekosistem pariwisata.',
            'areaServed' => [
                '@type' => 'AdministrativeArea',
                'name' => 'Kabupaten Sukabumi',
            ],
        ],
        [
            '@type' => 'WebSite',
            'name' => 'Visit Sukabumi',
            'url' => url('/'),
            'inLanguage' => 'id',
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => url('/destinasi') . '?search={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ],
    ];
@endphp
<script type="application/ld+json">
{!! json_encode(['@context' => 'https://schema.org', '@graph' => $homeSchema], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('content')
<div class="min-h-screen bg-white font-sans text-gray-900">
    @include('components.navbar')

<main>

        {{-- SECTION 1: HERO --}}
        <div class="relative bg-gray-900" style="height: 60vh; min-height: 420px;">
            <div class="absolute inset-0">
                <img class="w-full h-full object-cover" src="{{ asset('assets/images/1.webp') }}" alt="Pemandangan Sukabumi" />
                <div class="absolute inset-0 bg-black opacity-35"></div>
            </div>
            <div class="relative max-w-[1380px] mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col items-center justify-center gap-5 md:gap-8">
                <h1 class="text-4xl md:text-7xl font-extrabold text-white drop-shadow-lg text-center" style="text-shadow: 0 4px 14px rgba(0,0,0,0.5);">
                    Jelajahi Sukabumi
                </h1>
                <div class="relative w-full max-w-3xl px-0">
                    <form action="{{ route('place.index') }}" method="GET" class="bg-white h-[54px] md:h-[66px] rounded-full flex items-center justify-between pl-5 md:pl-8 pr-2 shadow-2xl">
                        <div class="flex items-center flex-1 gap-2.5 min-w-0">
                            <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            <input type="text" name="q" placeholder="Cari destinasi..." class="w-full text-[16px] md:text-[18px] text-gray-800 bg-transparent border-none focus:ring-0 outline-none placeholder-gray-400 font-medium min-w-0">
                        </div>
                        <button type="submit" class="h-10 md:h-12 px-6 md:px-8 bg-[#1a6bbf] hover:bg-[#145299] rounded-full flex items-center justify-center text-white font-bold transition-colors shadow-md ml-2 flex-shrink-0 text-[15px] md:text-base cursor-pointer">Cari</button>
                    </form>
                </div>
                <div class="flex flex-wrap justify-center gap-2">
                    @foreach($categories ?? [] as $cat)
                    <a href="{{ url('/place?category=' . $cat->slug) }}" class="px-3.5 py-1.5 md:px-4 md:py-2 bg-white/20 backdrop-blur border border-white/40 text-white text-[13px] md:text-[14px] font-semibold rounded-full hover:bg-white hover:text-[#1a6bbf] transition-all">{{ $cat->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        
        {{-- BANNER INFO (seperti baris merah Visit London) --}}
        <div class="bg-[#1a6bbf] text-white py-5 md:py-6 border-b-4 border-[#145299]">
            <div class="max-w-[1380px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-6 lg:gap-8">
                    
                    {{-- Title --}}
                    <div class="text-center lg:text-left flex-shrink-0">
                        <h2 class="text-2xl md:text-[28px] font-extrabold leading-tight">Panduan Resmi<br class="hidden lg:block"> Wisata Sukabumi</h2>
                    </div>
                    
                    {{-- Features List --}}
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-center gap-6 lg:gap-10 w-full lg:w-auto">
                        
                        {{-- Feature 1 --}}
                        <div class="flex items-center gap-3">
                            <svg class="w-8 h-8 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            <p class="text-[15px] md:text-[17px] leading-snug">Menginspirasi <span class="font-extrabold">ribuan wisatawan</span> setiap tahun</p>
                        </div>

                        {{-- Feature 2 --}}
                        <div class="flex items-center gap-3">
                            <svg class="w-8 h-8 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                            <p class="text-[15px] md:text-[17px] leading-snug"><span class="font-extrabold">Akses mudah</span> ke berbagai destinasi terbaik</p>
                        </div>

                        {{-- Feature 3 --}}
                        <div class="flex items-center gap-3">
                            <svg class="w-8 h-8 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <p class="text-[15px] md:text-[17px] leading-snug">Kunjungan Anda <span class="font-extrabold">mendukung ekonomi lokal</span></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- PROMO BANNER DINAMIS --}}
        @php
            $rawTarget = $homeAd?->url ?: '/jelajahsukabumi/';
            $targetUrl = str_starts_with($rawTarget, 'http') 
                ? $rawTarget 
                : url(rtrim($rawTarget, '/') . '/');
            $bannerImg = $homeAd?->image_url ?: asset('images/ads/adsvis.gif');
            $bannerTitle = $homeAd?->title ?: 'Jelajah Sukabumi — Perjalanan Visual Interaktif';
            $openInNewTab = $homeAd ? $homeAd->open_in_new_tab : false;
        @endphp
        <div class="max-w-[1380px] mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
            <div class="max-w-[970px] mx-auto bg-gray-50 rounded-2xl p-2 sm:p-3 border border-gray-200/80 shadow-xs hover:shadow-md transition-shadow">
                <a href="{{ $targetUrl }}" 
                   @if($openInNewTab) target="_blank" rel="noopener noreferrer" @endif
                   class="block overflow-hidden rounded-xl group" 
                   title="{{ $bannerTitle }}">
                    <img src="{{ $bannerImg }}" 
                         alt="{{ $bannerTitle }}" 
                         class="w-full h-auto object-cover group-hover:scale-[1.01] transition-transform duration-300">
                </a>
            </div>
        </div>

        {{-- SECTION: MUST-SEES SUKABUMI (RECREATE SESUAI SCREENSHOT REFERENCE) --}}
        <style>
            .must-see-card .must-see-desc {
                max-height: 0;
                opacity: 0;
                transform: translateY(14px);
                transition: max-height 0.35s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s ease, transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
                overflow: hidden;
            }
            .must-see-card:hover .must-see-desc {
                max-height: 90px;
                opacity: 1;
                transform: translateY(0);
            }
            .must-see-card:hover .must-see-title {
                text-decoration: underline;
                text-decoration-thickness: 2px;
                text-underline-offset: 4px;
                text-decoration-color: #ffffff;
            }
        </style>

        <div class="bg-white py-10 md:py-14 border-b border-gray-100">
            <div class="max-w-[1380px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-6 md:mb-8">
                    <h2 class="text-[28px] md:text-[34px] font-extrabold text-gray-950 mb-2 tracking-tight">Must-sees</h2>
                    <p class="text-[16px] md:text-[18px] text-gray-700 max-w-4xl leading-relaxed">Liburan ke Sukabumi belum lengkap tanpa merasakan atraksi paling ikonik, petualangan seru, dan pengalaman otentik pilihan berikut.</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-5">
                    {{-- 1. Pacu Adrenalin --}}
                    <a href="{{ route('place.index', ['search' => 'arung jeram']) }}" class="must-see-card group relative block aspect-square rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 bg-gray-900">
                        <img src="https://images.unsplash.com/photo-1530866495561-507c9faab2ed?w=600&auto=format&fit=crop&q=80" 
                             alt="Pacu Adrenalin" 
                             class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"/>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent group-hover:from-black/90 group-hover:via-black/45 transition-colors duration-300 pointer-events-none"></div>

                        {{-- Folded Ribbon Badge --}}
                        <div class="absolute top-3 left-0 z-10">
                            <span class="bg-[#f89e3b] text-gray-950 text-[11px] md:text-xs font-bold px-3 py-1 rounded-r-md shadow-md tracking-tight">
                                Tantang Nyali
                            </span>
                        </div>

                        {{-- Text Container (Strictly Center-Aligned) --}}
                        <div class="absolute bottom-0 inset-x-0 p-4 md:p-5 z-10 flex flex-col items-center justify-end text-center">
                            <h3 class="must-see-title text-[15px] md:text-[17px] font-bold text-white text-center leading-snug drop-shadow-sm transition-all duration-300">
                                Pacu Adrenalin
                            </h3>
                            <div class="must-see-desc">
                                <p class="text-[11px] md:text-[12px] text-white/95 leading-relaxed pt-1.5 text-center line-clamp-3">
                                    Arung jeram, offroad & petualangan menantang pemacu adrenalin.
                                </p>
                            </div>
                        </div>
                    </a>

                    {{-- 2. Sukabumi untuk Anak --}}
                    <a href="{{ route('place.index', ['search' => 'keluarga']) }}" class="must-see-card group relative block aspect-square rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 bg-gray-900">
                        <img src="https://images.unsplash.com/photo-1576013551627-0cc20b96c2a7?w=600&auto=format&fit=crop&q=80" 
                             alt="Sukabumi untuk Anak" 
                             class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"/>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent group-hover:from-black/90 group-hover:via-black/45 transition-colors duration-300 pointer-events-none"></div>

                        {{-- Text Container (Strictly Center-Aligned) --}}
                        <div class="absolute bottom-0 inset-x-0 p-4 md:p-5 z-10 flex flex-col items-center justify-end text-center">
                            <h3 class="must-see-title text-[15px] md:text-[17px] font-bold text-white text-center leading-snug drop-shadow-sm transition-all duration-300">
                                Sukabumi untuk Anak
                            </h3>
                            <div class="must-see-desc">
                                <p class="text-[11px] md:text-[12px] text-white/95 leading-relaxed pt-1.5 text-center line-clamp-3">
                                    Taman rekreasi ramah anak & aktivitas seru untuk keluarga.
                                </p>
                            </div>
                        </div>
                    </a>

                    {{-- 3. Kuliner dan Makanan --}}
                    <a href="{{ route('place.index', ['category' => 'kuliner']) }}" class="must-see-card group relative block aspect-square rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 bg-gray-900">
                        <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=600&auto=format&fit=crop&q=80" 
                             alt="Kuliner dan Makanan" 
                             class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"/>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent group-hover:from-black/90 group-hover:via-black/45 transition-colors duration-300 pointer-events-none"></div>

                        {{-- Folded Ribbon Badge --}}
                        <div class="absolute top-3 left-0 z-10">
                            <span class="bg-[#f89e3b] text-gray-950 text-[11px] md:text-xs font-bold px-3 py-1 rounded-r-md shadow-md tracking-tight">
                                Wajib Dicoba
                            </span>
                        </div>

                        {{-- Text Container (Strictly Center-Aligned) --}}
                        <div class="absolute bottom-0 inset-x-0 p-4 md:p-5 z-10 flex flex-col items-center justify-end text-center">
                            <h3 class="must-see-title text-[15px] md:text-[17px] font-bold text-white text-center leading-snug drop-shadow-sm transition-all duration-300">
                                Kuliner dan Makanan
                            </h3>
                            <div class="must-see-desc">
                                <p class="text-[11px] md:text-[12px] text-white/95 leading-relaxed pt-1.5 text-center line-clamp-3">
                                    Mochi legendaris & santapan lezat otentik Sukabumi.
                                </p>
                            </div>
                        </div>
                    </a>

                    {{-- 4. Budaya dan Sejarah --}}
                    <a href="{{ route('place.index', ['search' => 'sejarah']) }}" class="must-see-card group relative block aspect-square rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 bg-gray-900">
                        <img src="https://images.unsplash.com/photo-1596402184320-417e7178b2cd?w=600&auto=format&fit=crop&q=80" 
                             alt="Budaya dan Sejarah" 
                             class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"/>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent group-hover:from-black/90 group-hover:via-black/45 transition-colors duration-300 pointer-events-none"></div>

                        {{-- Text Container (Strictly Center-Aligned) --}}
                        <div class="absolute bottom-0 inset-x-0 p-4 md:p-5 z-10 flex flex-col items-center justify-end text-center">
                            <h3 class="must-see-title text-[15px] md:text-[17px] font-bold text-white text-center leading-snug drop-shadow-sm transition-all duration-300">
                                Budaya dan Sejarah
                            </h3>
                            <div class="must-see-desc">
                                <p class="text-[11px] md:text-[12px] text-white/95 leading-relaxed pt-1.5 text-center line-clamp-3">
                                    Kasepuhan adat & warisan sejarah tempo dulu.
                                </p>
                            </div>
                        </div>
                    </a>

                    {{-- 5. Santai & Healing --}}
                    <a href="{{ route('place.index', ['search' => 'curug']) }}" class="must-see-card group relative block aspect-square rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 bg-gray-900">
                        <img src="https://images.unsplash.com/photo-1519681393784-d120267933ba?w=600&auto=format&fit=crop&q=80" 
                             alt="Santai & Healing" 
                             class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"/>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent group-hover:from-black/90 group-hover:via-black/45 transition-colors duration-300 pointer-events-none"></div>

                        {{-- Folded Ribbon Badge --}}
                        <div class="absolute top-3 left-0 z-10">
                            <span class="bg-[#f89e3b] text-gray-950 text-[11px] md:text-xs font-bold px-3 py-1 rounded-r-md shadow-md tracking-tight">
                                Favorit
                            </span>
                        </div>

                        {{-- Text Container (Strictly Center-Aligned) --}}
                        <div class="absolute bottom-0 inset-x-0 p-4 md:p-5 z-10 flex flex-col items-center justify-end text-center">
                            <h3 class="must-see-title text-[15px] md:text-[17px] font-bold text-white text-center leading-snug drop-shadow-sm transition-all duration-300">
                                Santai & Healing
                            </h3>
                            <div class="must-see-desc">
                                <p class="text-[11px] md:text-[12px] text-white/95 leading-relaxed pt-1.5 text-center line-clamp-3">
                                    Curug asri berhawa sejuk & pemandian air panas alami.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        {{-- SECTION 2: PILIHAN TERBAIK (DINAMIS ⇄ DESTINASI TERDEKAT) --}}
        <div class="bg-white py-10 md:py-14 border-b border-gray-100">
            <div class="max-w-[1380px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-3 mb-5 md:mb-7">
                    <div>
                        <h2 id="popular-section-title" class="text-[26px] md:text-[34px] font-extrabold text-gray-950 mb-1 tracking-tight">Pilihan Terbaik</h2>
                        <p id="popular-section-subtitle" class="text-[16px] md:text-[18px] text-gray-700 leading-relaxed">Destinasi rekomendasi kurasi khusus untuk pengalaman terbaik di Sukabumi</p>
                    </div>
                </div>

                {{-- Default: Pilihan Terbaik (Diambil dari database via toggle Admin is_featured) --}}
                <div id="content-best-choice" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-5">
                    @forelse($bestChoices as $place)
                    <a href="{{ route('place.show', $place->slug) }}" class="group block">
                        {{-- Photo Container --}}
                        <div class="overflow-hidden rounded-2xl mb-2.5 aspect-[4/3] bg-gray-100 relative">
                            @if($place->badge_label)
                                <span class="absolute top-2.5 left-2.5 bg-gradient-to-r from-amber-500 to-amber-400 text-gray-950 text-xs font-black px-3 py-0.5 rounded-full shadow-md z-10 flex items-center gap-1">
                                    <svg class="w-3 h-3 text-gray-950 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    {{ $place->badge_label }}
                                </span>
                            @elseif($place->is_featured)
                                <span class="absolute top-2.5 left-2.5 bg-amber-400 text-gray-950 text-xs font-extrabold px-3 py-0.5 rounded-full shadow-sm z-10 flex items-center gap-1">
                                    <svg class="w-2.5 h-2.5 text-gray-950 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    Pilihan Terbaik
                                </span>
                            @endif

                            <img src="{{ $place->cover_image_url }}" 
                                 alt="{{ $place->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                            <div class="absolute inset-0 bg-black/5 group-hover:bg-black/0 transition-colors"></div>
                        </div>

                        {{-- Content Below Photo --}}
                        <h4 class="text-[16px] md:text-[17px] font-bold text-gray-900 group-hover:text-[#1a6bbf] leading-snug mb-1 truncate transition-colors">
                            {{ $place->name }}
                        </h4>

                        <div class="flex items-center gap-1.5 text-sm text-gray-500 mb-1.5">
                            <div class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-[#f9a826] fill-current flex-shrink-0" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-bold text-gray-800">{{ number_format($place->reviews_avg_rating ?? 0, 1) }}</span>
                                <span class="text-gray-400">({{ $place->reviews_count ?? 0 }})</span>
                            </div>
                            @if($place->district)
                                <span class="text-gray-300">•</span>
                                <span class="truncate max-w-[130px]">{{ $place->district }}</span>
                            @endif
                        </div>

                        @if($place->description)
                            <p class="text-[13px] text-gray-600 leading-relaxed line-clamp-2">{{ Str::limit(strip_tags($place->description), 90) }}</p>
                        @endif
                    </a>
                    @empty
                    <p class="text-gray-400 text-sm col-span-full">Belum ada destinasi pilihan.</p>
                    @endforelse
                </div>

                {{-- Container Khusus: Destinasi Terdekat (Hidden secara default, aktif saat izin lokasi diberikan) --}}
                <div id="content-nearby" class="hidden grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-5">
                    {{-- Diisi secara dinamis via JavaScript --}}
                </div>

                <div class="mt-8 text-center">
                    <a href="{{ route('place.index') }}" class="inline-flex items-center gap-2 px-8 py-3.5 border-2 border-[#1a6bbf] text-[#1a6bbf] font-bold rounded-full hover:bg-[#1a6bbf] hover:text-white transition-colors text-[15px] md:text-base">
                        Lihat semua destinasi
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- SECTION 3: DESTINASI TERPOPULER (ALL-IN-ONE 5 CARD BY REVIEW) --}}
        <div class="bg-white py-10 md:py-14 border-b border-gray-100">
            <div class="max-w-[1380px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-3 mb-6 md:mb-8">
                    <div>
                        <h2 class="text-[26px] md:text-[34px] font-extrabold text-gray-950 mb-1 tracking-tight">Destinasi Terpopuler</h2>
                        <p class="text-[16px] md:text-[18px] text-gray-700 leading-relaxed">Paling banyak dikunjungi dan direkomendasikan oleh ribuan wisatawan</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-5">
                    @forelse($popularPlaces as $place)
                    <a href="{{ route('place.show', $place->slug) }}" class="group block">
                        {{-- Photo Container --}}
                        <div class="overflow-hidden rounded-2xl mb-2.5 aspect-[4/3] bg-gray-100 relative">
                            @if($place->badge_label)
                                <span class="absolute top-2.5 left-2.5 bg-gradient-to-r from-amber-500 to-amber-400 text-gray-950 text-xs font-black px-3 py-0.5 rounded-full shadow-md z-10 flex items-center gap-1">
                                    <svg class="w-3 h-3 text-gray-950 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    {{ $place->badge_label }}
                                </span>
                            @elseif($loop->first)
                                <span class="absolute top-2.5 left-2.5 bg-[#1a6bbf] text-white text-xs font-bold px-3 py-0.5 rounded-full shadow-sm z-10 flex items-center gap-1">
                                    <svg class="w-2.5 h-2.5 text-amber-300 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    Top #1 Populer
                                </span>
                            @endif

                            <img src="{{ $place->cover_image_url }}" 
                                 alt="{{ $place->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                            <div class="absolute inset-0 bg-black/5 group-hover:bg-black/0 transition-colors"></div>
                        </div>

                        {{-- Content Below Photo --}}
                        <h4 class="text-[16px] md:text-[17px] font-bold text-gray-900 group-hover:text-[#1a6bbf] leading-snug mb-1 truncate transition-colors">
                            {{ $place->name }}
                        </h4>

                        <div class="flex items-center gap-1.5 text-sm text-gray-500 mb-1.5">
                            <div class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-[#f9a826] fill-current flex-shrink-0" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-bold text-gray-800">{{ number_format($place->reviews_avg_rating ?? 0, 1) }}</span>
                                <span class="text-gray-400">({{ $place->reviews_count ?? 0 }})</span>
                            </div>
                            @if($place->district)
                                <span class="text-gray-300">•</span>
                                <span class="truncate max-w-[130px]">{{ $place->district }}</span>
                            @endif
                        </div>

                        @if($place->description)
                            <p class="text-[13px] text-gray-600 leading-relaxed line-clamp-2">{{ Str::limit(strip_tags($place->description), 90) }}</p>
                        @endif
                    </a>
                    @empty
                    <p class="text-gray-400 text-sm col-span-full">Belum ada data destinasi terpopuler.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- SECTION 3B: KULINER TERPOPULER (5 CARD BY REVIEW & RATING) --}}
        <div class="bg-white py-10 md:py-14 border-b border-gray-100">
            <div class="max-w-[1380px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-3 mb-6 md:mb-8">
                    <div>
                        <h2 class="text-[26px] md:text-[34px] font-extrabold text-gray-950 mb-1 tracking-tight">Kuliner Terfavorit & Populer</h2>
                        <p class="text-[16px] md:text-[18px] text-gray-700 leading-relaxed">Cita rasa khas dan tempat makan paling direkomendasikan di Sukabumi</p>
                    </div>
                    <div>
                        <a href="{{ route('place.index', ['category' => 'kuliner']) }}" class="hidden md:inline-flex items-center gap-1.5 text-sm font-bold text-[#1a6bbf] hover:underline">
                            Lihat semua kuliner
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-5">
                    @forelse($popularCulinaries as $place)
                    <a href="{{ route('place.show', $place->slug) }}" class="group block">
                        {{-- Photo Container --}}
                        <div class="overflow-hidden rounded-2xl mb-2.5 aspect-[4/3] bg-gray-100 relative">
                            @if($place->badge_label)
                                <span class="absolute top-2.5 left-2.5 bg-gradient-to-r from-amber-500 to-amber-400 text-gray-950 text-xs font-black px-3 py-0.5 rounded-full shadow-md z-10 flex items-center gap-1">
                                    <svg class="w-3 h-3 text-gray-950 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    {{ $place->badge_label }}
                                </span>
                            @elseif($loop->first)
                                <span class="absolute top-2.5 left-2.5 bg-[#d97706] text-white text-xs font-bold px-3 py-0.5 rounded-full shadow-sm z-10 flex items-center gap-1">
                                    <svg class="w-2.5 h-2.5 text-amber-200 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    Top #1 Kuliner
                                </span>
                            @endif

                            <img src="{{ $place->cover_image_url }}" 
                                 alt="{{ $place->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                            <div class="absolute inset-0 bg-black/5 group-hover:bg-black/0 transition-colors"></div>
                        </div>

                        {{-- Content Below Photo --}}
                        <h4 class="text-[16px] md:text-[17px] font-bold text-gray-900 group-hover:text-[#1a6bbf] leading-snug mb-1 truncate transition-colors">
                            {{ $place->name }}
                        </h4>

                        <div class="flex items-center gap-1.5 text-sm text-gray-500 mb-1.5">
                            <div class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-[#f9a826] fill-current flex-shrink-0" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-bold text-gray-800">{{ number_format($place->reviews_avg_rating ?? 0, 1) }}</span>
                                <span class="text-gray-400">({{ $place->reviews_count ?? 0 }})</span>
                            </div>
                            @if($place->district)
                                <span class="text-gray-300">•</span>
                                <span class="truncate max-w-[130px]">{{ $place->district }}</span>
                            @endif
                        </div>

                        @if($place->description)
                            <p class="text-[13px] text-gray-600 leading-relaxed line-clamp-2">{{ Str::limit(strip_tags($place->description), 90) }}</p>
                        @endif
                    </a>
                    @empty
                    <p class="text-gray-400 text-sm col-span-full">Belum ada data kuliner terpopuler.</p>
                    @endforelse
                </div>

                <div class="mt-8 text-center md:hidden">
                    <a href="{{ route('place.index', ['category' => 'kuliner']) }}" class="inline-flex items-center gap-2 px-6 py-2.5 border border-gray-300 text-gray-700 font-bold rounded-full hover:bg-gray-50 text-sm transition-colors">
                        Lihat semua kuliner
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- SECTION 4: EVENT MENDATANG --}}
        <div class="bg-white py-10 md:py-14 border-b border-gray-100">
            <div class="max-w-[1380px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-3 mb-5 md:mb-7">
                    <div>
                        <h2 class="text-[26px] md:text-[34px] font-extrabold text-gray-950 mb-1 tracking-tight">Event & Festival Mendatang</h2>
                        <p class="text-[16px] md:text-[18px] text-gray-700 leading-relaxed">Jangan sampai ketinggalan acara seru di Sukabumi</p>
                    </div>
                    <div class="flex gap-2 overflow-x-auto pb-1 scrollbar-hide" id="event-filters">
                        <button onclick="filterEvents('minggu-ini', this)" data-filter="minggu-ini" class="event-filter-btn flex-shrink-0 px-3.5 py-1.5 border-2 border-gray-300 text-gray-600 bg-white text-xs md:text-sm font-bold rounded-full hover:border-[#1a6bbf] hover:text-[#1a6bbf] transition-colors">Minggu ini</button>
                        <button onclick="filterEvents('akhir-pekan', this)" data-filter="akhir-pekan" class="event-filter-btn flex-shrink-0 px-3.5 py-1.5 border-2 border-gray-300 text-gray-600 bg-white text-xs md:text-sm font-bold rounded-full hover:border-[#1a6bbf] hover:text-[#1a6bbf] transition-colors">Akhir pekan</button>
                        <button onclick="filterEvents('bulan-ini', this)" data-filter="bulan-ini" class="event-filter-btn flex-shrink-0 px-3.5 py-1.5 border-2 border-gray-300 text-gray-600 bg-white text-xs md:text-sm font-bold rounded-full hover:border-[#1a6bbf] hover:text-[#1a6bbf] transition-colors">Bulan ini</button>
                        <button onclick="filterEvents('semua', this)" data-filter="semua" class="event-filter-btn flex-shrink-0 px-3.5 py-1.5 border-2 border-[#1a6bbf] text-[#1a6bbf] bg-white text-xs md:text-sm font-bold rounded-full hover:bg-[#1a6bbf] hover:text-white transition-colors">Semua</button>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-5" id="event-container">
                    @forelse($upcomingEvents as $event)
                    <a href="{{ route('event.show', $event->slug) }}" class="event-card group relative block overflow-hidden rounded-2xl h-60 shadow-sm border border-gray-100 bg-gray-200" data-date="{{ $event->start_date->format('Y-m-d') }}">
                        @if($event->image_path)
                            <img src="{{ Storage::url($event->image_path) }}" alt="{{ $event->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-[#1a6bbf]/10">
                                <svg class="w-10 h-10 text-[#1a6bbf]/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        <div class="absolute top-3 left-3 bg-white rounded-lg px-2 py-1 text-center shadow">
                            <div class="text-[10px] font-black text-red-500 uppercase">{{ $event->start_date->translatedFormat('M') }}</div>
                            <div class="text-base font-black text-gray-900 leading-none">{{ $event->start_date->format('d') }}</div>
                        </div>
                        <div class="absolute bottom-0 inset-x-0 p-4">
                            <h4 class="text-white font-bold text-[15px] md:text-[16px] leading-tight group-hover:underline mb-1">{{ $event->title }}</h4>
                            @if($event->location_name)
                            <div class="flex items-center text-white/80 text-[12px] md:text-[13px]">
                                <svg class="w-3.5 h-3.5 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $event->location_name }}
                            </div>
                            @endif
                        </div>
                    </a>
                    @empty
                    <div class="col-span-full py-12 text-center">
                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-gray-100 mb-3">
                            <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Belum ada event dalam waktu dekat</h3>
                        <p class="text-gray-500 text-sm mt-1">Pantau terus halaman ini ya!</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- SECTION 5: CERITA TRAVELER --}}
        @if(isset($recentReviews) && $recentReviews->count() > 0)
        @php
            // Divide reviews into 3 columns
            $perColumn = ceil($recentReviews->count() / 3);
            $firstColumn = $recentReviews->slice(0, $perColumn);
            $secondColumn = $recentReviews->slice($perColumn, $perColumn);
            $thirdColumn = $recentReviews->slice($perColumn * 2);
        @endphp
        <style>
            @keyframes scroll-y {
                0% { transform: translateY(0); }
                100% { transform: translateY(-50%); }
            }
            .animate-scroll-y {
                animation: scroll-y linear infinite;
            }
        </style>
        <div class="bg-white py-10 md:py-16 border-b border-gray-100 relative overflow-hidden">
            <div class="max-w-[1380px] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-2xl mx-auto mb-10">
                    <h2 class="text-2xl md:text-4xl lg:text-5xl font-extrabold text-gray-950 tracking-tight">Apa Kata Mereka</h2>
                    <p class="text-[16px] md:text-[18px] text-gray-700 mt-4 leading-relaxed">
                        Ulasan nyata dari ribuan wisatawan yang sudah menikmati indahnya pesona Sukabumi bersama kami.
                    </p>
                </div>

                <div class="flex justify-center gap-4 md:gap-6 mt-10 [mask-image:linear-gradient(to_bottom,transparent,black_20%,black_80%,transparent)] h-[600px] md:h-[740px] overflow-hidden">
                    
                    {{-- Column 1 --}}
                    <div class="w-full md:w-1/3 max-w-[320px]">
                        <div class="flex flex-col gap-4 animate-scroll-y hover:[animation-play-state:paused]" style="animation-duration: 15s;">
                            {{-- Render 2 sets for infinite loop --}}
                            @for($i=0; $i<2; $i++)
                                @foreach($firstColumn as $review)
                                    @include('components.home-review-card', ['review' => $review])
                                @endforeach
                            @endfor
                        </div>
                    </div>

                    {{-- Column 2 --}}
                    <div class="w-full md:w-1/3 max-w-[320px] hidden md:block">
                        <div class="flex flex-col gap-4 animate-scroll-y hover:[animation-play-state:paused]" style="animation-duration: 19s;">
                            @for($i=0; $i<2; $i++)
                                @foreach($secondColumn as $review)
                                    @include('components.home-review-card', ['review' => $review])
                                @endforeach
                            @endfor
                        </div>
                    </div>

                    {{-- Column 3 --}}
                    <div class="w-full md:w-1/3 max-w-[320px] hidden lg:block">
                        <div class="flex flex-col gap-4 animate-scroll-y hover:[animation-play-state:paused]" style="animation-duration: 17s;">
                            @for($i=0; $i<2; $i++)
                                @foreach($thirdColumn as $review)
                                    @include('components.home-review-card', ['review' => $review])
                                @endforeach
                            @endfor
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @endif

    </main>

    {{-- FOOTER --}}
    @include('components.footer')

</div>
@endsection

@push('scripts')
<script>
    function handleUserLocationClick() {
        const btn = document.getElementById('btn-user-location');
        const label = document.getElementById('label-user-location');

        if (!navigator.geolocation) {
            alert('Browser Anda tidak mendukung fitur lokasi GPS.');
            return;
        }

        if (!window.isSecureContext) {
            btn.disabled = false;
            label.textContent = 'Gunakan Lokasi Saya';
            alert('Fitur akses lokasi GPS memerlukan koneksi aman (HTTPS). Silakan buka website ini melalui https://' + window.location.host);
            return;
        }

        label.textContent = 'Mendeteksi...';
        btn.disabled = true;

        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                sessionStorage.setItem('user_lat', lat);
                sessionStorage.setItem('user_lng', lng);
                loadNearbyPlaces(lat, lng);
            },
            function(error) {
                btn.disabled = false;
                label.textContent = 'Gunakan Lokasi Saya';
                console.warn('Geolocation error:', error);
                if (error.code === 1) {
                    alert('Izin akses lokasi ditolak. Silakan izinkan akses lokasi pada browser Anda.');
                } else {
                    alert('Gagal mendeteksi lokasi saat ini. Pastikan GPS/fitur lokasi Anda aktif.');
                }
            },
            { timeout: 10000, enableHighAccuracy: false }
        );
    }

    function loadNearbyPlaces(lat, lng) {
        const bestChoiceContainer = document.getElementById('content-best-choice');
        const nearbyContainer = document.getElementById('content-nearby');
        const title = document.getElementById('popular-section-title');
        const subtitle = document.getElementById('popular-section-subtitle');
        const btn = document.getElementById('btn-user-location');
        const label = document.getElementById('label-user-location');
        const pinIcon = document.getElementById('icon-location-pin');

        if (label) label.textContent = 'Memuat Destinasi...';

        fetch(`/api/places/nearby?lat=${lat}&lng=${lng}`)
            .then(res => res.json())
            .then(res => {
                if (!res.success || !res.data || res.data.length === 0) {
                    if (label) label.textContent = 'Gunakan Lokasi Saya';
                    if (btn) btn.disabled = false;
                    return;
                }

                let html = '';
                res.data.forEach((place, index) => {
                    const isFirst = index === 0;
                    let badgeHtml = '';
                    if (place.badge_label) {
                        badgeHtml = `<span class="absolute top-2.5 left-2.5 bg-gradient-to-r from-amber-500 to-amber-400 text-gray-950 text-[10px] md:text-[11px] font-black px-2.5 py-0.5 rounded-full shadow-md z-10 flex items-center gap-1"><svg class="w-3 h-3 text-gray-950 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>${place.badge_label}</span>`;
                    } else if (isFirst) {
                        badgeHtml = `<span class="absolute top-2.5 left-2.5 bg-[#1a6bbf] text-white text-[10px] md:text-[11px] font-bold px-2.5 py-0.5 rounded-full shadow-sm z-10 flex items-center gap-1"><svg class="w-2.5 h-2.5 text-amber-300 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>Terdekat</span>`;
                    }

                    const rating = place.reviews_avg_rating ? parseFloat(place.reviews_avg_rating).toFixed(1) : '0.0';
                    const reviewsCount = place.reviews_count ?? 0;
                    const distance = place.distance ? `${place.distance.toFixed(1)} km` : '';
                    const district = place.district ? `<span class="text-gray-300">•</span><span class="truncate max-w-[130px]">${place.district}</span>` : '';
                    const distanceBadge = distance ? `<span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">${distance}</span>` : '';
                    const desc = place.description ? `<p class="text-[13px] text-gray-600 leading-relaxed line-clamp-2">${place.description}</p>` : '';

                    html += `
                    <a href="/place/${place.slug}" class="group block">
                        <div class="overflow-hidden rounded-2xl mb-2.5 aspect-[4/3] bg-gray-100 relative">
                            ${badgeHtml}
                            <img src="${place.cover_image_url}" alt="${place.name}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                            <div class="absolute inset-0 bg-black/5 group-hover:bg-black/0 transition-colors"></div>
                        </div>
                        <h4 class="text-[16px] md:text-[17px] font-bold text-gray-900 group-hover:text-[#1a6bbf] leading-snug mb-1 truncate transition-colors">${place.name}</h4>
                        <div class="flex items-center gap-1.5 text-sm text-gray-500 mb-1.5 flex-wrap">
                            <div class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-[#f9a826] fill-current flex-shrink-0" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-bold text-gray-800">${rating}</span>
                                <span class="text-gray-400">(${reviewsCount})</span>
                            </div>
                            ${district}
                            ${distanceBadge}
                        </div>
                        ${desc}
                    </a>`;
                });

                if (bestChoiceContainer) bestChoiceContainer.classList.add('hidden');
                if (nearbyContainer) {
                    nearbyContainer.innerHTML = html;
                    nearbyContainer.classList.remove('hidden');
                }
                if (title) title.textContent = 'Destinasi Terdekat';
                if (subtitle) subtitle.textContent = 'Menampilkan destinasi wisata yang paling dekat dari lokasi Anda saat ini';
                if (label) label.textContent = 'Lokasi Terdeteksi';
                if (btn) {
                    btn.classList.remove('bg-blue-50/80', 'text-[#1a6bbf]', 'border-blue-200');
                    btn.classList.add('bg-emerald-50', 'text-emerald-700', 'border-emerald-200');
                    btn.disabled = false;
                }
                if (pinIcon) pinIcon.classList.add('text-emerald-600');
            })
            .catch(err => {
                console.error('Error loading nearby places:', err);
                if (label) label.textContent = 'Gunakan Lokasi Saya';
                if (btn) btn.disabled = false;
            });
    }

    document.addEventListener("DOMContentLoaded", function() {
        const savedLat = sessionStorage.getItem('user_lat');
        const savedLng = sessionStorage.getItem('user_lng');
        if (savedLat && savedLng) {
            loadNearbyPlaces(savedLat, savedLng);
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        const allBtn = document.querySelector('[data-filter="semua"]') || document.querySelector('.event-filter-btn:last-child');
        if (allBtn) filterEvents('semua', allBtn);
    });

    function filterEvents(filterType, btnElement) {
        document.querySelectorAll('.event-filter-btn').forEach(btn => {
            btn.classList.remove('border-[#1a6bbf]', 'text-[#1a6bbf]');
            btn.classList.add('border-gray-300', 'text-gray-600');
        });
        btnElement.classList.remove('border-gray-300', 'text-gray-600');
        btnElement.classList.add('border-[#1a6bbf]', 'text-[#1a6bbf]');

        const today = new Date(); today.setHours(0,0,0,0);
        let endDate = new Date(today);
        if (filterType === 'minggu-ini') { const day = today.getDay() || 7; endDate.setDate(today.getDate() + (7 - day)); }
        else if (filterType === 'akhir-pekan') { const day = today.getDay() || 7; endDate.setDate(today.getDate() + (day <= 5 ? (6 - day) + 1 : 1)); }
        else if (filterType === 'bulan-ini') { endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0); }
        else { endDate = new Date('2099-12-31'); }

        const cards = document.querySelectorAll('.event-card');
        let visible = 0;
        cards.forEach(card => {
            const d = new Date(card.getAttribute('data-date')); d.setHours(0,0,0,0);
            const match = filterType === 'akhir-pekan' ? (d.getDay() === 0 || d.getDay() === 6) : (filterType === 'semua' ? true : (d >= today && d <= endDate));
            card.style.display = (match && visible < 4) ? 'block' : 'none';
            if (match && visible < 4) visible++;
        });

        let msg = document.getElementById('empty-event-msg');
        if (visible === 0 && cards.length > 0) {
            if (!msg) { msg = document.createElement('div'); msg.id = 'empty-event-msg'; msg.className = 'col-span-full py-10 text-center'; msg.innerHTML = '<h3 class="text-base font-bold text-gray-700">Belum ada event untuk filter ini</h3>'; document.getElementById('event-container').appendChild(msg); }
            msg.style.display = 'block';
        } else if (msg) { msg.style.display = 'none'; }
    }
</script>
@endpush
