@php
    $footerAd = \App\Models\Advertisement::getRandomAd('footer_banner');
@endphp

@if($footerAd)
    {{-- ════════════════════════════════════════════
         PRE-FOOTER SPONSOR BANNER
         ════════════════════════════════════════════ --}}
    <div class="bg-slate-50 py-6 sm:py-8 border-t border-slate-200">
        <div class="max-w-[1380px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-[970px] mx-auto">
                <div class="relative rounded-2xl overflow-hidden shadow-xs hover:shadow-md transition-shadow group border border-slate-200/80 bg-white">
                    <a href="{{ $footerAd->url ?? '#' }}" target="{{ ($footerAd->open_in_new_tab || (isset($footerAd->url) && str_starts_with($footerAd->url, 'http'))) ? '_blank' : '_self' }}" rel="noopener noreferrer" class="block w-full">
                        <img src="{{ $footerAd->image_url }}" alt="{{ $footerAd->title }}" class="w-full h-auto block rounded-2xl group-hover:scale-[1.01] transition-transform duration-300" />
                    </a>
                    <div class="absolute top-3 right-3 bg-black/75 backdrop-blur-xs text-white text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider pointer-events-none shadow-xs">
                        Sponsor Resmi
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<footer class="bg-white border-t border-gray-200 relative">
    {{-- Top Brand Bar with Continuous Smooth Left-to-Right Partner Logos Marquee --}}
    @php
        $partnerLogos = [
            ['name' => 'Bank Mandiri', 'src' => asset('images/partners/bank-mandiri.png'), 'h' => 'h-6 md:h-7'],
            ['name' => 'ASITA', 'src' => asset('images/partners/asita.png'), 'h' => 'h-8 md:h-9'],
            ['name' => 'Brightnest', 'src' => asset('images/partners/brightnest.png'), 'h' => 'h-7 md:h-8'],
            ['name' => 'Google Gemini', 'src' => asset('images/partners/gemini.png'), 'h' => 'h-7 md:h-8'],
            ['name' => 'Google', 'src' => asset('images/partners/google.png'), 'h' => 'h-7 md:h-8'],
            ['name' => 'Microsoft', 'src' => asset('images/partners/microsoft.png'), 'h' => 'h-5 md:h-6'],
        ];
        // Shuffle randomly per request so sorting is non-deterministic
        $shuffledLogos = collect($partnerLogos)->shuffle()->values();
        // Repeat 4x per group so one group is ~3800px wide, easily filling 4K / ultrawide displays
        $groupLogos = $shuffledLogos->concat($shuffledLogos)->concat($shuffledLogos)->concat($shuffledLogos);
    @endphp

    <style>
        @keyframes partnerMarqueeLtr {
            0% {
                transform: translate3d(-100%, 0, 0);
            }
            100% {
                transform: translate3d(0%, 0, 0);
            }
        }
        .partner-marquee-group {
            animation: partnerMarqueeLtr 55s linear infinite;
            will-change: transform;
        }
        .partner-marquee-container:hover .partner-marquee-group {
            animation-play-state: paused;
        }
    </style>

    {{-- Partner Logos Marquee (Pure 100% Full-Width Continuous Smooth Left-to-Right, No Fade Mask, No Gaps) --}}
    <div class="border-b border-gray-200 py-6 md:py-8 overflow-hidden bg-white w-full">
        <div class="partner-marquee-container flex overflow-hidden w-full select-none">
            @foreach([1, 2] as $groupIndex)
                <div class="partner-marquee-group flex shrink-0 items-center gap-12 md:gap-16 pr-12 md:pr-16" @if($groupIndex === 2) aria-hidden="true" @endif>
                    @foreach($groupLogos as $logo)
                        <div class="flex items-center justify-center shrink-0">
                            <img src="{{ $logo['src'] }}" alt="{{ $logo['name'] }}" class="{{ $logo['h'] }} max-w-[140px] md:max-w-[170px] object-contain select-none pointer-events-none opacity-100" loading="lazy" />
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    {{-- 4 Columns Navigation Grid --}}
    <div class="max-w-[1380px] mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-2 md:grid-cols-4 gap-8 border-b border-gray-200">
        {{-- 1. WISATA --}}
        <div>
            <h4 class="text-[11px] font-black uppercase tracking-widest text-gray-900 mb-4 pb-2 border-b border-gray-200">WISATA</h4>
            <ul class="space-y-2.5">
                @php
                    $wisataLinks = [
                        ['title' => 'Tempat wisata Sukabumi', 'url' => route('place.index')],
                        ['title' => 'Wisata alam', 'url' => route('place.index', ['search' => 'alam'])],
                        ['title' => 'Wisata pantai', 'url' => route('place.index', ['search' => 'pantai'])],
                        ['title' => 'Hiking & trekking', 'url' => route('place.index', ['search' => 'trekking'])],
                        ['title' => 'Arung jeram', 'url' => route('place.index', ['search' => 'arung jeram'])],
                        ['title' => 'Kuliner & makanan', 'url' => route('place.index', ['category' => 'kuliner'])],
                        ['title' => 'Belanja oleh-oleh', 'url' => route('place.index', ['search' => 'oleh-oleh'])],
                        ['title' => 'Penginapan', 'url' => route('penginapan.index')],
                    ];
                @endphp
                @foreach($wisataLinks as $l)
                <li><a href="{{ $l['url'] }}" class="text-[14px] md:text-[15px] text-gray-600 hover:text-[#1a6bbf] hover:underline transition">{{ $l['title'] }}</a></li>
                @endforeach
            </ul>
        </div>

        {{-- 2. DESTINASI POPULER --}}
        <div>
            <h4 class="text-xs font-black uppercase tracking-widest text-gray-900 mb-4 pb-2 border-b border-gray-200">DESTINASI POPULER</h4>
            <ul class="space-y-2.5">
                @php
                    $populerLinks = [
                        ['title' => 'Geopark Ciletuh', 'url' => route('place.index', ['search' => 'Geopark Ciletuh'])],
                        ['title' => 'Situ Gunung', 'url' => route('place.index', ['search' => 'Situ Gunung'])],
                        ['title' => 'Pelabuhan Ratu', 'url' => route('place.index', ['search' => 'Palabuhanratu'])],
                        ['title' => 'Curug Cikaso', 'url' => route('place.index', ['search' => 'Curug Cikaso'])],
                        ['title' => 'Curug Luhur', 'url' => route('place.index', ['search' => 'Curug Luhur'])],
                        ['title' => 'Pantai Ujung Genteng', 'url' => route('place.index', ['search' => 'Ujung Genteng'])],
                        ['title' => 'Taman Nasional Halimun', 'url' => route('place.index', ['search' => 'Halimun'])],
                        ['title' => 'Gunung Gede Pangrango', 'url' => route('place.index', ['search' => 'Gede Pangrango'])],
                    ];
                @endphp
                @foreach($populerLinks as $l)
                <li><a href="{{ $l['url'] }}" class="text-[14px] md:text-[15px] text-gray-600 hover:text-[#1a6bbf] hover:underline transition">{{ $l['title'] }}</a></li>
                @endforeach
            </ul>
        </div>

        {{-- 3. AKTIVITAS TERBAIK --}}
        <div>
            <h4 class="text-xs font-black uppercase tracking-widest text-gray-900 mb-4 pb-2 border-b border-gray-200">AKTIVITAS TERBAIK</h4>
            <ul class="space-y-2.5">
                @php
                    $aktivitasLinks = [
                        ['title' => 'Arung Jeram Citarik', 'url' => route('place.index', ['search' => 'Citarik'])],
                        ['title' => 'Jembatan Situ Gunung', 'url' => route('place.index', ['search' => 'Jembatan'])],
                        ['title' => 'Snorkeling Ujung Genteng', 'url' => route('place.index', ['search' => 'Snorkeling'])],
                        ['title' => 'Surfing Palabuhanratu', 'url' => route('place.index', ['search' => 'Surfing'])],
                        ['title' => 'Glamping Halimun', 'url' => route('place.index', ['search' => 'Glamping'])],
                        ['title' => 'Wisata Edukasi Geopark', 'url' => route('place.index', ['search' => 'Edukasi'])],
                        ['title' => 'Bersepeda Selabintana', 'url' => route('place.index', ['search' => 'Selabintana'])],
                        ['title' => 'Camping Curug', 'url' => route('place.index', ['search' => 'Camping'])],
                    ];
                @endphp
                @foreach($aktivitasLinks as $l)
                <li><a href="{{ $l['url'] }}" class="text-[14px] md:text-[15px] text-gray-600 hover:text-[#1a6bbf] hover:underline transition">{{ $l['title'] }}</a></li>
                @endforeach
            </ul>
        </div>

        {{-- 4. PANDUAN PERJALANAN --}}
        <div>
            <h4 class="text-xs font-black uppercase tracking-widest text-gray-900 mb-4 pb-2 border-b border-gray-200">PANDUAN PERJALANAN</h4>
            <ul class="space-y-2.5">
                @php
                    $panduanLinks = [
                        ['title' => 'Panduan lengkap wisata', 'url' => route('guide.index')],
                        ['title' => 'Cara ke Sukabumi (Rute)', 'url' => route('guide.index') . '#rute-transportasi'],
                        ['title' => 'Galeri Video Wisata', 'url' => route('blog.index', ['category' => 'Video'])],
                        ['title' => 'Rekomendasi Itinerary', 'url' => route('guide.index') . '#itinerary-rekomendasi'],
                        ['title' => 'Tips keselamatan pantai', 'url' => route('guide.index') . '#keselamatan-pantai'],
                        ['title' => 'Hotel & penginapan', 'url' => route('penginapan.index')],
                        ['title' => 'Paket wisata', 'url' => route('place.index', ['search' => 'paket'])],
                        ['title' => 'Kontak darurat', 'url' => route('guide.index') . '#kontak-darurat'],
                        ['title' => 'Tentang Sukabumi', 'url' => route('information.index')],
                    ];
                @endphp
                @foreach($panduanLinks as $l)
                <li><a href="{{ $l['url'] }}" class="text-[14px] md:text-[15px] text-gray-600 hover:text-[#1a6bbf] hover:underline transition">{{ $l['title'] }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Bottom Blue Official Bar --}}
    <div class="bg-[#1a6bbf]">
        <div class="max-w-[1380px] mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ url('/') }}" class="bg-white px-3 py-1.5 rounded-xl shadow-sm block">
                    <img src="{{ asset('images/logo-v2.png') }}" alt="Visit Sukabumi" class="h-8 md:h-10 object-contain" />
                </a>
                <span class="block text-blue-100 text-[12px] md:text-[13px] font-medium leading-snug">
                    Didukung oleh Dinas Pariwisata<br class="hidden md:block"/> Kabupaten Sukabumi
                </span>
            </div>
            
            {{-- Official & Legal Links + Cookie Preferences Trigger --}}
            <div class="flex flex-wrap items-center gap-x-6 gap-y-2">
                <a href="{{ route('legal.show', 'hubungi-kami') }}" class="text-blue-100 hover:text-white text-[13px] md:text-[14px] font-medium transition">Hubungi Kami</a>
                <a href="{{ route('legal.show', 'tentang-kami') }}" class="text-blue-100 hover:text-white text-[13px] md:text-[14px] font-medium transition">Tentang Kami</a>
                <a href="{{ route('legal.show', 'kebijakan-privasi') }}" class="text-blue-100 hover:text-white text-[13px] md:text-[14px] font-medium transition">Kebijakan Privasi</a>
                <a href="{{ route('legal.show', 'aksesibilitas') }}" class="text-blue-100 hover:text-white text-[13px] md:text-[14px] font-medium transition">Aksesibilitas</a>
                <a href="{{ route('legal.show', 'syarat-ketentuan') }}" class="text-blue-100 hover:text-white text-[13px] md:text-[14px] font-medium transition">Syarat & Ketentuan</a>
            </div>
        </div>
        <div class="max-w-[1380px] mx-auto px-4 sm:px-6 lg:px-8 pb-5">
            <p class="text-blue-200 text-[12px] md:text-[13px] leading-relaxed max-w-3xl">Visit Sukabumi adalah platform panduan wisata resmi untuk Kabupaten dan Kota Sukabumi. Kami mendukung pariwisata lokal dan UMKM.</p>
        </div>
    </div>

    {{-- Include Cookie Consent Component --}}
    @include('components.cookie-consent')
</footer>
