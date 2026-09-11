@extends('layouts.app')

@section('title', $tag->name . ' di Sukabumi — Visit Sukabumi')
@section('meta_description', $tag->description ?? 'Temukan ' . $tag->name . ' terbaik di Sukabumi.')

@section('content')
<div class="min-h-screen bg-white font-sans text-gray-900 pb-16">
    @include('components.navbar')

    {{-- HERO BANNER (Ala Event) --}}
    <div class="w-full h-[350px] md:h-[550px] relative md:mt-4 max-w-[1400px] mx-auto md:px-4 sm:px-6 lg:px-8">
        <div class="w-full h-full md:rounded-[2rem] overflow-hidden relative shadow-lg group">
            {{-- Image Background --}}
            <img src="{{ $tag->cover_image }}" alt="{{ $tag->name }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-[10s]">
            <div class="absolute inset-0 bg-black/40"></div>
            
            <div class="absolute inset-0 flex flex-col items-center justify-center px-4 md:px-10 text-center">
                {{-- Breadcrumb inside Hero --}}
                <nav class="flex text-sm text-white/80 gap-2 items-center mb-4 flex-wrap justify-center relative z-10 drop-shadow-md">
                    <a href="{{ url('/') }}" class="hover:text-white transition-colors">Home</a>
                    <span>›</span>
                    <a href="{{ $tag->type === 'wisata' ? route('tag.index.wisata') : route('tag.index.activity') }}" class="hover:text-white transition-colors">{{ $tag->type_label }}</a>
                    <span>›</span>
                    <span class="font-bold text-white">{{ $tag->name }}</span>
                </nav>

                <h1 class="text-3xl md:text-5xl lg:text-6xl font-black text-white mb-4 tracking-tight drop-shadow-lg leading-tight max-w-4xl">
                    {{ $tag->name }}
                </h1>
                
                @if($tag->description)
                <p class="text-white/90 text-sm md:text-lg max-w-2xl mx-auto drop-shadow-md mb-8">
                    {{ $tag->description }}
                </p>
                @endif
                
                {{-- SEARCH BAR (Ala Event) --}}
                <form action="{{ $tag->url }}" method="GET" class="w-full max-w-2xl bg-white rounded-full p-2 flex items-center shadow-2xl relative z-10">
                    <div class="pl-3 md:pl-4 text-gray-400">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama tempat atau lokasi..." class="w-full bg-transparent border-none focus:ring-0 text-gray-900 text-base md:text-lg px-3 md:px-4 py-2 md:py-3 outline-none font-medium placeholder-gray-500">
                    
                    {{-- Keep existing sort param if any --}}
                    @if(request()->has('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif

                    <button type="submit" class="bg-[#00aa6c] hover:bg-[#008a57] text-white px-6 md:px-8 py-2 md:py-3.5 rounded-full font-bold text-base md:text-lg transition shadow-md whitespace-nowrap">
                        Cari
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- MAIN LISTING SECTION --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 md:mt-16 mb-16">
        
        {{-- HEADER & SORTING --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-8 gap-4 border-b border-gray-200 pb-4">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">
                    {{ request()->has('q') ? 'Hasil Pencarian: "' . request('q') . '"' : 'Daftar Destinasi' }}
                </h2>
                <p class="text-sm md:text-base text-gray-500 mt-1">
                    {{ $places->total() }} tempat ditemukan.
                </p>
            </div>

            <div class="flex items-center gap-4">
                @if(request()->has('q'))
                    <a href="{{ $tag->url }}" class="text-sm font-bold text-gray-500 hover:text-gray-900 transition-colors">Hapus Pencarian</a>
                @endif
                
                {{-- Dropdown Sorting --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center justify-between w-48 bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00aa6c]/50 transition-colors">
                        <span class="truncate">
                            @php
                                $sortLabel = match(request('sort')) {
                                    'highest_rated' => 'Rating Tertinggi',
                                    'most_reviewed' => 'Ulasan Terbanyak',
                                    'price_low' => 'Harga Terendah',
                                    'price_high' => 'Harga Tertinggi',
                                    default => 'Rekomendasi (Default)'
                                };
                            @endphp
                            {{ $sortLabel }}
                        </span>
                        <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition.opacity class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-1.5 z-40 overflow-hidden" style="display: none;">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'recommended']) }}" class="block px-4 py-2 text-sm {{ request('sort', 'recommended') === 'recommended' ? 'bg-[#00aa6c]/10 text-[#008a57] font-bold' : 'text-gray-700 hover:bg-gray-50' }}">Rekomendasi (Default)</a>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'highest_rated']) }}" class="block px-4 py-2 text-sm {{ request('sort') === 'highest_rated' ? 'bg-[#00aa6c]/10 text-[#008a57] font-bold' : 'text-gray-700 hover:bg-gray-50' }}">Rating Tertinggi</a>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'most_reviewed']) }}" class="block px-4 py-2 text-sm {{ request('sort') === 'most_reviewed' ? 'bg-[#00aa6c]/10 text-[#008a57] font-bold' : 'text-gray-700 hover:bg-gray-50' }}">Ulasan Terbanyak</a>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}" class="block px-4 py-2 text-sm {{ request('sort') === 'price_low' ? 'bg-[#00aa6c]/10 text-[#008a57] font-bold' : 'text-gray-700 hover:bg-gray-50' }}">Harga Terendah</a>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}" class="block px-4 py-2 text-sm {{ request('sort') === 'price_high' ? 'bg-[#00aa6c]/10 text-[#008a57] font-bold' : 'text-gray-700 hover:bg-gray-50' }}">Harga Tertinggi</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- PLACE GRID --}}
        @if($places->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($places as $place)
                    <x-place-card-grid :place="$place" />
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-12 flex justify-center">
                {{ $places->links() }}
            </div>
        @else
            {{-- Empty State --}}
            <div class="bg-gray-50 rounded-2xl border border-gray-100 p-12 flex flex-col items-center justify-center text-center mt-4">
                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                </svg>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Destinasi Tidak Ditemukan</h3>
                <p class="text-gray-500 max-w-md mx-auto mb-6">
                    Maaf, tidak ada tempat yang sesuai dengan pencarian Anda di kategori ini.
                </p>
                <a href="{{ $tag->url }}" class="bg-[#00aa6c] text-white px-6 py-2.5 rounded-full font-bold hover:bg-[#008a57] transition shadow-sm">
                    Tampilkan Semua Destinasi
                </a>
            </div>
        @endif
        
    </div>
</div>
@include('components.footer')
@endsection
