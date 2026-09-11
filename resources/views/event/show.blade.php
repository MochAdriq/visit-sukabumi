@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white font-sans text-gray-900 pb-20">
    @include('components.navbar')

    @if(!$event->is_active)
        <div class="bg-amber-500 text-white px-4 py-2.5 shadow-md">
            <div class="max-w-[1200px] mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 text-xs sm:text-sm font-medium">
                <div class="flex items-center gap-2.5">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span><strong>Mode Pratinjau:</strong> Acara ini berstatus <span class="uppercase font-bold tracking-wider underline">NON-AKTIF (DRAFT)</span> dan tidak dapat diakses oleh publik.</span>
                </div>
                <a href="{{ url('/admin/events/' . $event->id . '/edit') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1 bg-white text-amber-800 font-bold rounded-full hover:bg-amber-50 transition text-xs shadow-sm whitespace-nowrap">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Acara di Admin
                </a>
            </div>
        </div>
    @endif

    <main class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 pt-4">

        {{-- ══ BREADCRUMB ══ --}}
        <nav class="flex text-xs md:text-sm text-gray-500 gap-2 items-center flex-wrap mb-3">
            <a href="{{ url('/') }}" class="hover:underline hover:text-black">Visit Sukabumi</a>
            <span>›</span>
            <a href="{{ route('event.index') }}" class="hover:underline hover:text-black">Events & Trips</a>
            <span>›</span>
            <span class="text-gray-900">{{ $event->title }}</span>
        </nav>

        {{-- ══ TITLE & RATING ══ --}}
        @php
            $mainImg = $event->image_path ? Storage::url($event->image_path) : asset('assets/images/10.jpg');
            $smallImg1 = $mainImg;
            
            // Real Review Data from Database
            $score = $event->avgRating();
            $reviewCount = $event->reviews()->count();
            
            $highReviews = $event->reviews()->where('rating', '>=', 4)->count();
            $recommendPercent = $reviewCount > 0 ? round(($highReviews / $reviewCount) * 100) : 0;
            
            // Get random featured review from THIS event
            $featuredReview = $event->reviews()->with('user')->where('rating', '>=', 4)->inRandomOrder()->first();
        @endphp
        
        <h1 class="text-3xl md:text-[32px] font-black text-gray-900 leading-tight mb-2">
            {{ $event->title }}
        </h1>
        <div class="flex items-center gap-2 mb-6 flex-wrap">
            <div class="flex items-center gap-1 text-[#00aa6c]">
                <span class="font-bold text-sm">{{ $score }}</span>
                <div class="flex">
                    @for($i=1; $i<=5; $i++)
                        <svg class="w-4 h-4 fill-current {{ $i <= round($score) ? 'text-[#00aa6c]' : 'text-gray-300' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
            </div>
            <a href="#reviews" class="text-sm font-bold text-gray-900 hover:underline border-b border-dotted border-gray-900">({{ $reviewCount }} ulasan)</a>
            <span class="text-gray-300 mx-1">•</span>
            <div class="flex items-center gap-1.5 text-sm font-medium text-gray-700">
                <svg class="w-4 h-4 text-[#e00b81]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                Direkomendasikan oleh {{ $recommendPercent }}% wisatawan
            </div>
        </div>

        {{-- ══ PHOTO GALLERY (TripAdvisor Style) ══ --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-2 lg:h-[450px] mb-8 rounded-2xl overflow-hidden">
            {{-- Left: Main Big Image --}}
            <div class="lg:col-span-2 h-72 lg:h-full relative group cursor-pointer">
                <a href="{{ $mainImg }}" class="glightbox" data-gallery="event-gallery">
                    <img src="{{ $mainImg }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:opacity-95 transition">
                </a>
                <div class="absolute bottom-4 left-4 bg-[#f9a826] text-black font-black px-3 py-2 rounded flex flex-col items-center shadow-lg transform -rotate-3">
                    <svg class="w-6 h-6 mb-1" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/><path fill="white" d="M8 10h8v4H8z"/></svg>
                    <span class="text-[10px] leading-none">PILIHAN</span>
                    <span class="text-xs leading-none">WISATAWAN</span>
                </div>
            </div>

            {{-- Right: Stacked layout --}}
            <div class="hidden lg:flex flex-col gap-2 h-full">
                {{-- Top Right: Superb Review Card --}}
                <div class="bg-[#faf1ed] h-1/2 p-6 flex flex-col justify-center rounded-tr-2xl relative">
                    @if($featuredReview)
                        <div class="flex items-center gap-1 mb-2">
                            <span class="font-bold text-lg">{{ $featuredReview->rating >= 5 ? 'Luar Biasa' : 'Sangat Bagus' }}</span>
                            <div class="flex">
                                @for($i=1; $i<=5; $i++)
                                    <svg class="w-3.5 h-3.5 fill-current {{ $i <= $featuredReview->rating ? 'text-[#00aa6c]' : 'text-gray-300' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                        </div>
                        <p class="font-bold text-gray-900 leading-tight mb-2 line-clamp-3">"{{ $featuredReview->comment }}"</p>
                        <p class="text-xs text-gray-500 font-medium">{{ $featuredReview->user ? $featuredReview->user->name : 'Anonim' }} • Ulasan pilihan</p>
                    @else
                        <div class="flex items-center justify-center h-full">
                            <p class="text-gray-500 text-sm font-medium">Belum ada ulasan unggulan.</p>
                        </div>
                    @endif
                </div>
                {{-- Bottom Right: Image --}}
                <div class="h-1/2 relative group cursor-pointer">
                    <a href="{{ $smallImg1 }}" class="glightbox" data-gallery="event-gallery">
                        <img src="{{ $smallImg1 }}" alt="Gallery view" class="w-full h-full object-cover group-hover:opacity-95 transition rounded-br-2xl">
                    </a>
                    <div class="absolute bottom-3 right-3 bg-black/70 text-white font-bold text-xs px-3 py-1.5 rounded-lg flex items-center gap-1.5 backdrop-blur-sm pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2" stroke-width="2"/><circle cx="8.5" cy="8.5" r="1.5" stroke-width="2"/><path d="M21 15l-5-5L5 21" stroke-width="2"/></svg>
                        Foto
                    </div>
                </div>
            </div>
        </div>

        {{-- ══ IN-PAGE TABS ══ --}}
        <div class="border-b border-gray-200 mb-8 sticky top-[64px] bg-white z-30 shadow-sm transition-all duration-300">
            <nav id="page-nav" class="flex gap-8 overflow-x-auto no-scrollbar font-bold text-sm text-gray-500">
                <a href="#overview" class="nav-tab py-4 border-b-2 border-black text-black whitespace-nowrap transition-colors">Ringkasan</a>
                <a href="#details" class="nav-tab py-4 border-b-2 border-transparent hover:border-black hover:text-black whitespace-nowrap transition-colors">Detail</a>
                <a href="#itinerary" class="nav-tab py-4 border-b-2 border-transparent hover:border-black hover:text-black whitespace-nowrap transition-colors">Rencana Perjalanan</a>
                <a href="#operator" class="nav-tab py-4 border-b-2 border-transparent hover:border-black hover:text-black whitespace-nowrap transition-colors">Penyelenggara</a>
                <a href="#reviews" class="nav-tab py-4 border-b-2 border-transparent hover:border-black hover:text-black whitespace-nowrap transition-colors">Ulasan</a>
            </nav>
        </div>

        {{-- ══ CONTENT GRID ══ --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            {{-- ── LEFT: Main Content ── --}}
            <div class="lg:col-span-2 space-y-10">

                {{-- Badges / Status --}}
                <div class="flex items-center gap-3 bg-[#fff1e0] p-4 rounded-xl border border-[#ffd5a0]">
                    <div class="bg-[#f9a826] rounded-full p-2 text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 text-sm">Pilihan Wisatawan Terbaik 2026</div>
                        <div class="text-xs text-gray-700">Peringkat 1% teratas destinasi terbaik dunia</div>
                    </div>
                </div>

                {{-- Why travelers love this --}}
                @php
                    $reviewsToDisplay = $topReviews ?? collect();
                    if ($reviewsToDisplay->isEmpty() && isset($event)) {
                        $reviewsToDisplay = $event->reviews()->where('rating', 5)->with('user')->latest()->take(6)->get();
                        if ($reviewsToDisplay->isEmpty()) {
                            $reviewsToDisplay = \App\Models\Review::where('rating', 5)->with('user')->latest()->take(6)->get();
                        }
                    }
                @endphp
                @if($reviewsToDisplay->count() > 0)
                <div id="overview" class="scroll-mt-32 section-block">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex justify-between items-center">
                        Alasan wisatawan menyukainya
                        <div class="flex gap-1 text-[#00aa6c]">
                            @for($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                    </h2>
                    
                    <div class="flex gap-4 overflow-x-auto pb-4 snap-x">
                        @foreach($reviewsToDisplay as $review)
                        <div class="min-w-[280px] sm:min-w-[320px] max-w-[360px] bg-white border border-gray-200 rounded-2xl p-5 shadow-sm snap-start flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="flex text-[#00aa6c]">
                                        @for($i = 0; $i < ($review->rating ?? 5); $i++)
                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                    </div>
                                    <span class="text-xs font-bold text-gray-900">{{ $review->user->name ?? 'Wisatawan' }} &middot; {{ $review->created_at ? $review->created_at->format('M Y') : 'Baru saja' }}</span>
                                </div>
                                <p class="text-sm text-gray-700 leading-relaxed">"{{ $review->content }}"</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Overview Text --}}
                <div class="prose prose-sm md:prose-base max-w-none text-gray-800 leading-relaxed">
                    @if($event->description)
                        {!! $event->description !!}
                    @else
                        <p>Tinggalkan hiruk pikuk kota dan nikmati keindahan alam yang memukau pada petualangan luar biasa ini. Semua keperluan logistik akan diurus oleh pemandu berpengalaman, Anda cukup datang dan menikmati hari yang sempurna.</p>
                    @endif
                </div>

                {{-- Quick Info Icons --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-8">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 mt-0.5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        <div>
                            <div class="text-sm font-medium text-gray-900">Usia: Semua Umur (0-100 tahun)</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 mt-0.5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <div>
                            <div class="text-sm font-medium text-gray-900">Durasi: 
                                @if($event->end_date)
                                    {{ $event->start_date->diffInHours($event->end_date) }} jam
                                @else
                                    Setengah hari
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 mt-0.5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <div>
                            <div class="text-sm font-medium text-gray-900">Waktu mulai: {{ $event->start_date->format('H:i') }} WIB</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 mt-0.5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                        <div>
                            <div class="text-sm font-medium text-gray-900">Tiket elektronik di HP berlaku</div>
                        </div>
                    </div>
                    @if($event->location_name)
                    <div class="flex items-start gap-3 sm:col-span-2">
                        <svg class="w-5 h-5 mt-0.5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <div>
                            <div class="text-sm font-medium text-gray-900">Titik kumpul: {{ $event->location_name }}</div>
                        </div>
                    </div>
                    @endif
                </div>

                <hr class="border-gray-200">

                {{-- Details Accordions --}}
                @if($event->whats_included || $event->what_to_expect || $event->meeting_and_pickup || $event->cancellation_policy)
                <div id="details" class="space-y-0 scroll-mt-32 section-block">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Detail Acara</h2>
                    
                    @if($event->whats_included)
                    <div class="border-t border-gray-200 py-5 group detail-accordion">
                        <div class="cursor-pointer flex justify-between items-center accordion-header">
                            <span class="font-bold text-gray-900 text-[15px]">Fasilitas yang termasuk</span>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-black transform transition-transform duration-300 accordion-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                        <div class="accordion-content hidden mt-4 text-gray-700 prose prose-sm max-w-none">
                            {!! $event->whats_included !!}
                        </div>
                    </div>
                    @endif
                    
                    @if($event->what_to_expect)
                    <div class="border-t border-gray-200 py-5 group detail-accordion">
                        <div class="cursor-pointer flex justify-between items-center accordion-header">
                            <span class="font-bold text-gray-900 text-[15px]">Yang akan didapatkan</span>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-black transform transition-transform duration-300 accordion-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                        <div class="accordion-content hidden mt-4 text-gray-700 prose prose-sm max-w-none">
                            {!! $event->what_to_expect !!}
                        </div>
                    </div>
                    @endif

                    @if($event->meeting_and_pickup)
                    <div class="border-t border-gray-200 py-5 group detail-accordion">
                        <div class="cursor-pointer flex justify-between items-center accordion-header">
                            <span class="font-bold text-gray-900 text-[15px]">Titik kumpul & penjemputan</span>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-black transform transition-transform duration-300 accordion-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                        <div class="accordion-content hidden mt-4 text-gray-700 prose prose-sm max-w-none">
                            {!! $event->meeting_and_pickup !!}
                        </div>
                    </div>
                    @endif

                    @if($event->cancellation_policy)
                    <div class="border-t border-b border-gray-200 py-5 group detail-accordion">
                        <div class="cursor-pointer flex justify-between items-center accordion-header">
                            <span class="font-bold text-gray-900 text-[15px]">Kebijakan pembatalan</span>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-black transform transition-transform duration-300 accordion-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                        <div class="accordion-content hidden mt-4 text-gray-700 prose prose-sm max-w-none">
                            {!! $event->cancellation_policy !!}
                        </div>
                    </div>
                    @endif
                </div>
                @else
                <div id="details" class="scroll-mt-32 section-block">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Detail Acara</h2>
                    <div class="p-6 border border-gray-200 rounded-2xl text-center">
                        <p class="text-gray-500">Detail lengkap akan segera diperbarui. Silakan cek kembali nanti!</p>
                    </div>
                </div>
                @endif

                {{-- Dynamic Itinerary & Interactive Map --}}
                <div id="itinerary" class="scroll-mt-32 section-block">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Rencana Perjalanan</h2>
                    
                    @if($event->itineraries && $event->itineraries->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- Left: Timeline --}}
                            <div class="space-y-8 relative border-l-2 border-dashed border-gray-300 ml-4 pl-8 py-2">
                                @foreach($event->itineraries as $index => $itin)
                                    <div x-data="{ open: false }" @click="open = !open" class="relative itinerary-item cursor-pointer group" data-lat="{{ $itin->latitude }}" data-lng="{{ $itin->longitude }}">
                                        {{-- Marker Icon --}}
                                        <div class="absolute -left-[49px] top-0 w-8 h-8 bg-white rounded-full flex items-center justify-center font-bold text-sm border-[3px] z-10 transition-colors {{ $index === 0 ? 'border-[#f9a826] text-black bg-[#f9a826]' : ($index === $event->itineraries->count() - 1 ? 'border-[#f9a826] text-black bg-[#f9a826]' : 'border-[#00aa6c] text-[#00aa6c]') }} group-hover:scale-110">
                                            {{ $index === 0 ? 'Mulai' : ($index === $event->itineraries->count() - 1 ? 'Selesai' : $index) }}
                                        </div>
                                        
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <h3 class="font-bold text-gray-900 group-hover:underline">{{ $itin->title }}</h3>
                                                @if($itin->duration_text)
                                                    <p class="text-sm text-gray-500 mt-1">{{ $itin->duration_text }}</p>
                                                @endif
                                            </div>
                                            <svg :class="{'rotate-180': open}" class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                        
                                        <p x-show="!open" class="text-sm text-[#1a6bbf] font-medium mt-1">Lihat detail & foto</p>
                                        
                                        {{-- Expandable Content --}}
                                        <div x-show="open" style="display: none;" class="itinerary-content mt-3">
                                            @if($itin->image_path)
                                                <a href="{{ Storage::url($itin->image_path) }}" class="glightbox" data-gallery="event-gallery">
                                                    <img src="{{ Storage::url($itin->image_path) }}" alt="{{ $itin->title }}" class="w-full h-48 object-cover rounded-xl mb-3 shadow-sm">
                                                </a>
                                            @endif
                                            @if($itin->description)
                                                <p class="text-sm text-gray-700 leading-relaxed">{{ $itin->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Right: Map --}}
                            <div>
                                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
                                <div id="itinerary-map" class="w-full h-[400px] sticky top-32 rounded-2xl border border-gray-200 z-10 shadow-inner"></div>
                            </div>
                        </div>
                    @else
                        {{-- Placeholder if no itineraries are found --}}
                        <div class="p-6 border border-gray-200 rounded-2xl text-center">
                            <p class="text-gray-500">Detail rencana perjalanan akan segera diperbarui. Silakan cek kembali nanti!</p>
                        </div>
                    @endif
                </div>

                {{-- Operator Dummy --}}
                <div id="operator" class="scroll-mt-32 section-block">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Penyelenggara</h2>
                    <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center border-2 border-gray-200 font-black text-xl text-gray-400">VS</div>
                        <div>
                            <div class="font-bold text-gray-900">Visit Sukabumi Official</div>
                            <div class="text-sm text-gray-500">Pemandu Wisata Ahli Lokal</div>
                        </div>
                    </div>
                </div>

                {{-- ══ ULASAN PENGUNJUNG ══ --}}
                @include('components.detail-review-section', ['model' => $event, 'type' => 'event'])

            </div>

            {{-- ── RIGHT: Sticky Booking Card ── --}}
            <div class="lg:col-span-1">
                <div class="sticky top-[140px] space-y-6">
                    
                    {{-- Primary Booking Card --}}
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-[0_4px_24px_rgba(0,0,0,0.06)] p-6">
                        <div class="mb-5">
                            <div class="flex items-baseline gap-1">
                                <span class="text-xl md:text-2xl font-black text-gray-900">Rp 150.000</span>
                                <span class="text-sm text-gray-500">per orang</span>
                            </div>
                            <div class="text-xs font-bold text-green-600 mt-1 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                Jaminan Harga Terbaik
                            </div>
                        </div>

                        {{-- Date & Guests Selection --}}
                        <div class="flex flex-col gap-2 mb-4">
                            <button class="w-full text-left px-4 py-3 border-2 border-gray-900 rounded-xl font-bold flex justify-between items-center">
                                <span>{{ $event->start_date->translatedFormat('D, d M') }}</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </button>
                            <button class="w-full text-left px-4 py-3 border-2 border-gray-300 rounded-xl flex justify-between items-center text-gray-600">
                                <span>2 Orang Dewasa</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            </button>
                        </div>

                        {{-- WhatsApp CTA --}}
                        @php
                            $waText = "Halo, saya mendapatkan informasi paket tour ini (*{$event->title}*) dari website panduan wisata *Visit Sukabumi* (visitsukabumi.com).\n\nBoleh minta informasi lebih lanjut terkait pemesanan paket ini?";
                            $waPhone = "6282298285558";
                        @endphp
                        <a href="https://wa.me/{{ $waPhone }}?text={{ urlencode($waText) }}" target="_blank"
                           class="w-full block text-center bg-[#00aa6c] hover:bg-[#008a57] text-white font-bold py-3.5 px-6 rounded-full transition text-[15px] mb-4">
                            Cek Ketersediaan
                        </a>

                        {{-- Value Props --}}
                        <div class="space-y-4 pt-2">
                            <div class="flex gap-3">
                                <div class="mt-0.5 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <div class="text-xs">
                                    <span class="font-bold text-gray-900">Pembatalan Gratis</span>
                                    <span class="text-gray-500 block">Pengembalian dana penuh jika dibatalkan hingga 24 jam sebelumnya.</span>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div class="mt-0.5 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                </div>
                                <div class="text-xs">
                                    <span class="font-bold text-gray-900">Pesan Sekarang, Bayar Nanti</span>
                                    <span class="text-gray-500 block">Amankan tempat Anda dengan tetap fleksibel.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Promo / Question Block --}}
                    <div class="bg-[#f2f2f2] rounded-2xl p-5 border border-gray-200">
                        <div class="font-bold text-sm text-gray-900 mb-2">Ada pertanyaan seputar pemesanan?</div>
                        <div class="flex gap-4">
                            <a href="https://wa.me/{{ $waPhone }}?text={{ urlencode($waText) }}" target="_blank" class="flex items-center gap-1.5 text-xs font-medium text-gray-700 hover:text-black">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                {{ $waPhone }}
                            </a>
                            <a href="https://wa.me/{{ $waPhone }}?text={{ urlencode($waText) }}" target="_blank" class="flex items-center gap-1.5 text-xs font-medium text-gray-700 hover:text-black border-b border-black pb-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                                Chat Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <x-footer />
</div>

{{-- CSS for smooth scrolling --}}
<style>
    html { scroll-behavior: smooth; }
</style>

{{-- JS for IntersectionObserver (Active Tab Highlighting) --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('.section-block');
    const navLinks = document.querySelectorAll('.nav-tab');

    const observerOptions = {
        root: null,
        rootMargin: '-100px 0px -60% 0px',
        threshold: 0
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Remove active class from all
                navLinks.forEach(link => {
                    link.classList.remove('border-black', 'text-black');
                    link.classList.add('border-transparent', 'text-gray-500');
                });
                // Add active class to corresponding nav tab
                const id = entry.target.getAttribute('id');
                const activeLink = document.querySelector(`.nav-tab[href="#${id}"]`);
                if(activeLink) {
                    activeLink.classList.remove('border-transparent', 'text-gray-500');
                    activeLink.classList.add('border-black', 'text-black');
                }
            }
        });
    }, observerOptions);

    sections.forEach(sec => {
        observer.observe(sec);
    });

    // Accordion Logic
    document.querySelectorAll('.detail-accordion .accordion-header').forEach(header => {
        header.addEventListener('click', () => {
            const content = header.nextElementSibling;
            const icon = header.querySelector('.accordion-icon');
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                content.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        });
    });
});
</script>

