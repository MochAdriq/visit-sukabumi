@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white font-sans text-gray-900">
    @include('components.navbar')

    <main>

        {{-- SECTION 1: HERO --}}
        <div class="relative bg-gray-900" style="height: 60vh; min-height: 420px;">
            <div class="absolute inset-0">
                <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=1920&h=800&fit=crop" alt="Pemandangan Sukabumi" />
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
                    @foreach($exploreCategories as $cat)
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

        {{-- SECTION 2: DESTINASI TERPOPULER --}}
        <div class="bg-white py-10 md:py-14 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 md:px-6">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-3 mb-5 md:mb-7">
                    <div>
                        <h2 class="text-xl md:text-3xl font-bold text-gray-900 mb-1">Destinasi Terpopuler</h2>
                        <p class="text-[13px] md:text-[14px] text-gray-500">Pilihan terbaik berdasarkan review ribuan wisatawan</p>
                    </div>
                    <div class="flex gap-2 overflow-x-auto pb-1 scrollbar-hide" id="ticket-tabs">
                        <button onclick="switchTab('alam')" id="tab-alam" class="vs-tab-pill active flex-shrink-0">Wisata Alam</button>
                        <button onclick="switchTab('pantai')" id="tab-pantai" class="vs-tab-pill flex-shrink-0">Wisata Pantai</button>
                        <button onclick="switchTab('kuliner')" id="tab-kuliner" class="vs-tab-pill flex-shrink-0">Kuliner</button>
                    </div>
                </div>

                @php
                $placeCardTemplate = function($place, $loop) {
                    return $place;
                };
                @endphp

                <div id="content-alam" class="vs-tab-content grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    @forelse($popularAlam as $place)
                    <a href="{{ route('place.show', $place->slug) }}" class="group block">
                        <div class="overflow-hidden rounded-xl mb-2 aspect-[3/4] relative bg-gray-100">
                            @if($loop->first)<span class="absolute top-2 left-0 bg-[#f9a826] text-gray-900 text-[10px] font-bold px-2 py-0.5 z-10 rounded-r shadow-sm">Pilihan Utama</span>@endif
                            <img src="{{ $place->primaryImage ? Storage::url($place->primaryImage->image_path) : 'https://placehold.co/320x427/e5e7eb/9ca3af?text=' . urlencode($place->name) }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                        </div>
                        <h4 class="text-[13px] font-bold text-gray-900 group-hover:text-[#1a6bbf] leading-tight mb-1">{{ $place->name }}</h4>
                        <div class="flex items-center gap-1 mb-1">
                            <svg class="w-3 h-3 text-[#f9a826] fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="text-[11px] font-bold text-gray-700">{{ number_format($place->reviews_avg_rating ?? 0, 1) }}</span>
                            <span class="text-[10px] text-gray-400">({{ $place->reviews_count ?? 0 }})</span>
                        </div>
                        @if($place->has_general_price)
                        <span class="text-[11px] font-bold text-[#1a6bbf]">Mulai Rp {{ number_format($place->price ?? 0, 0, ',', '.') }}</span>
                        @endif
                    </a>
                    @empty
                    <p class="text-gray-400 text-sm col-span-full">Belum ada data.</p>
                    @endforelse
                </div>

                <div id="content-pantai" class="vs-tab-content hidden grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    @forelse($popularPantai as $place)
                    <a href="{{ route('place.show', $place->slug) }}" class="group block">
                        <div class="overflow-hidden rounded-xl mb-2 aspect-[3/4] relative bg-gray-100">
                            @if($loop->first)<span class="absolute top-2 left-0 bg-[#f9a826] text-gray-900 text-[10px] font-bold px-2 py-0.5 z-10 rounded-r shadow-sm">Pilihan Utama</span>@endif
                            <img src="{{ $place->primaryImage ? Storage::url($place->primaryImage->image_path) : 'https://placehold.co/320x427/e5e7eb/9ca3af?text=' . urlencode($place->name) }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                        </div>
                        <h4 class="text-[13px] font-bold text-gray-900 group-hover:text-[#1a6bbf] leading-tight mb-1">{{ $place->name }}</h4>
                        <div class="flex items-center gap-1 mb-1">
                            <svg class="w-3 h-3 text-[#f9a826] fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="text-[11px] font-bold text-gray-700">{{ number_format($place->reviews_avg_rating ?? 0, 1) }}</span>
                            <span class="text-[10px] text-gray-400">({{ $place->reviews_count ?? 0 }})</span>
                        </div>
                        @if($place->has_general_price)
                        <span class="text-[11px] font-bold text-[#1a6bbf]">Mulai Rp {{ number_format($place->price ?? 0, 0, ',', '.') }}</span>
                        @endif
                    </a>
                    @empty
                    <p class="text-gray-400 text-sm col-span-full">Belum ada data.</p>
                    @endforelse
                </div>

                <div id="content-kuliner" class="vs-tab-content hidden grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    @forelse($popularKuliner as $place)
                    <a href="{{ route('place.show', $place->slug) }}" class="group block">
                        <div class="overflow-hidden rounded-xl mb-2 aspect-[3/4] relative bg-gray-100">
                            @if($loop->first)<span class="absolute top-2 left-0 bg-[#f9a826] text-gray-900 text-[10px] font-bold px-2 py-0.5 z-10 rounded-r shadow-sm">Pilihan Utama</span>@endif
                            <img src="{{ $place->primaryImage ? Storage::url($place->primaryImage->image_path) : 'https://placehold.co/320x427/e5e7eb/9ca3af?text=' . urlencode($place->name) }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                        </div>
                        <h4 class="text-[13px] font-bold text-gray-900 group-hover:text-[#1a6bbf] leading-tight mb-1">{{ $place->name }}</h4>
                        <div class="flex items-center gap-1 mb-1">
                            <svg class="w-3 h-3 text-[#f9a826] fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="text-[11px] font-bold text-gray-700">{{ number_format($place->reviews_avg_rating ?? 0, 1) }}</span>
                            <span class="text-[10px] text-gray-400">({{ $place->reviews_count ?? 0 }})</span>
                        </div>
                        @if($place->has_general_price)
                        <span class="text-[11px] font-bold text-[#1a6bbf]">Mulai Rp {{ number_format($place->price ?? 0, 0, ',', '.') }}</span>
                        @endif
                    </a>
                    @empty
                    <p class="text-gray-400 text-sm col-span-full">Belum ada data.</p>
                    @endforelse
                </div>

                <div class="mt-8 text-center">
                    <a href="{{ route('place.index') }}" class="inline-flex items-center gap-2 px-8 py-3 border-2 border-[#1a6bbf] text-[#1a6bbf] font-bold rounded-full hover:bg-[#1a6bbf] hover:text-white transition-colors text-[14px]">
                        Lihat semua destinasi
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- ADVERTISEMENT BANNER --}}
        @php
            $ad = \App\Models\Advertisement::where('is_active', true)->inRandomOrder()->first();
        @endphp
        
        @if($ad)
        <div class="bg-white py-4">
            <div class="max-w-7xl mx-auto px-4 md:px-6">
                <div class="rounded-2xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-md transition">
                    <a href="{{ $ad->url ?? '#' }}" target="{{ $ad->url ? '_blank' : '_self' }}" class="block w-full">
                        <img src="{{ Storage::url($ad->image_path) }}" alt="{{ $ad->title }}" class="w-full h-auto max-h-[300px] md:max-h-[250px] object-cover object-center">
                    </a>
                </div>
            </div>
        </div>
        @endif

        {{-- SECTION 3: JELAJAHI KATEGORI --}}
        <div class="bg-gray-50 py-10 md:py-14 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 md:px-6">
                <h2 class="text-xl md:text-3xl font-bold text-gray-900 mb-1">Jelajahi Sukabumi</h2>
                <p class="text-[13px] md:text-[14px] text-gray-500 mb-6 md:mb-8">Dari petualangan ekstrem hingga ketenangan alam — temukan pengalaman terbaik-mu</p>
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-5">
                    @foreach($exploreCategories as $cat)
                    <a href="{{ url('/place?category=' . $cat->slug) }}" class="group block">
                        <div class="overflow-hidden rounded-2xl mb-3 aspect-[4/3] bg-gray-200 flex items-center justify-center relative">
                            @if($cat->cover_image)
                                <img src="{{ Storage::url($cat->cover_image) }}" alt="{{ $cat->custom_title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                                <div class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition-colors rounded-2xl"></div>
                            @else
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            @endif
                        </div>
                        <h3 class="text-[15px] font-bold text-gray-900 group-hover:text-[#1a6bbf] transition-colors mb-1">{{ $cat->custom_title }}</h3>
                        <p class="text-[12px] text-gray-500 leading-relaxed line-clamp-2">{{ $cat->custom_subtitle }}</p>
                    </a>
                    @endforeach
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
    function switchTab(tab) {
        document.querySelectorAll('.vs-tab-content').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.vs-tab-pill').forEach(el => el.classList.remove('active'));
        document.getElementById('content-' + tab).classList.remove('hidden');
        document.getElementById('tab-' + tab).classList.add('active');
    }

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
