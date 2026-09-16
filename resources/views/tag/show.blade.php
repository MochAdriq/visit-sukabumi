@extends('layouts.app')

@section('title', $tag->name . ' di Sukabumi — Visit Sukabumi')
@section('meta_description', $tag->description ?? 'Temukan ' . $tag->name . ' terbaik di Sukabumi.')

@section('content')
<div class="min-h-screen bg-white font-sans text-gray-900 pb-16">
    @include('components.navbar')

    {{-- ══════════════════════════════════════════
         1. HERO BANNER (Full Width Edge-to-Edge)
    ══════════════════════════════════════════ --}}
    <div class="w-full h-[300px] md:h-[400px] lg:h-[440px] relative overflow-hidden group">
        {{-- Image Background --}}
        <img src="{{ $tag->cover_image }}" alt="{{ $tag->name }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-[10s]">
        {{-- Overlay Gradient --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/45 to-black/30"></div>
        
        <div class="absolute inset-0 flex flex-col items-center justify-center px-4 md:px-10 text-center">
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-black text-white mb-3 md:mb-4 tracking-tight drop-shadow-lg leading-tight max-w-4xl">
                {{ $tag->name }}
            </h1>
            
            @if($tag->description)
            <p class="text-white/90 text-sm md:text-lg max-w-2xl mx-auto drop-shadow-md font-normal leading-relaxed">
                {{ $tag->description }}
            </p>
            @endif
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         2. BREADCRUMBS STRIP (Di Bawah Banner)
    ══════════════════════════════════════════ --}}
    <div class="border-b border-gray-100 py-3.5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs md:text-sm text-gray-500 gap-2 items-center flex-wrap">
                <a href="{{ url('/') }}" class="hover:text-[#1a6bbf] transition-colors font-medium">Home</a>
                <span class="text-gray-300">›</span>
                <a href="{{ $tag->type === 'wisata' ? route('tag.index.wisata') : route('tag.index.activity') }}" class="hover:text-[#1a6bbf] transition-colors font-medium">{{ $tag->type_label }}</a>
                <span class="text-gray-300">›</span>
                <span class="font-bold text-gray-900">{{ $tag->name }}</span>
            </nav>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         2. EDITORIAL & GUIDE SECTION (Ala VisitLondon Magazine Layout)
    ══════════════════════════════════════════ --}}
    @if($tag->long_description)
    <section class="border-b border-gray-100 bg-white py-10 md:py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-start">
                
                {{-- Kolom Utama: Narasi Cerita Editorial (65% width) --}}
                <div class="lg:col-span-8">
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-gray-950 tracking-tight mb-3">
                        Mengenal Lebih Dekat {{ $tag->name }}
                    </h2>
                    <div class="w-14 h-1 bg-[#1a6bbf] rounded-full mb-6"></div>

                    <div class="text-[16px] md:text-[17px] text-gray-700 leading-relaxed space-y-4 font-normal [&>p]:mb-4 [&>p]:leading-relaxed [&>p>strong]:text-gray-950 [&>p>strong]:font-bold">
                        {!! $tag->long_description !!}
                    </div>
                </div>

                {{-- Kolom Samping: Quick Facts / Sekilas Panduan (35% width) --}}
                <aside class="lg:col-span-4">
                    <div class="bg-slate-50/90 rounded-2xl border border-slate-200/80 p-6 shadow-sm sticky top-24">
                        <div class="flex items-center gap-2.5 pb-4 mb-5 border-b border-slate-200/80">
                            <div class="w-9 h-9 rounded-xl bg-blue-100 text-[#1a6bbf] flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-900 leading-tight">Sekilas Panduan</h3>
                                <p class="text-xs text-gray-500">Informasi ringkas untuk traveler</p>
                            </div>
                        </div>

                        <div class="space-y-4 text-sm">
                            {{-- Info 1: Kategori --}}
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center shrink-0 text-[#1a6bbf] mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Tipe Pengalaman</span>
                                    <span class="font-bold text-gray-900">{{ $tag->type_label }}</span>
                                </div>
                            </div>

                            {{-- Info 2: Wilayah --}}
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center shrink-0 text-amber-600 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Cakupan Wilayah</span>
                                    <span class="font-bold text-gray-900">Kabupaten Sukabumi</span>
                                </div>
                            </div>

                            {{-- Info 3: Waktu Kunjungan --}}
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center shrink-0 text-indigo-600 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Waktu Kunjungan</span>
                                    <span class="font-bold text-gray-900">Pagi - Sore (Cuaca Cerah)</span>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Lompat ke Daftar --}}
                        <div class="mt-6 pt-4 border-t border-slate-200/80">
                            <a href="#daftar-destinasi" class="inline-flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl bg-[#1a6bbf] hover:bg-[#15589c] text-white font-bold text-xs transition shadow-sm">
                                <span>Lihat Daftar Destinasi</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </aside>

            </div>
        </div>
    </section>
    @endif

    {{-- ══════════════════════════════════════════
         3. MAIN LISTING SECTION WITH INTEGRATED CONTROLS
    ══════════════════════════════════════════ --}}
    <div id="daftar-destinasi" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 md:mt-14 mb-16 scroll-mt-20">
        
        {{-- HEADER, SEARCH & SORTING (Ala VisitLondon In-Context) --}}
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 gap-4 border-b border-gray-200 pb-5">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">
                    {{ request()->has('q') ? 'Hasil Pencarian: "' . request('q') . '"' : 'Daftar Destinasi ' . $tag->name }}
                </h2>
                <p class="text-sm md:text-base text-gray-500 mt-1">
                    {{ $places->total() }} tempat ditemukan.
                </p>
            </div>

            {{-- SEARCH & SORT CONTROLS --}}
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full lg:w-auto">
                {{-- Search Form In-Context --}}
                <form action="{{ $tag->url }}#daftar-destinasi" method="GET" class="relative flex items-center min-w-[260px] sm:w-72">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari di kategori ini..." class="w-full bg-gray-50 hover:bg-white focus:bg-white border border-gray-300 rounded-xl pl-10 pr-9 py-2 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1a6bbf] focus:border-transparent transition-all">
                    <div class="absolute left-3 text-gray-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    @if(request()->has('q'))
                        <a href="{{ $tag->url }}#daftar-destinasi" class="absolute right-3 text-gray-400 hover:text-gray-600 transition" title="Hapus pencarian">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </a>
                    @endif
                    @if(request()->has('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                </form>

                {{-- Dropdown Sorting --}}
                <div class="relative shrink-0" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center justify-between w-full sm:w-48 bg-white border border-gray-300 rounded-xl px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-xs focus:outline-none focus:ring-2 focus:ring-[#1a6bbf] transition-colors">
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
                        <svg class="w-4 h-4 ml-2 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition.opacity class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-1.5 z-40 overflow-hidden" style="display: none;">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'recommended']) }}#daftar-destinasi" class="block px-4 py-2 text-sm {{ request('sort', 'recommended') === 'recommended' ? 'bg-blue-50 text-[#1a6bbf] font-bold' : 'text-gray-700 hover:bg-gray-50' }}">Rekomendasi (Default)</a>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'highest_rated']) }}#daftar-destinasi" class="block px-4 py-2 text-sm {{ request('sort') === 'highest_rated' ? 'bg-blue-50 text-[#1a6bbf] font-bold' : 'text-gray-700 hover:bg-gray-50' }}">Rating Tertinggi</a>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'most_reviewed']) }}#daftar-destinasi" class="block px-4 py-2 text-sm {{ request('sort') === 'most_reviewed' ? 'bg-blue-50 text-[#1a6bbf] font-bold' : 'text-gray-700 hover:bg-gray-50' }}">Ulasan Terbanyak</a>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}#daftar-destinasi" class="block px-4 py-2 text-sm {{ request('sort') === 'price_low' ? 'bg-blue-50 text-[#1a6bbf] font-bold' : 'text-gray-700 hover:bg-gray-50' }}">Harga Terendah</a>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}#daftar-destinasi" class="block px-4 py-2 text-sm {{ request('sort') === 'price_high' ? 'bg-blue-50 text-[#1a6bbf] font-bold' : 'text-gray-700 hover:bg-gray-50' }}">Harga Tertinggi</a>
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
                <a href="{{ $tag->url }}" class="bg-[#1a6bbf] text-white px-6 py-2.5 rounded-full font-bold hover:bg-[#15589c] transition shadow-sm">
                    Tampilkan Semua Destinasi
                </a>
            </div>
        @endif
        
    </div>
</div>
@include('components.footer')
@endsection