{{-- Leaflet Map Initialization --}}
@if($event->itineraries && $event->itineraries->count() > 0)
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Collect all valid markers from the DOM
    const items = document.querySelectorAll('.itinerary-item');
    let markersData = [];
    
    items.forEach((item, index) => {
        let lat = parseFloat(item.getAttribute('data-lat'));
        let lng = parseFloat(item.getAttribute('data-lng'));
        if(!isNaN(lat) && !isNaN(lng)) {
            markersData.push({
                lat: lat,
                lng: lng,
                title: item.querySelector('h3').innerText,
                element: item,
                index: index
            });
        }
    });

    if(markersData.length > 0) {
        // Initialize Map
        const map = L.map('itinerary-map', {
            zoomControl: false // Hide default zoom to match mapbox clean look
        }).setView([markersData[0].lat, markersData[0].lng], 13);
        
        // Add zoom control at bottom right
        L.control.zoom({ position: 'bottomright' }).addTo(map);

        // TileLayer: CartoDB Positron gives a clean Mapbox-like aesthetic
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        let bounds = L.latLngBounds();
        let mapMarkers = [];

        // Create Custom Icon Style
        const createIcon = (index, isStart, isEnd) => {
            let bgColor = '#00aa6c'; // Default green
            let txtColor = 'white';
            let text = index;

            if(isStart) {
                bgColor = '#f9a826';
                text = 'Start';
                txtColor = 'black';
            } else if(isEnd) {
                bgColor = '#f9a826';
                text = 'End';
                txtColor = 'black';
            }

            return L.divIcon({
                className: 'custom-leaflet-icon',
                html: `<div style="background-color: ${bgColor}; color: ${txtColor}; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px; border: 2px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);">${text}</div>`,
                iconSize: [30, 30],
                iconAnchor: [15, 15]
            });
        };

        // Add Markers to Map
        markersData.forEach((data, i) => {
            const isStart = i === 0;
            const isEnd = i === markersData.length - 1;
            
            const marker = L.marker([data.lat, data.lng], {
                icon: createIcon(i, isStart, isEnd)
            }).addTo(map);
            
            marker.bindPopup(`<b>${data.title}</b>`);
            bounds.extend([data.lat, data.lng]);
            mapMarkers.push(marker);

            // Add Click interaction to the DOM item
            data.element.addEventListener('click', () => {
                map.flyTo([data.lat, data.lng], 15, {
                    animate: true,
                    duration: 1.5
                });
                marker.openPopup();
            });
        });

        // Fit Map to show all markers
        map.fitBounds(bounds, { padding: [50, 50] });
    } else {
        document.getElementById('itinerary-map').innerHTML = '<div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-500 rounded-2xl">Map data unavailable</div>';
    }
});
</script>
@endif
@endsection
