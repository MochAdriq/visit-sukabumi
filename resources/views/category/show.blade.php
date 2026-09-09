@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white font-sans text-gray-900 pb-16">
    @include('components.navbar')

    @php
    $heroImages = [
        'hotel-resort' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=1920&h=1080&fit=crop',
        'kuliner' => 'https://images.unsplash.com/photo-1537047902294-62a40c20a6ae?q=80&w=1920&h=1080&fit=crop',
        'wisata-pantai' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=1920&h=1080&fit=crop',
        'wisata-alam' => 'https://images.unsplash.com/photo-1542662565-7e4fd1e56993?q=80&w=1920&h=1080&fit=crop',
        'wisata-budaya' => 'https://images.unsplash.com/photo-1518998053401-878c73fd5043?q=80&w=1920&h=1080&fit=crop',
        'aktivitas-seru' => 'https://images.unsplash.com/photo-1533587851505-d119e13bf0eb?q=80&w=1920&h=1080&fit=crop',
    ];
    $heroImg = $heroImages[$category->slug] ?? 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=1920&h=1080&fit=crop';

    $heroTitles = [
        'hotel-resort' => 'Find hotels travelers love',
        'kuliner' => 'Find your perfect restaurant',
        'wisata-pantai' => 'Discover stunning beaches',
        'wisata-alam' => 'Book traveler-backed things to do',
        'wisata-budaya' => 'Explore culture & history',
        'aktivitas-seru' => 'Book traveler-backed things to do',
    ];
    $heroTitle = $heroTitles[$category->slug] ?? 'Explore ' . $category->name;
    @endphp

    {{-- HERO BANNER --}}
    <div class="w-full h-[350px] md:h-[550px] relative md:mt-4 max-w-[1400px] mx-auto md:px-4 sm:px-6 lg:px-8">
        <div class="w-full h-full md:rounded-[2rem] overflow-hidden relative shadow-lg group">
            <img src="{{ $heroImg }}" alt="{{ $category->name }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-[10s]">
            <div class="absolute inset-0 bg-black/40"></div>
            
            <div class="absolute inset-0 flex flex-col items-center justify-center px-4 md:px-10 text-center">
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-black text-white mb-6 md:mb-8 tracking-tight drop-shadow-lg leading-tight max-w-3xl">
                    {{ $heroTitle }}
                </h1>
                
                {{-- SEARCH BAR --}}
                <form action="{{ route('place.index') }}" method="GET" class="w-full max-w-2xl bg-white rounded-full p-2 flex items-center shadow-2xl relative z-10">
                    <input type="hidden" name="category" value="{{ $category->slug }}">
                    <div class="pl-3 md:pl-4 text-gray-400">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input type="text" name="q" placeholder="Cari destinasi..." class="w-full bg-transparent border-none focus:ring-0 text-gray-900 text-base md:text-lg px-3 md:px-4 py-2 md:py-3 outline-none font-medium placeholder-gray-500">
                    <button type="submit" class="bg-[#00aa6c] hover:bg-[#008a57] text-white px-6 md:px-8 py-2 md:py-3.5 rounded-full font-bold text-base md:text-lg transition shadow-md whitespace-nowrap">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- HIGHLIGHT FEATURES (Optional, matching TripAdvisor's layout) --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 md:mt-16 mb-12 md:mb-20 hidden md:grid grid-cols-3 gap-8 text-center">
        <div>
            <div class="w-12 h-12 mx-auto mb-4 flex items-center justify-center text-[#00aa6c]">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            </div>
            <h3 class="font-bold text-gray-900 text-lg mb-2">Backed by travelers</h3>
            <p class="text-sm text-gray-600">Pesan dengan yakin berkat ulasan dari travelers yang pernah ke sana.</p>
        </div>
        <div>
            <div class="w-12 h-12 mx-auto mb-4 flex items-center justify-center text-[#00aa6c]">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
            </div>
            <h3 class="font-bold text-gray-900 text-lg mb-2">Pilihan Beragam</h3>
            <p class="text-sm text-gray-600">Temukan yang paling cocok untuk gaya liburan Anda.</p>
        </div>
        <div>
            <div class="w-12 h-12 mx-auto mb-4 flex items-center justify-center text-[#00aa6c]">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <h3 class="font-bold text-gray-900 text-lg mb-2">Penawaran Terbaik</h3>
            <p class="text-sm text-gray-600">Bandingkan harga dan ulasan sebelum Anda memutuskan untuk memesan.</p>
        </div>
    </div>

    {{-- TOP RANKED PLACES --}}
    @if($topPlaces->count() > 0)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 md:mt-16 mb-16">
        <div class="flex justify-between items-end mb-6">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">Travelers' Choice: Top {{ strtolower($category->name) }}</h2>
                <p class="text-sm md:text-base text-gray-500 mt-1">Destinasi terbaik berdasarkan rating dan ulasan pengunjung.</p>
            </div>
            <a href="{{ route('place.index', ['category' => $category->slug]) }}" class="hidden md:block font-bold text-gray-900 hover:underline">See all</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($topPlaces as $index => $place)
                <x-place-card-ranked :place="$place" :rank="$index + 1" />
            @endforeach
        </div>
        
        <div class="mt-6 md:hidden">
            <a href="{{ route('place.index', ['category' => $category->slug]) }}" class="block text-center w-full font-bold text-gray-900 border border-gray-900 rounded-full py-2 hover:bg-gray-50">See all</a>
        </div>
    </div>
    @endif

    {{-- RECOMMENDED PLACES --}}
    @if($recommendedPlaces->count() > 0)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="flex justify-between items-end mb-6">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">Recommended for you</h2>
                <p class="text-sm md:text-base text-gray-500 mt-1">Jelajahi Sukabumi, kami pikir Anda akan menyukai ini.</p>
            </div>
            <a href="{{ route('place.index', ['category' => $category->slug]) }}" class="hidden md:block font-bold text-gray-900 hover:underline">See all</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($recommendedPlaces as $place)
                <x-place-card :place="$place" />
            @endforeach
        </div>
        
        <div class="mt-6 md:hidden">
            <a href="{{ route('place.index', ['category' => $category->slug]) }}" class="block text-center w-full font-bold text-gray-900 border border-gray-900 rounded-full py-2 hover:bg-gray-50">See all</a>
        </div>
    </div>
    @endif

</div>
@include('components.footer')
@endsection
