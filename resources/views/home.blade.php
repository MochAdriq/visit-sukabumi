@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.navbar')

    <main>
        <!-- HERO SECTION -->
        <div class="relative bg-gray-900" style="height: 70vh; min-height: 500px;">
            <div class="absolute inset-0">
                <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1596404554311-66774e50ebec?q=80&w=1920&h=800&fit=crop" alt="Pemandangan Sukabumi" />
                <div class="absolute inset-0 bg-black opacity-30"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-6 h-full flex flex-col justify-center">
                <h1 class="text-5xl md:text-6xl font-black text-white uppercase tracking-wider mb-8 drop-shadow-lg">
                    Discover Sukabumi
                </h1>

                <div class="bg-white/95 backdrop-blur-sm p-4 rounded shadow-xl max-w-lg">
                    <details class="group">
                        <summary class="flex justify-between items-center cursor-pointer list-none text-xl font-bold text-gray-800">
                            <span>I want to...</span>
                            <span class="transition-transform group-open:rotate-180">
                                <svg fill="none" height="20" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="20">
                                    <path d="M6 9l6 6 6-6"/>
                                </svg>
                            </span>
                        </summary>
                        <div class="mt-3 pt-3 border-t border-gray-200 space-y-2">
                            <a href="#" class="block text-[15px] text-[#1a6bbf] hover:text-[#145299] font-semibold">Kunjungi destinasi alam terbaik</a>
                            <a href="#" class="block text-[15px] text-[#1a6bbf] hover:text-[#145299] font-semibold">Jelajahi Geopark Ciletuh</a>
                            <a href="#" class="block text-[15px] text-[#1a6bbf] hover:text-[#145299] font-semibold">Nikmati kuliner lokal</a>
                            <a href="#" class="block text-[15px] text-[#1a6bbf] hover:text-[#145299] font-semibold">Ikuti tur arung jeram</a>
                            <a href="#" class="block text-[15px] text-[#1a6bbf] hover:text-[#145299] font-semibold">Temukan penginapan terbaik</a>
                        </div>
                    </details>
                </div>
            </div>
        </div>

        <!-- USP BAR -->
        <div class="bg-[#1a6bbf] text-white py-6 px-6">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-6">
                <h2 class="text-[13px] font-bold uppercase tracking-widest whitespace-nowrap border-r border-white/30 pr-6">
                    Sukabumi's Official Visitor Guide
                </h2>
                <div class="flex flex-col sm:flex-row gap-6 flex-1">
                    <div class="flex items-center gap-3">
                        <svg class="w-8 h-8 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <p class="text-sm">Inspiring <strong>wisatawan lokal & mancanegara</strong></p>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-8 h-8 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5"/>
                        </svg>
                        <p class="text-sm"><strong>Temukan dengan mudah</strong> melalui direktori terpercaya</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-8 h-8 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <p class="text-sm">Kunjunganmu <strong>mendukung pariwisata lokal</strong></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- MUST-SEES -->
        <div class="max-w-7xl mx-auto px-6 py-14">
            <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tight mb-3">Must-sees in Sukabumi</h2>
            <p class="text-base text-gray-600 mb-8 max-w-2xl">A trip to Sukabumi wouldn't be complete without experiencing our most iconic nature attractions, stunning waterfalls and exciting outdoor tours.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                <a href="#" class="group relative block h-72 overflow-hidden bg-gray-900 rounded shadow-md transition-transform hover:-translate-y-1">
                    <span class="absolute top-4 left-0 bg-[#1a6bbf] text-white text-[11px] font-bold px-3 py-1 uppercase z-20 tracking-wide">Top Rated</span>
                    <img alt="Geopark Ciletuh" src="https://images.unsplash.com/photo-1542662565-7e4fd1e56993?q=80&w=640&h=480&fit=crop" class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                    <div class="absolute bottom-0 p-5 z-10 w-full">
                        <h3 class="text-lg font-bold text-white mb-1">Geopark Ciletuh</h3>
                        <p class="text-xs text-gray-300 line-clamp-2">Jelajahi UNESCO Global Geopark dengan air terjun memukau dan pemandangan amfiteater alam.</p>
                    </div>
                </a>

                <a href="#" class="group relative block h-72 overflow-hidden bg-gray-900 rounded shadow-md transition-transform hover:-translate-y-1">
                    <img alt="Situ Gunung" src="https://images.unsplash.com/photo-1610486001224-b0402b8552fc?q=80&w=640&h=480&fit=crop" class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                    <div class="absolute bottom-0 p-5 z-10 w-full">
                        <h3 class="text-lg font-bold text-white mb-1">Situ Gunung</h3>
                        <p class="text-xs text-gray-300 line-clamp-2">Rasakan jembatan gantung terpanjang di Asia Tenggara di tengah hutan pinus yang sejuk.</p>
                    </div>
                </a>

                <a href="#" class="group relative block h-72 overflow-hidden bg-gray-900 rounded shadow-md transition-transform hover:-translate-y-1 lg:col-span-2">
                    <span class="absolute top-4 left-0 bg-[#1a6bbf] text-white text-[11px] font-bold px-3 py-1 uppercase z-20 tracking-wide">An itinerary essential</span>
                    <img alt="Pelabuhan Ratu" src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=1280&h=480&fit=crop" class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                    <div class="absolute bottom-0 p-5 z-10 w-full">
                        <h3 class="text-xl font-bold text-white mb-1">Pelabuhan Ratu</h3>
                        <p class="text-xs text-gray-300 line-clamp-2 max-w-sm">Nikmati keindahan pantai selatan dengan ombak legendaris dan pemandangan matahari terbenam.</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- FIRST-TIME VISITOR CALLOUT -->
        <div class="bg-white border-y border-gray-200 py-14">
            <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row gap-12 items-center">
                <div class="flex-1">
                    <h2 class="text-3xl font-black text-gray-900 uppercase border-l-4 border-[#1a6bbf] pl-4 mb-4">Pertama kali ke Sukabumi?</h2>
                    <hr class="border-[#1a6bbf] mb-4 w-16"/>
                    <p class="text-lg text-gray-700 font-medium leading-relaxed">Temukan panduan lengkap wisata Sukabumi dari destinasi alam terbaik hingga kuliner, hotel, dan aktivitas seru!</p>
                </div>
                <div class="flex-1 space-y-5">
                    <p class="text-gray-600 leading-relaxed">Jika ini pertama kali kamu mengunjungi Sukabumi, panduan ini akan membantu perjalananmu menjadi aman, mudah, dan menyenangkan!</p>
                    <a href="#" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-white bg-[#1a6bbf] hover:bg-[#145299] rounded transition-colors shadow-sm">
                        Pelajari lebih lanjut
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- ANIMATED CATEGORY ICONS -->
        @php
        $categories = [
            ['name' => 'Wisata Alam', 'lottie' => 'https://assets5.lottiefiles.com/packages/lf20_qm8eqzse.json'],
            ['name' => 'Arung Jeram', 'lottie' => 'https://assets10.lottiefiles.com/packages/lf20_qnbs5sez.json'],
            ['name' => 'Wisata Pantai', 'lottie' => 'https://assets9.lottiefiles.com/packages/lf20_ysas4vcp.json'],
            ['name' => 'Kuliner Lokal', 'lottie' => 'https://assets4.lottiefiles.com/packages/lf20_5njp3udg.json'],
            ['name' => 'Hiking', 'lottie' => 'https://assets7.lottiefiles.com/packages/lf20_vnik36ac.json'],
            ['name' => 'Hotel & Resort', 'lottie' => 'https://assets4.lottiefiles.com/packages/lf20_v1yudlrx.json'],
        ];
        @endphp

        <div class="max-w-7xl mx-auto px-6 py-14">
            <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Butuh inspirasi aktivitas?</h2>
            <div class="grid grid-cols-3 md:grid-cols-6 gap-2">
                @foreach($categories as $cat)
                    <a href="#" class="vs-icon-panel">
                        <div class="vs-icon-box">
                            <lottie-player src="{{ $cat['lottie'] }}" background="transparent" speed="1" style="width: 100%; height: 100%;" autoplay loop></lottie-player>
                        </div>
                        <h3>{{ $cat['name'] }}</h3>
                    </a>
                @endforeach
            </div>
        </div>

    </main>

    <!-- FOOTER -->
    <footer class="bg-[#1a2b3c] text-[#aac] py-12">
        <div class="max-w-7xl mx-auto px-6 text-center flex flex-col items-center gap-6">
            <h2 class="text-white text-2xl font-bold">Visit Sukabumi</h2>
            <div class="flex flex-wrap justify-center gap-6">
                <a href="#" class="hover:text-white transition-colors text-sm font-medium">Tentang Kami</a>
                <a href="#" class="hover:text-white transition-colors text-sm font-medium">Kebijakan Privasi</a>
                <a href="#" class="hover:text-white transition-colors text-sm font-medium">Kontak</a>
                <a href="#" class="hover:text-white transition-colors text-sm font-medium">Sitemap</a>
            </div>
            <p class="text-sm border-t border-gray-700 pt-6 w-full max-w-lg">© 2026 Visit Sukabumi. Panduan Wisata Resmi Kabupaten & Kota Sukabumi.</p>
        </div>
    </footer>
</div>
@endsection
