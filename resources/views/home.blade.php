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

            <div class="relative max-w-7xl mx-auto px-6 h-full flex flex-col items-center justify-center">
                <h1 class="text-5xl md:text-7xl font-bold text-white drop-shadow-lg mb-8 text-center" style="text-shadow: 0 4px 12px rgba(0,0,0,0.4);">
                    Discover Sukabumi
                </h1>

                <div class="relative w-full max-w-3xl">
                    <details class="group relative">
                        <summary class="bg-white h-[60px] rounded-full flex items-center justify-between pl-8 pr-2 shadow-2xl cursor-pointer list-none [&::-webkit-details-marker]:hidden">
                            <span class="text-gray-700 text-[17px]">I want to</span>
                            <div class="w-11 h-11 bg-[#1a6bbf] rounded-full flex items-center justify-center text-white transition-transform duration-300 group-open:rotate-180 flex-shrink-0">
                                <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewBox="0 0 24 24" width="24">
                                    <path d="M6 9l6 6 6-6"/>
                                </svg>
                            </div>
                        </summary>
                        
                        <!-- Dropdown Content -->
                        <div class="absolute left-0 right-0 top-full mt-3 bg-white rounded-2xl shadow-2xl overflow-hidden z-50 py-2">
                            <a href="#" class="block px-8 py-3 text-[16px] text-[#1a6bbf] hover:bg-[#f0f7ff] hover:text-[#145299] font-semibold transition-colors">Kunjungi destinasi alam terbaik</a>
                            <a href="#" class="block px-8 py-3 text-[16px] text-[#1a6bbf] hover:bg-[#f0f7ff] hover:text-[#145299] font-semibold transition-colors">Jelajahi Geopark Ciletuh</a>
                            <a href="#" class="block px-8 py-3 text-[16px] text-[#1a6bbf] hover:bg-[#f0f7ff] hover:text-[#145299] font-semibold transition-colors">Nikmati kuliner lokal</a>
                            <a href="#" class="block px-8 py-3 text-[16px] text-[#1a6bbf] hover:bg-[#f0f7ff] hover:text-[#145299] font-semibold transition-colors">Ikuti tur arung jeram</a>
                            <a href="#" class="block px-8 py-3 text-[16px] text-[#1a6bbf] hover:bg-[#f0f7ff] hover:text-[#145299] font-semibold transition-colors">Temukan penginapan terbaik</a>
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

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Card 1 -->
                <a href="#" class="group relative block h-80 overflow-hidden bg-gray-900 rounded-xl shadow-md cursor-pointer">
                    <span class="absolute top-4 left-0 bg-[#f9a826] text-gray-900 text-[12px] font-bold px-3 py-1 z-20 rounded-r-md shadow-sm">Special offer</span>
                    <img alt="Geopark Ciletuh" src="https://images.unsplash.com/photo-1542662565-7e4fd1e56993?q=80&w=640&h=480&fit=crop" class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute inset-x-0 bottom-0 p-5 z-10 flex flex-col justify-end">
                        <h3 class="text-xl font-bold text-white group-hover:underline decoration-2 underline-offset-4 transition-all duration-300">Geopark Ciletuh</h3>
                        <div class="max-h-0 opacity-0 overflow-hidden transition-all duration-500 ease-in-out group-hover:max-h-24 group-hover:opacity-100 group-hover:mt-2">
                            <p class="text-[13px] text-gray-200 line-clamp-3">
                                Jelajahi UNESCO Global Geopark dengan air terjun memukau dan pemandangan amfiteater alam yang luar biasa.
                            </p>
                        </div>
                    </div>
                </a>

                <!-- Card 2 -->
                <a href="#" class="group relative block h-80 overflow-hidden bg-gray-900 rounded-xl shadow-md cursor-pointer">
                    <span class="absolute top-4 left-0 bg-[#f9a826] text-gray-900 text-[12px] font-bold px-3 py-1 z-20 rounded-r-md shadow-sm">Top Rated</span>
                    <img alt="Situ Gunung" src="https://images.unsplash.com/photo-1610486001224-b0402b8552fc?q=80&w=640&h=480&fit=crop" class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute inset-x-0 bottom-0 p-5 z-10 flex flex-col justify-end">
                        <h3 class="text-xl font-bold text-white group-hover:underline decoration-2 underline-offset-4 transition-all duration-300">Situ Gunung</h3>
                        <div class="max-h-0 opacity-0 overflow-hidden transition-all duration-500 ease-in-out group-hover:max-h-24 group-hover:opacity-100 group-hover:mt-2">
                            <p class="text-[13px] text-gray-200 line-clamp-3">
                                Rasakan sensasi menyeberangi jembatan gantung terpanjang di Asia Tenggara di tengah sejuknya hutan pinus.
                            </p>
                        </div>
                    </div>
                </a>

                <!-- Card 3 -->
                <a href="#" class="group relative block h-80 overflow-hidden bg-gray-900 rounded-xl shadow-md cursor-pointer">
                    <span class="absolute top-4 left-0 bg-[#f9a826] text-gray-900 text-[12px] font-bold px-3 py-1 z-20 rounded-r-md shadow-sm">An itinerary essential</span>
                    <img alt="Pelabuhan Ratu" src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=640&h=480&fit=crop" class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute inset-x-0 bottom-0 p-5 z-10 flex flex-col justify-end">
                        <h3 class="text-xl font-bold text-white group-hover:underline decoration-2 underline-offset-4 transition-all duration-300">Pelabuhan Ratu</h3>
                        <div class="max-h-0 opacity-0 overflow-hidden transition-all duration-500 ease-in-out group-hover:max-h-24 group-hover:opacity-100 group-hover:mt-2">
                            <p class="text-[13px] text-gray-200 line-clamp-3">
                                Surga para peselancar dengan ombak legendaris pantai selatan dan panorama matahari terbenam yang magis.
                            </p>
                        </div>
                    </div>
                </a>

                <!-- Card 4 -->
                <a href="#" class="group relative block h-80 overflow-hidden bg-gray-900 rounded-xl shadow-md cursor-pointer">
                    <img alt="Curug Cikaso" src="https://images.unsplash.com/photo-1596404554311-66774e50ebec?q=80&w=640&h=480&fit=crop" class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute inset-x-0 bottom-0 p-5 z-10 flex flex-col justify-end">
                        <h3 class="text-xl font-bold text-white group-hover:underline decoration-2 underline-offset-4 transition-all duration-300">Curug Cikaso</h3>
                        <div class="max-h-0 opacity-0 overflow-hidden transition-all duration-500 ease-in-out group-hover:max-h-24 group-hover:opacity-100 group-hover:mt-2">
                            <p class="text-[13px] text-gray-200 line-clamp-3">
                                Pesona tiga air terjun berdampingan dengan kolam alami berwarna biru kehijauan yang sangat menyegarkan.
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- FIRST-TIME VISITOR CALLOUT -->
        <div class="bg-gray-50 py-16">
            <div class="max-w-6xl mx-auto px-6">
                <div class="relative bg-white border border-[#1a6bbf] rounded-tl-[3.5rem] rounded-br-[3.5rem] p-8 md:p-12 shadow-sm overflow-hidden flex flex-col md:flex-row gap-10">
                    
                    <!-- Decorative SVG Bottom Right -->
                    <div class="absolute bottom-0 right-8 text-[#1a6bbf] opacity-80 pointer-events-none hidden md:block">
                        <svg width="140" height="80" viewBox="0 0 140 80" fill="none" stroke="currentColor" stroke-width="1.5">
                            <!-- Mountain / Tree outlines to mimic the London taxi/trees -->
                            <path d="M100 80 L120 40 L140 80" stroke-linejoin="round" />
                            <path d="M110 80 L120 55 L130 80" stroke-linejoin="round" />
                            <path d="M70 80 L90 50 L110 80" stroke-linejoin="round" />
                            <path d="M20 80 L20 65 C20 50 40 50 40 65 L40 80" />
                            <path d="M15 65 L45 65" />
                            <circle cx="23" cy="72" r="3" />
                            <circle cx="37" cy="72" r="3" />
                            <path d="M25 57 L35 57" />
                        </svg>
                    </div>

                    <div class="flex-1 z-10">
                        <h2 class="text-4xl md:text-5xl font-black text-[#1a6bbf] mb-6 leading-tight">Pertama kali ke<br>Sukabumi?</h2>
                        <hr class="border-[#1a6bbf] border-t-2 w-16 mb-6"/>
                        <p class="text-[17px] text-gray-900 font-bold leading-relaxed">
                            Temukan panduan lengkap wisata Sukabumi... dari destinasi alam terbaik hingga kuliner, hotel, aktivitas seru, dan lainnya!
                        </p>
                    </div>
                    
                    <div class="flex-1 space-y-8 z-10">
                        <p class="text-[15px] text-gray-700 leading-relaxed">
                            Jika ini pertama kali kamu mengunjungi Sukabumi, panduan ini akan membantu perjalananmu menjadi aman, mudah, dan yang paling penting, menyenangkan! Jelajahi Sukabumi dengan mudah melalui informasi rute terbaru, panduan transportasi darat, dan tips wisata yang praktis.
                        </p>
                        <a href="#" class="inline-block px-10 py-3.5 text-[15px] font-bold text-white bg-[#1a6bbf] hover:bg-[#145299] rounded-full transition-colors shadow-md">
                            Pelajari lebih lanjut
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ANIMATED CATEGORY ICONS -->
        @php
        $categories = [
            ['name' => 'Wisata Alam',    'lottie' => asset('lottie/wisata-alam.json')],
            ['name' => 'Wisata Pantai',  'lottie' => asset('lottie/wisata-pantai.json')],
            ['name' => 'Kuliner Lokal',  'lottie' => asset('lottie/kuliner-lokal.json')],
            ['name' => 'Hotel & Resort', 'lottie' => asset('lottie/hotel-resort.json')],
        ];
        @endphp

        <div class="max-w-7xl mx-auto px-6 py-12">
            <h2 class="text-[22px] font-bold text-gray-900 mb-6">Butuh inspirasi aktivitas?</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @foreach($categories as $cat)
                    <a href="#" class="vs-cat-card group">
                        <div class="vs-cat-lottie">
                            <lottie-player src="{{ $cat['lottie'] }}" background="transparent" speed="1" style="width:100%;height:100%;" autoplay loop></lottie-player>
                        </div>
                        <h3 class="vs-cat-label">{{ $cat['name'] }}</h3>
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

@push('scripts')
<script>
    // Lottie category cards: always playing, no pause/stop behavior
</script>
@endpush
