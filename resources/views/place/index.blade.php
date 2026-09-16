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

    {{-- HERO BANNER (Full Width Edge-to-Edge) --}}
    <div class="w-full h-[320px] md:h-[420px] lg:h-[460px] relative overflow-hidden group">
        {{-- Image Background --}}
        <img src="{{ $heroImg }}" alt="{{ $pageTitle }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-[10s]">
        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/45 to-black/30"></div>
        
        <div class="absolute inset-0 flex flex-col items-center justify-center px-4 md:px-10 text-center">
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-black text-white mb-3 md:mb-4 tracking-tight drop-shadow-lg leading-tight max-w-4xl">
                {{ $pageTitle }}
            </h1>
            
            <p class="text-white/90 text-sm md:text-lg max-w-2xl mx-auto drop-shadow-md mb-6 md:mb-8 font-normal leading-relaxed">
                {{ $pageDesc }}
            </p>
            
            {{-- SEARCH BAR --}}
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

    {{-- BREADCRUMBS STRIP (Di Bawah Banner) --}}
    <div class="border-b border-gray-100 py-3.5">
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

    {{-- EDITORIAL SECTION (Khusus Tempat Menginap - Ala VisitLondon Magazine) --}}
    @if($currentType === 'penginapan' && !request()->has('q'))
    <section class="border-b border-gray-100 bg-white py-10 md:py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-start">
                
                {{-- Kolom Utama: Narasi Cerita Editorial (65% width) --}}
                <div class="lg:col-span-8">
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-gray-950 tracking-tight mb-3">
                        Mengenal Pilihan Akomodasi di Sukabumi
                    </h2>
                    <div class="w-14 h-1 bg-[#1a6bbf] rounded-full mb-6"></div>

                    <div class="text-[16px] md:text-[17px] text-gray-700 leading-relaxed space-y-4 font-normal [&>p]:mb-4 [&>p]:leading-relaxed [&>p>strong]:text-gray-950 [&>p>strong]:font-bold">
                        <p>
                            Sebagai kabupaten terluas kedua di Pulau Jawa yang dianugerahi bentang alam <strong>GURILAPS</strong> (Gunung, Rimba, Laut, Pantai, dan Sungai), Sukabumi menawarkan keragaman akomodasi yang istimewa untuk setiap preferensi perjalanan. Mulai dari resort pegunungan berhawa sejuk di lereng Gunung Gede Pangrango dan Selabintana, pengalaman glamping mewah beratapkan langit malam di kawasan Situ Gunung, hingga villa dan hotel tepi pantai dengan panorama deburan ombak Samudra Hindia di Palabuhanratu dan Ujung Genteng.
                        </p>
                        <p>
                            Memilih tempat menginap di Sukabumi sebaiknya diselaraskan dengan agenda penjelajahan Anda. Bagi pencinta ketenangan dan udara pegunungan, kawasan Sukabumi Utara menyediakan tempat peristirahatan damai di tengah perkebunan teh dan rimbunnya hutan tropis. Sementara bagi penjelajah kawasan <em>UNESCO Global Geopark Ciletuh</em> dan pantai selatan, tersedia kombinasi hotel berfasilitas lengkap hingga deretan homestay ramah kantong yang dikelola oleh masyarakat lokal, menghadirkan kehangatan tradisi dan cita rasa kuliner pesisir otentik.
                        </p>
                        <p>
                            Untuk kenyamanan maksimal, wisatawan disarankan melakukan reservasi lebih awal terutama saat musim liburan sekolah atau akhir pekan panjang. Pastikan memilih akomodasi yang memudahkan mobilitas menuju destinasi impian Anda, serta periksa fasilitas seperti ketersediaan pemandu lokal atau akses kendaraan menuju spot-spot wisata alam tersembunyi.
                        </p>
                    </div>
                </div>

                {{-- Kolom Samping: Quick Facts / Sekilas Panduan (35% width) --}}
                <aside class="lg:col-span-4">
                    <div class="bg-slate-50/90 rounded-2xl border border-slate-200/80 p-6 shadow-sm sticky top-24">
                        <div class="flex items-center gap-2.5 pb-4 mb-5 border-b border-slate-200/80">
                            <div class="w-9 h-9 rounded-xl bg-blue-100 text-[#1a6bbf] flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-900 leading-tight">Sekilas Panduan Menginap</h3>
                                <p class="text-xs text-gray-500">Informasi akomodasi Sukabumi</p>
                            </div>
                        </div>

                        <div class="space-y-4 text-sm">
                            {{-- Info 1: Tipe Akomodasi --}}
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center shrink-0 text-[#1a6bbf] mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Tipe Penginapan</span>
                                    <span class="font-bold text-gray-900">Resort, Hotel, Villa, Glamping & Homestay</span>
                                </div>
                            </div>

                            {{-- Info 2: Area Populer --}}
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center shrink-0 text-amber-600 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Area Favorit</span>
                                    <span class="font-bold text-gray-900">Selabintana, Palabuhanratu, Cisolok & Geopark</span>
                                </div>
                            </div>

                            {{-- Info 3: Waktu Check-in --}}
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center shrink-0 text-indigo-600 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Waktu Check-in</span>
                                    <span class="font-bold text-gray-900">Mulai 14.00 WIB (Sesuai Kebijakan)</span>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Lompat ke Daftar --}}
                        <div class="mt-6 pt-4 border-t border-slate-200/80">
                            <a href="#daftar-tempat" class="inline-flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl bg-[#1a6bbf] hover:bg-[#15589c] text-white font-bold text-xs transition shadow-sm">
                                <span>Lihat Daftar Penginapan</span>
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

    {{-- MAIN LISTING SECTION --}}
    <div id="daftar-tempat" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 md:mt-14 mb-16 scroll-mt-20">
        
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
