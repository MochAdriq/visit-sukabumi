@extends('layouts.app')

@php
    $pageTitle = 'Semua Destinasi';
    $pageDesc = 'Temukan berbagai tempat wisata alam, petualangan seru, kuliner khas, dan penginapan nyaman untuk pengalaman tak terlupakan di Sukabumi.';
    $heroImg = asset('assets/images/9.jpg');

    if ($currentType === 'penginapan') {
        $pageTitle = 'Daftar Tempat Menginap';
        $pageDesc = 'Pilihan akomodasi terbaik mulai dari resort pegunungan, glamping asri, villa tepi pantai, hingga homestay lokal di Sukabumi.';
        $heroImg = asset('assets/images/5.jpg');
    } elseif ($currentCategory) {
        $pageTitle = 'Kategori: ' . $currentCategory->name;
        $pageDesc = $currentCategory->description ?? 'Eksplorasi pilihan destinasi terbaik di kategori ' . $currentCategory->name;
    }
    
    // Dynamic Hero Image from the first place with primaryImage if available
    if (isset($places) && $places->count() > 0) {
        $firstWithImg = $places->first(fn($p) => $p->primaryImage && !empty($p->primaryImage->image_path));
        if ($firstWithImg) {
            $heroImg = Storage::url($firstWithImg->primaryImage->image_path);
        }
    }
@endphp

@section('title', $pageTitle . ' — Visit Sukabumi')
@section('meta_description', $pageDesc)

