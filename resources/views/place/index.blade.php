@extends('layouts.app')

@php
    $pageTitle = 'Semua Destinasi';
    $pageDesc = 'Temukan berbagai tempat wisata, kuliner lezat, dan penginapan nyaman untuk pengalaman tak terlupakan di Sukabumi.';
    $heroImg = asset('assets/images/9.jpg');

    if ($currentType === 'penginapan') {
        $pageTitle = 'Daftar Tempat Menginap';
        $pageDesc = 'Pilihan akomodasi terbaik untuk kenyamanan istirahat Anda di Sukabumi.';
        $heroImg = asset('assets/images/5.jpg');
    } elseif ($currentCategory) {
        $pageTitle = 'Kategori: ' . $currentCategory->name;
        $pageDesc = $currentCategory->description ?? 'Eksplorasi pilihan terbaik di kategori ' . $currentCategory->name;
    }
    
    // Dynamic Hero Image from the first place if available
    if (isset($places) && $places->count() > 0 && $places->first()->primaryImage) {
        $heroImg = Storage::url($places->first()->primaryImage->image_path);
    }
@endphp

@section('title', $pageTitle . ' — Visit Sukabumi')
@section('meta_description', $pageDesc)

@section('content')
<div class="min-h-screen bg-white font-sans text-gray-900 pb-16">
    @include('components.navbar')

    {{-- HERO BANNER (Ala Event) --}}
    <div class="w-full h-[350px] md:h-[550px] relative md:mt-4 max-w-[1400px] mx-auto md:px-4 sm:px-6 lg:px-8">
        <div class="w-full h-full md:rounded-[2rem] overflow-hidden relative shadow-lg group">
            {{-- Image Background --}}
            <img src="{{ $heroImg }}" alt="{{ $pageTitle }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-[10s]">
            <div class="absolute inset-0 bg-black/40"></div>
            
            <div class="absolute inset-0 flex flex-col items-center justify-center px-4 md:px-10 text-center">
                {{-- Breadcrumb inside Hero --}}
                <nav class="flex text-sm text-white/80 gap-2 items-center mb-4 flex-wrap justify-center relative z-10 drop-shadow-md">
                    <a href="{{ url('/') }}" class="hover:text-white transition-colors">Home</a>
                    <span>›</span>
                    <span class="font-bold text-white">{{ $pageTitle }}</span>
                </nav>

                <h1 class="text-3xl md:text-5xl lg:text-6xl font-black text-white mb-4 tracking-tight drop-shadow-lg leading-tight max-w-4xl">
                    {{ $pageTitle }}
                </h1>
                
                <p class="text-white/90 text-sm md:text-lg max-w-2xl mx-auto drop-shadow-md mb-8">
                    {{ $pageDesc }}
                </p>
                
                {{-- SEARCH BAR (Ala Event) --}}
                <form action="{{ route('place.index') }}" method="GET" class="w-full max-w-2xl bg-white rounded-full p-2 flex items-center shadow-2xl relative z-10">
                    <div class="pl-3 md:pl-4 text-gray-400">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama tempat..." class="w-full bg-transparent border-none focus:ring-0 text-gray-900 text-base md:text-lg px-3 md:px-4 py-2 md:py-3 outline-none font-medium placeholder-gray-500">
                    
                    @if(request()->has('type'))
                        <input type="hidden" name="type" value="{{ request('type') }}">
                    @endif
                    @if(request()->has('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
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
        
        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-8 gap-4 border-b border-gray-200 pb-4">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">
                    {{ request()->has('q') ? 'Hasil Pencarian: "' . request('q') . '"' : 'Daftar Tempat' }}
                </h2>
                <p class="text-sm md:text-base text-gray-500 mt-1">
                    {{ $places->total() }} tempat ditemukan.
                </p>
            </div>

            <div class="flex items-center gap-4">
                @if(request()->has('q'))
                    <a href="{{ request()->fullUrlWithQuery(['q' => null]) }}" class="text-sm font-bold text-gray-500 hover:text-gray-900 transition-colors">Hapus Pencarian</a>
                @endif
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Tempat</h3>
                <p class="text-gray-500 max-w-md mx-auto mb-6">
                    Maaf, tidak ada akomodasi atau tempat yang sesuai dengan pencarian Anda.
                </p>
                <a href="{{ route('penginapan.index') }}" class="bg-[#00aa6c] text-white px-6 py-2.5 rounded-full font-bold hover:bg-[#008a57] transition shadow-sm">
                    Tampilkan Semua Penginapan
                </a>
            </div>
        @endif
        
    </div>
</div>
@include('components.footer')
@endsection
