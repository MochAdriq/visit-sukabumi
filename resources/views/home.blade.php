@extends('layouts.app')

{{-- \u2550\u2550 SEO META: Homepage \u2550\u2550 --}}
@section('title', 'Visit Sukabumi \u2014 Panduan Wisata Terlengkap Kabupaten Sukabumi')
@section('meta_description', 'Temukan destinasi wisata alam, pantai, geopark, event, kuliner, dan penginapan terbaik di Kabupaten Sukabumi. Panduan perjalanan lengkap dari Visit Sukabumi.')
@section('canonical', url('/'))
@section('og_type', 'website')
@section('og_title', 'Visit Sukabumi \u2014 Panduan Wisata Kabupaten Sukabumi')
@section('og_description', 'Temukan destinasi wisata alam, pantai, geopark, event, kuliner, dan penginapan terbaik di Kabupaten Sukabumi.')
@section('og_image', asset('assets/images/og-default.jpg'))
@section('og_image_alt', 'Visit Sukabumi \u2014 Panduan Wisata Kabupaten Sukabumi')

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
            'description' => 'Platform panduan wisata resmi Kabupaten Sukabumi — destinasi, event, kuliner, penginapan, dan inspirasi perjalanan.',
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
            <div class="relative max-w-7xl mx-auto px-4 md:px-6 h-full flex flex-col items-center justify-center gap-5 md:gap-8">
                <h1 class="text-3xl md:text-7xl font-bold text-white drop-shadow-lg text-center" style="text-shadow: 0 4px 12px rgba(0,0,0,0.4);">
                    Jelajahi Sukabumi
                </h1>
                <div class="relative w-full max-w-3xl px-0">
                    <form action="{{ route('place.index') }}" method="GET" class="bg-white h-[52px] md:h-[64px] rounded-full flex items-center justify-between pl-5 md:pl-8 pr-2 shadow-2xl">
                        <div class="flex items-center flex-1 gap-2 min-w-0">
                            <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            <input type="text" name="q" placeholder="Cari destinasi..." class="w-full text-[15px] md:text-[17px] text-gray-700 bg-transparent border-none focus:ring-0 outline-none placeholder-gray-400 font-medium min-w-0">
                        </div>
                        <button type="submit" class="h-10 md:h-12 px-5 md:px-8 bg-[#1a6bbf] hover:bg-[#145299] rounded-full flex items-center justify-center text-white font-bold transition-colors shadow-md ml-2 flex-shrink-0 text-sm md:text-base">Cari</button>
                    </form>
                </div>
                <div class="flex flex-wrap justify-center gap-2">
                    @foreach($categories ?? [] as $cat)
                    <a href="{{ url('/place?category=' . $cat->slug) }}" class="px-3 py-1 md:px-4 md:py-1.5 bg-white/20 backdrop-blur border border-white/40 text-white text-[12px] md:text-[13px] font-semibold rounded-full hover:bg-white hover:text-[#1a6bbf] transition-all">{{ $cat->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- BANNER INFO (seperti baris merah Visit London) --}}
        <div class="bg-[#1a6bbf] text-white py-5 md:py-6 border-b-4 border-[#145299]">
            <div class="max-w-7xl mx-auto px-4 md:px-6">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-6 lg:gap-8">
                    
                    {{-- Title --}}
                    <div class="text-center lg:text-left flex-shrink-0">
                        <h2 class="text-xl md:text-2xl font-extrabold leading-tight">Panduan Resmi<br class="hidden lg:block"> Wisata Sukabumi</h2>
                    </div>
                    
                    {{-- Features List --}}
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-center gap-6 lg:gap-10 w-full lg:w-auto">
                        
                        {{-- Feature 1 --}}
                        <div class="flex items-center gap-3">
                            <svg class="w-8 h-8 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            <p class="text-sm leading-tight">Menginspirasi <span class="font-bold">ribuan wisatawan</span> setiap tahun</p>
                        </div>

                        {{-- Feature 2 --}}
                        <div class="flex items-center gap-3">
                            <svg class="w-8 h-8 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                            <p class="text-sm leading-tight"><span class="font-bold">Akses mudah</span> ke berbagai destinasi terbaik</p>
                        </div>

                        {{-- Feature 3 --}}
                        <div class="flex items-center gap-3">
                            <svg class="w-8 h-8 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <p class="text-sm leading-tight">Kunjungan Anda <span class="font-bold">mendukung ekonomi lokal</span></p>
                        </div>

                    </div>
                </div>
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

        <div class="bg-[#fafbfc] py-10 md:py-14 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 md:px-6">
                <div class="mb-6 md:mb-8">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-1.5">Must-sees</h2>
                    <p class="text-[13px] md:text-[14px] text-gray-600 max-w-3xl">Liburan ke Sukabumi belum lengkap tanpa merasakan atraksi paling ikonik, petualangan seru, dan pengalaman otentik pilihan berikut.</p>
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
            <div class="max-w-7xl mx-auto px-4 md:px-6">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-3 mb-5 md:mb-7">
                    <div>
                        <div class="flex flex-wrap items-center gap-2.5 mb-1">
                            <h2 id="popular-section-title" class="text-xl md:text-3xl font-bold text-gray-900">Pilihan Terbaik</h2>
                            <button type="button" id="btn-user-location" onclick="handleUserLocationClick()" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border transition-all duration-200 bg-blue-50/80 text-[#1a6bbf] border-blue-200 hover:bg-blue-100 hover:border-blue-300 cursor-pointer shadow-xs" title="Tampilkan tempat wisata terdekat dari posisi Anda">
                                <svg class="w-3.5 h-3.5 text-[#1a6bbf] flex-shrink-0 transition-transform" id="icon-location-pin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span id="label-user-location">Gunakan Lokasi Saya</span>
                            </button>
                        </div>
                        <p id="popular-section-subtitle" class="text-[13px] md:text-[14px] text-gray-500">Destinasi rekomendasi kurasi khusus untuk pengalaman terbaik di Sukabumi</p>
                    </div>
                </div>

                {{-- Default: Pilihan Terbaik (Diambil dari database via toggle Admin is_featured) --}}
                <div id="content-best-choice" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-5">
                    @forelse($bestChoices as $place)
                    <a href="{{ route('place.show', $place->slug) }}" class="group block">
                        {{-- Photo Container --}}
                        <div class="overflow-hidden rounded-2xl mb-2.5 aspect-[4/3] bg-gray-100 relative">
                            @if($place->badge_label)
                                <span class="absolute top-2.5 left-2.5 bg-gradient-to-r from-amber-500 to-amber-400 text-gray-950 text-[10px] md:text-[11px] font-black px-2.5 py-0.5 rounded-full shadow-md z-10 flex items-center gap-1">
                                    <svg class="w-3 h-3 text-gray-950 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    {{ $place->badge_label }}
                                </span>
                            @elseif($place->is_featured)
                                <span class="absolute top-2.5 left-2.5 bg-amber-400 text-gray-950 text-[10px] md:text-[11px] font-extrabold px-2.5 py-0.5 rounded-full shadow-sm z-10 flex items-center gap-1">
                                    <svg class="w-2.5 h-2.5 text-gray-950 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    Pilihan Terbaik
                                </span>
                            @endif

                            <img src="{{ $place->primaryImage ? Storage::url($place->primaryImage->image_path) : 'https://placehold.co/400x300/e2e8f0/64748b?text=' . urlencode($place->name) }}" 
                                 alt="{{ $place->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                            <div class="absolute inset-0 bg-black/5 group-hover:bg-black/0 transition-colors"></div>
                        </div>

                        {{-- Content Below Photo --}}
                        <h4 class="text-[14px] md:text-[15px] font-bold text-gray-900 group-hover:text-[#1a6bbf] leading-snug mb-1 truncate transition-colors">
                            {{ $place->name }}
                        </h4>

                        <div class="flex items-center gap-1.5 text-xs text-gray-500 mb-1.5">
                            <div class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-[#f9a826] fill-current flex-shrink-0" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-bold text-gray-800">{{ number_format($place->reviews_avg_rating ?? 0, 1) }}</span>
                                <span class="text-gray-400">({{ $place->reviews_count ?? 0 }})</span>
                            </div>
                            @if($place->district)
                                <span class="text-gray-300">•</span>
                                <span class="truncate max-w-[110px]">{{ $place->district }}</span>
                            @endif
                        </div>

                        @if($place->description)
                            <p class="text-[12px] text-gray-500 leading-relaxed line-clamp-2">{{ Str::limit(strip_tags($place->description), 90) }}</p>
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
                    <a href="{{ route('place.index') }}" class="inline-flex items-center gap-2 px-8 py-3 border-2 border-[#1a6bbf] text-[#1a6bbf] font-bold rounded-full hover:bg-[#1a6bbf] hover:text-white transition-colors text-[14px]">
                        Lihat semua destinasi
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- SECTION 3: DESTINASI TERPOPULER (ALL-IN-ONE 5 CARD BY REVIEW) --}}
        <div class="bg-[#f0f7ff] py-10 md:py-14 border-b border-blue-100">
            <div class="max-w-7xl mx-auto px-4 md:px-6">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-3 mb-6 md:mb-8">
                    <div>
                        <div class="inline-flex items-center gap-1.5 border border-blue-200 bg-blue-100/70 text-[#1a6bbf] px-3 py-1 rounded-full text-xs font-bold mb-2.5 uppercase tracking-wider">
                            <svg class="w-3.5 h-3.5 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            Paling Favorit
                        </div>
                        <h2 class="text-xl md:text-3xl font-bold text-gray-900 mb-1">Destinasi Terpopuler</h2>
                        <p class="text-[13px] md:text-[14px] text-gray-600">Paling banyak dikunjungi dan direkomendasikan oleh ribuan wisatawan</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-5">
                    @forelse($popularPlaces as $place)
                    <a href="{{ route('place.show', $place->slug) }}" class="group block">
                        {{-- Photo Container --}}
                        <div class="overflow-hidden rounded-2xl mb-2.5 aspect-[4/3] bg-gray-100 relative">
                            @if($place->badge_label)
                                <span class="absolute top-2.5 left-2.5 bg-gradient-to-r from-amber-500 to-amber-400 text-gray-950 text-[10px] md:text-[11px] font-black px-2.5 py-0.5 rounded-full shadow-md z-10 flex items-center gap-1">
                                    <svg class="w-3 h-3 text-gray-950 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    {{ $place->badge_label }}
                                </span>
                            @elseif($loop->first)
                                <span class="absolute top-2.5 left-2.5 bg-[#1a6bbf] text-white text-[10px] md:text-[11px] font-bold px-2.5 py-0.5 rounded-full shadow-sm z-10 flex items-center gap-1">
                                    <svg class="w-2.5 h-2.5 text-amber-300 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    Top #1 Populer
                                </span>
                            @endif

                            <img src="{{ $place->primaryImage ? Storage::url($place->primaryImage->image_path) : 'https://placehold.co/400x300/e2e8f0/64748b?text=' . urlencode($place->name) }}" 
                                 alt="{{ $place->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                            <div class="absolute inset-0 bg-black/5 group-hover:bg-black/0 transition-colors"></div>
                        </div>

                        {{-- Content Below Photo --}}
                        <h4 class="text-[14px] md:text-[15px] font-bold text-gray-900 group-hover:text-[#1a6bbf] leading-snug mb-1 truncate transition-colors">
                            {{ $place->name }}
                        </h4>

                        <div class="flex items-center gap-1.5 text-xs text-gray-500 mb-1.5">
                            <div class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-[#f9a826] fill-current flex-shrink-0" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-bold text-gray-800">{{ number_format($place->reviews_avg_rating ?? 0, 1) }}</span>
                                <span class="text-gray-400">({{ $place->reviews_count ?? 0 }})</span>
                            </div>
                            @if($place->district)
                                <span class="text-gray-300">•</span>
                                <span class="truncate max-w-[110px]">{{ $place->district }}</span>
                            @endif
                        </div>

                        @if($place->description)
                            <p class="text-[12px] text-gray-500 leading-relaxed line-clamp-2">{{ Str::limit(strip_tags($place->description), 90) }}</p>
                        @endif
                    </a>
                    @empty
                    <p class="text-gray-400 text-sm col-span-full">Belum ada data destinasi terpopuler.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- SECTION 4: EVENT MENDATANG --}}
        <div class="bg-white py-10 md:py-14 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 md:px-6">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-3 mb-5 md:mb-7">
                    <div>
                        <h2 class="text-xl md:text-3xl font-bold text-gray-900 mb-1">Event & Festival Mendatang</h2>
                        <p class="text-[13px] md:text-[14px] text-gray-500">Jangan sampai ketinggalan acara seru di Sukabumi</p>
                    </div>
                    <div class="flex gap-2 overflow-x-auto pb-1 scrollbar-hide" id="event-filters">
                        <button onclick="filterEvents('minggu-ini', this)" class="event-filter-btn flex-shrink-0 px-3 py-1.5 border-2 border-[#1a6bbf] text-[#1a6bbf] bg-white text-[12px] font-bold rounded-full hover:bg-[#1a6bbf] hover:text-white transition-colors">Minggu ini</button>
                        <button onclick="filterEvents('akhir-pekan', this)" class="event-filter-btn flex-shrink-0 px-3 py-1.5 border-2 border-gray-300 text-gray-600 bg-white text-[12px] font-bold rounded-full hover:border-[#1a6bbf] hover:text-[#1a6bbf] transition-colors">Akhir pekan</button>
                        <button onclick="filterEvents('bulan-ini', this)" class="event-filter-btn flex-shrink-0 px-3 py-1.5 border-2 border-gray-300 text-gray-600 bg-white text-[12px] font-bold rounded-full hover:border-[#1a6bbf] hover:text-[#1a6bbf] transition-colors">Bulan ini</button>
                        <button onclick="filterEvents('semua', this)" class="event-filter-btn flex-shrink-0 px-3 py-1.5 border-2 border-gray-300 text-gray-600 bg-white text-[12px] font-bold rounded-full hover:border-[#1a6bbf] hover:text-[#1a6bbf] transition-colors">Semua</button>
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
                            <div class="text-[9px] font-black text-red-500 uppercase">{{ $event->start_date->translatedFormat('M') }}</div>
                            <div class="text-base font-black text-gray-900 leading-none">{{ $event->start_date->format('d') }}</div>
                        </div>
                        <div class="absolute bottom-0 inset-x-0 p-4">
                            <h4 class="text-white font-bold text-[14px] leading-tight group-hover:underline mb-1">{{ $event->title }}</h4>
                            @if($event->location_name)
                            <div class="flex items-center text-white/70 text-[11px]">
                                <svg class="w-3 h-3 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
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
                        <h3 class="text-base font-bold text-gray-900">Belum ada event dalam waktu dekat</h3>
                        <p class="text-gray-400 text-sm mt-1">Pantau terus halaman ini ya!</p>
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
        <div class="bg-[#f0f7ff] py-10 md:py-16 relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 md:px-6 relative z-10">
                <div class="text-center max-w-2xl mx-auto mb-10">
                    <div class="inline-block border border-blue-200 bg-blue-50 text-[#1a6bbf] px-4 py-1.5 rounded-full text-xs font-bold mb-4 tracking-wider uppercase">
                        Testimonials
                    </div>
                    <h2 class="text-2xl md:text-4xl lg:text-5xl font-bold text-gray-900 tracking-tight">Apa Kata Mereka</h2>
                    <p class="text-[14px] md:text-base text-gray-500 mt-4 leading-relaxed">
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

        label.textContent = 'Memuat Destinasi...';

        fetch(`/api/places/nearby?lat=${lat}&lng=${lng}`)
            .then(res => res.json())
            .then(res => {
                if (!res.success || !res.data || res.data.length === 0) {
                    label.textContent = 'Gunakan Lokasi Saya';
                    btn.disabled = false;
                    return;
                }

                let html = '';
                res.data.forEach((place, index) => {
                    const isFirst = index === 0;
                    let badgeHtml = '';
                    if (place.badge_label) {
                        badgeHtml = `<span class="absolute top-2.5 left-2.5 bg-gradient-to-r from-amber-500 to-amber-400 text-gray-950 text-[10px] md:text-[11px] font-black px-2.5 py-0.5 rounded-full shadow-md z-10 flex items-center gap-1"><svg class="w-3 h-3 text-gray-950 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>${place.badge_label}</span>`;
                    } else if (isFirst) {
                        badgeHtml = `<span class="absolute top-2.5 left-2.5 bg-emerald-500 text-white text-[10px] md:text-[11px] font-extrabold px-2.5 py-0.5 rounded-full shadow-md z-10 flex items-center gap-1"><svg class="w-2.5 h-2.5 text-white fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>Paling Dekat</span>`;
                    }
                    const badgeJarak = place.distance_formatted ? `<span class="absolute top-2.5 right-2.5 bg-black/65 backdrop-blur-md text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full flex items-center gap-1 shadow-sm border border-white/20 z-10"><svg class="w-2.5 h-2.5 text-[#f9a826]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>${place.distance_formatted}</span>` : '';
                    const districtHtml = place.district ? `<span class="text-gray-300">•</span><span class="truncate max-w-[110px]">${place.district}</span>` : '';
                    const descHtml = place.description ? `<p class="text-[12px] text-gray-500 leading-relaxed line-clamp-2">${place.description}</p>` : '';

                    html += `
                    <a href="${place.url}" class="group block">
                        <div class="overflow-hidden rounded-2xl mb-2.5 aspect-[4/3] bg-gray-100 relative">
                            ${badgeHtml}
                            ${badgeJarak}
                            <img src="${place.cover_image}" alt="${place.name}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                            <div class="absolute inset-0 bg-black/5 group-hover:bg-black/0 transition-colors"></div>
                        </div>
                        <h4 class="text-[14px] md:text-[15px] font-bold text-gray-900 group-hover:text-[#1a6bbf] leading-snug mb-1 truncate transition-colors">${place.name}</h4>
                        <div class="flex items-center gap-1.5 text-xs text-gray-500 mb-1.5">
                            <div class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-[#f9a826] fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-bold text-gray-800">${Number(place.rating).toFixed(1)}</span>
                                <span class="text-gray-400">(${place.reviews_count})</span>
                            </div>
                            ${districtHtml}
                        </div>
                        ${descHtml}
                    </a>`;
                });

                nearbyContainer.innerHTML = html;

                // Sembunyikan content best choice, tampilkan nearby
                if (bestChoiceContainer) bestChoiceContainer.classList.add('hidden');
                nearbyContainer.classList.remove('hidden');

                // Perbarui judul dan teks tombol
                title.textContent = 'Destinasi Terdekat dari Anda';
                subtitle.textContent = 'Menampilkan rekomendasi tempat wisata terdekat dari posisi Anda saat ini';
                btn.classList.remove('bg-blue-50/80', 'text-[#1a6bbf]', 'border-blue-200');
                btn.classList.add('bg-emerald-50', 'text-emerald-700', 'border-emerald-300');
                if (pinIcon) pinIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>`;
                label.textContent = 'Lokasi Aktif (Perbarui)';
                btn.disabled = false;
            })
            .catch(err => {
                console.error('Error loading nearby places:', err);
                label.textContent = 'Gunakan Lokasi Saya';
                btn.disabled = false;
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
        const firstBtn = document.querySelector('.event-filter-btn');
        if (firstBtn) filterEvents('minggu-ini', firstBtn);
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