@section('content')
<div class="min-h-screen bg-white font-sans text-gray-900 pb-16">
    @include('components.navbar')

    {{-- ══════════════════════════════════════════
         1. HERO SECTION (Immersive & Premium)
    ══════════════════════════════════════════ --}}
    <section class="relative h-[80vh] min-h-[580px] w-full flex items-center justify-center overflow-hidden">
        {{-- Background Image (Dinamis dari Database Destinasi) --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ $heroImg }}" alt="{{ $pageTitle }}" class="w-full h-full object-cover filter brightness-[0.55] transform scale-105 hover:scale-110 transition-transform duration-[20s] ease-out">
        </div>
        
        {{-- Elegant Multi-Stop Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-[#0a192f] via-black/45 to-black/30 z-10"></div>
        
        {{-- Hero Content --}}
        <div class="relative z-20 text-center px-4 max-w-4xl mx-auto mt-12">
            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black text-white tracking-tight leading-tight drop-shadow-2xl mb-4 uppercase">
                {{ $pageTitle }}
            </h1>
            
            <p class="text-base sm:text-xl text-gray-200 font-medium max-w-2xl mx-auto leading-relaxed drop-shadow-md mb-8">
                {{ $pageDesc }}
            </p>
            
            {{-- SEARCH BAR (Integrated) --}}
            <form action="{{ route('place.index') }}" method="GET" class="w-full max-w-2xl mx-auto bg-white rounded-full p-2 flex items-center shadow-2xl relative z-10 border border-white/20">
                <div class="pl-3 md:pl-4 text-gray-400">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ $currentType === 'penginapan' ? 'Cari hotel, villa, atau glamping...' : 'Cari nama tempat wisata, curug, pantai...' }}" class="w-full bg-transparent border-none focus:ring-0 text-gray-900 text-sm md:text-base px-3 md:px-4 py-2 md:py-3 outline-none font-medium placeholder-gray-400">
                
                @if(request()->has('type'))
                    <input type="hidden" name="type" value="{{ request('type') }}">
                @endif
                @if(request()->has('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif

                <button type="submit" class="bg-[#00aa6c] hover:bg-[#008a57] text-white px-6 md:px-8 py-2 md:py-3 rounded-full font-bold text-sm md:text-base transition shadow-md whitespace-nowrap">
                    Cari
                </button>
            </form>
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
                @if($currentType === 'penginapan')
                    <span class="font-bold text-gray-900">Tempat Menginap</span>
                @elseif($currentCategory)
                    <a href="{{ route('place.index') }}" class="hover:text-[#1a6bbf] transition-colors font-medium">Destinasi</a>
                    <span class="text-gray-300">›</span>
                    <span class="font-bold text-gray-900">{{ $currentCategory->name }}</span>
                @else
                    <span class="font-bold text-gray-900">{{ $pageTitle }}</span>
                @endif
            </nav>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         3. EDITORIAL SECTION (Ala Magazine Portal)
    ══════════════════════════════════════════ --}}
    @if(!request()->has('q'))
    <section class="border-b border-gray-100 bg-white py-12 md:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-start">
                
                {{-- Kolom Utama: Narasi Cerita Editorial (65% width) --}}
                <div class="lg:col-span-8">
                    @if($currentType === 'penginapan')
                        <h2 class="text-2xl md:text-3xl lg:text-4xl font-black text-gray-950 tracking-tight mb-3">
                            Mengenal Pilihan Akomodasi di Sukabumi
                        </h2>
                        <div class="w-16 h-1.5 bg-[#00aa6c] rounded-full mb-6"></div>

                        <div class="text-[15px] md:text-[16px] text-gray-700 leading-relaxed space-y-4 font-normal">
                            <p>
                                Sebagai kabupaten terluas di Pulau Jawa yang dianugerahi bentang alam <strong>GURILAPS</strong> (Gunung, Rimba, Laut, Pantai, dan Sungai), Sukabumi menawarkan keragaman akomodasi istimewa untuk setiap preferensi perjalanan Anda. Mulai dari resort pegunungan berhawa dingin sejuk di lereng Gunung Gede Pangrango dan Selabintana, pengalaman glamping mewah beratapkan langit malam di tepi danau Situ Gunung, hingga villa dan hotel tepi pantai dengan panorama deburan ombak Samudra Hindia di Palabuhanratu dan Ujung Genteng.
                            </p>
                            <p>
                                Memilih tempat menginap di Sukabumi sebaiknya diselaraskan dengan agenda penjelajahan Anda. Bagi pencinta ketenangan dan udara pegunungan, kawasan Sukabumi Utara menyediakan tempat peristirahatan damai di tengah hamparan perkebunan teh. Sementara bagi penjelajah kawasan <em>UNESCO Global Geopark Ciletuh</em> dan pantai selatan, tersedia kombinasi penginapan berfasilitas lengkap hingga deretan homestay ramah kantong yang dikelola hangat oleh masyarakat lokal.
                            </p>
                        </div>
                    @else
                        <h2 class="text-2xl md:text-3xl lg:text-4xl font-black text-gray-950 tracking-tight mb-3">
                            Pesona Wisata Tatar Pasundan yang Tiada Duanya
                        </h2>
                        <div class="w-16 h-1.5 bg-[#00aa6c] rounded-full mb-6"></div>

                        <div class="text-[15px] md:text-[16px] text-gray-700 leading-relaxed space-y-4 font-normal">
                            <p>
                                Sukabumi adalah simfoni bentang alam terlengkap di Jawa Barat. Dari ketinggian puncak Gunung Gede Pangrango yang menusuk dingin di utara, ngarai sungai berarus deras untuk arung jeram kelas dunia di bagian tengah, hingga bentang amfiteater alam purba <strong>UNESCO Global Geopark Ciletuh</strong> serta pesisir pantai Samudra Hindia di selatan.
                            </p>
                            <p>
                                Setiap destinasi dirancang untuk memberikan pengalaman otentik, memadukan pesona petualangan alam bebas dengan kehangatan kearifan lokal masyarakat Sunda. Mulai dari menjelajahi jembatan gantung terpanjang di Asia Tenggara (Situ Gunung Suspension Bridge), menyusuri seribu curug tersembunyi, hingga menyaksikan matahari terbenam keemasan di Karang Hawu.
                            </p>
                        </div>
                    @endif
                </div>

                {{-- Kolom Samping: Quick Guide / Sekilas Panduan (35% width) --}}
                <aside class="lg:col-span-4">
                    <div class="bg-slate-50 rounded-3xl border border-slate-200/80 p-6 sm:p-7 shadow-sm sticky top-24">
                        <div class="flex items-center gap-3 pb-4 mb-5 border-b border-slate-200/80">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-[#1a6bbf] flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-900 leading-tight">{{ $currentType === 'penginapan' ? 'Sekilas Panduan Menginap' : 'Sekilas Panduan Wisata' }}</h3>
                                <p class="text-xs text-gray-500">Tips & informasi esensial</p>
                            </div>
                        </div>

                        <div class="space-y-4 text-sm">
                            @if($currentType === 'penginapan')
                                {{-- Info 1 --}}
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center shrink-0 text-[#1a6bbf] mt-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Tipe Akomodasi</span>
                                        <span class="font-bold text-gray-900">Resort, Hotel, Villa, Glamping & Homestay</span>
                                    </div>
                                </div>

                                {{-- Info 2 --}}
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center shrink-0 text-amber-600 mt-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Area Favorit</span>
                                        <span class="font-bold text-gray-900">Selabintana, Palabuhanratu & Geopark Ciletuh</span>
                                    </div>
                                </div>

                                {{-- Info 3 --}}
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center shrink-0 text-indigo-600 mt-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Waktu Check-in</span>
                                        <span class="font-bold text-gray-900">Mulai 14.00 WIB (Sesuai Properti)</span>
                                    </div>
                                </div>
                            @else
                                {{-- Info 1 --}}
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center shrink-0 text-[#1a6bbf] mt-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Zona Wilayah</span>
                                        <span class="font-bold text-gray-900">3 Koridor (Utara, Tengah, Selatan)</span>
                                    </div>
                                </div>

                                {{-- Info 2 --}}
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center shrink-0 text-emerald-600 mt-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Status Geopark</span>
                                        <span class="font-bold text-gray-900">UNESCO Global Geopark 2018</span>
                                    </div>
                                </div>

                                {{-- Info 3 --}}
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center shrink-0 text-amber-600 mt-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Hawa & Cuaca</span>
                                        <span class="font-bold text-gray-900">18°C – 26°C Tropis Pegunungan</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Tombol Lompat ke Daftar --}}
                        <div class="mt-6 pt-4 border-t border-slate-200/80">
                            <a href="#daftar-tempat" class="inline-flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl bg-[#1a6bbf] hover:bg-[#15589c] text-white font-bold text-xs transition shadow-sm">
                                <span>{{ $currentType === 'penginapan' ? 'Lihat Daftar Penginapan' : 'Lihat Daftar Destinasi' }}</span>
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
         4. MAIN LISTING SECTION (GRID & PAGINATION)
    ══════════════════════════════════════════ --}}
    <section id="daftar-tempat" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 md:mt-14 mb-16 scroll-mt-20">
        
        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-8 gap-4 border-b border-gray-200 pb-4">
            <div>
                <h2 class="text-2xl md:text-3xl font-black text-gray-900">
                    {{ request()->has('q') ? 'Hasil Pencarian: "' . request('q') . '"' : ($currentType === 'penginapan' ? 'Semua Tempat Menginap' : 'Semua Destinasi Wisata') }}
                </h2>
                <p class="text-sm md:text-base text-gray-500 mt-1">
                    {{ $places->total() }} tempat ditemukan.
                </p>
            </div>

            <div class="flex items-center gap-4">
                @if(request()->has('q'))
                    <a href="{{ request()->fullUrlWithQuery(['q' => null]) }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-[#1a6bbf] hover:text-[#15589c] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>Hapus Pencarian</span>
                    </a>
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
            <div class="bg-gray-50 rounded-3xl border border-gray-200 p-12 flex flex-col items-center justify-center text-center mt-4">
                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center text-gray-400 mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-1">Belum Ada Tempat Ditemukan</h3>
                <p class="text-gray-500 text-sm max-w-sm mb-6">
                    Maaf, tidak ada destinasi atau akomodasi yang sesuai dengan pencarian Anda.
                </p>
                <a href="{{ $currentType === 'penginapan' ? route('penginapan.index') : route('place.index') }}" class="px-6 py-2.5 rounded-full bg-[#00aa6c] hover:bg-[#008a57] text-white font-bold text-sm transition shadow-sm">
                    {{ $currentType === 'penginapan' ? 'Tampilkan Semua Penginapan' : 'Tampilkan Semua Destinasi' }}
                </a>
            </div>
        @endif
    </section>

    {{-- ══════════════════════════════════════════
         5. MOSAIK EKSPLORASI (Bento Grid Visual)
    ══════════════════════════════════════════ --}}
    @if(!request()->has('q'))
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
    @endif

    @include('components.footer')
</div>
@endsection
