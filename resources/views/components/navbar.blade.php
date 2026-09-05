@php
$navItems = [
    [
        'label' => 'Book tickets',
        'href' => '#',
        'dropdown' => false,
    ],
    [
        'label' => 'Destinations',
        'href' => '#',
        'dropdown' => true,
        'intro' => ['title' => 'Destinations', 'text' => 'Temukan destinasi wisata terbaik di Sukabumi, dari alam hingga kuliner.'],
        'links' => [
            ['label' => 'Geopark Ciletuh', 'href' => '#', 'highlight' => false],
            ['label' => 'Pelabuhan Ratu', 'href' => '#', 'highlight' => false],
            ['label' => 'Situ Gunung', 'href' => '#', 'highlight' => false],
            ['label' => 'Curug Cikaso', 'href' => '#', 'highlight' => false],
            ['label' => 'Pantai Ujung Genteng', 'href' => '#', 'highlight' => false],
            ['label' => 'Curug Luhur', 'href' => '#', 'highlight' => false],
            ['label' => 'Taman Nasional Gunung Halimun', 'href' => '#', 'highlight' => false],
            ['label' => 'Semua Destinasi', 'href' => '#', 'highlight' => true],
        ],
    ],
    [
        'label' => 'Things to do',
        'href' => '#',
        'dropdown' => true,
        'intro' => ['title' => 'Things to do', 'text' => 'Temukan aktivitas seru dan pengalaman tak terlupakan di Sukabumi.'],
        'links' => [
            ['label' => 'Wisata keluarga', 'href' => '#', 'highlight' => false],
            ['label' => 'Kuliner & minuman', 'href' => '#', 'highlight' => false],
            ['label' => 'Arung jeram', 'href' => '#', 'highlight' => false],
            ['label' => 'Diving & snorkeling', 'href' => '#', 'highlight' => false],
            ['label' => 'Hiking & trekking', 'href' => '#', 'highlight' => false],
            ['label' => 'Wisata sejarah', 'href' => '#', 'highlight' => false],
            ['label' => 'Belanja oleh-oleh', 'href' => '#', 'highlight' => false],
            ['label' => 'Semua aktivitas', 'href' => '#', 'highlight' => true],
        ],
    ],
    [
        'label' => 'Traveller information',
        'href' => '#',
        'dropdown' => true,
        'intro' => ['title' => 'Traveller information', 'text' => 'Panduan perjalanan lengkap untuk wisatawan Sukabumi.'],
        'links' => [
            ['label' => 'Cara ke Sukabumi', 'href' => '#', 'highlight' => false],
            ['label' => 'Transportasi lokal', 'href' => '#', 'highlight' => false],
            ['label' => 'Aksesibilitas', 'href' => '#', 'highlight' => false],
            ['label' => 'Cari hotel', 'href' => '#', 'highlight' => false],
            ['label' => 'Informasi penting', 'href' => '#', 'highlight' => false],
            ['label' => 'Semua info perjalanan', 'href' => '#', 'highlight' => true],
        ],
    ],
    [
        'label' => 'Accommodation',
        'href' => '#',
        'dropdown' => false,
    ],
    [
        'label' => 'Blog',
        'href' => '#',
        'dropdown' => false,
    ],
];
@endphp

<header class="bg-white sticky top-0 z-50">
    <!-- ── ROW 1: Brand bar ── -->
    <div class="vs-brand-row">
        <!-- Left: Language + Currency -->
        <div class="flex items-center gap-3 z-10">
            <button class="flex items-center gap-1 text-[13px] font-semibold text-gray-700 hover:text-[#1a6bbf] transition-colors">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9.5" stroke-width="1.5"/>
                    <path d="M2.5 12h19M12 2.5c-2.5 3-4 6-4 9.5s1.5 6.5 4 9.5M12 2.5c2.5 3 4 6 4 9.5s-1.5 6.5-4 9.5" stroke-width="1.3"/>
                </svg>
                <span>EN</span>
                <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <button class="flex items-center gap-1 text-[13px] font-semibold text-gray-700 hover:text-[#1a6bbf] transition-colors">
                <span>Rp&ensp;IDR</span>
                <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
        </div>

        <!-- Center: Brand — truly centered with absolute positioning -->
        <a href="/" class="absolute left-0 right-0 mx-auto w-fit flex flex-col items-center text-center group">
            <span class="font-black text-[30px] tracking-[0.06em] text-[#1a6bbf] uppercase leading-none group-hover:opacity-80 transition-opacity">
                Visit Sukabumi
            </span>
            <span class="text-[9px] font-bold tracking-[0.22em] text-gray-500 uppercase mt-[3px]">
                Official Visitor Guide
            </span>
        </a>

        <!-- Right: Search -->
        <form class="flex items-center border border-gray-300 rounded-sm px-2.5 py-[5px] gap-2 focus-within:border-[#1a6bbf] transition-colors z-10" action="/search">
            <input type="search" name="keywords" placeholder="Search" class="text-[13px] text-gray-700 bg-transparent outline-none w-[130px] placeholder-gray-400" />
            <button type="submit" class="text-gray-400 hover:text-[#1a6bbf] flex-shrink-0">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
        </form>
    </div>

    <!-- ── ROW 2: Nav bar with megamenu ── -->
    <div class="vs-nav-row">
        <nav class="max-w-7xl mx-auto px-6 w-full flex items-center justify-center">
            <!-- Home -->
            <a href="/" class="vs-nav-link vs-nav-link-home flex items-center justify-center">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </a>

            @foreach($navItems as $item)
                @if($item['dropdown'])
                    <div class="vs-nav-item relative">
                        <a href="{{ $item['href'] }}" class="vs-nav-link">
                            {{ $item['label'] }}
                            <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </a>
                        <div class="vs-megamenu">
                            <div class="vs-megamenu-inner">
                                <div class="vs-megamenu-sidebar">
                                    <div class="vs-megamenu-title">{{ $item['intro']['title'] }}</div>
                                    <div class="vs-megamenu-text">{{ $item['intro']['text'] }}</div>
                                </div>
                                <ul class="vs-megamenu-links">
                                    @foreach($item['links'] as $link)
                                        <li>
                                            <a href="{{ $link['href'] }}" class="{{ $link['highlight'] ? 'vs-highlight' : '' }}">
                                                {{ $link['label'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ $item['href'] }}" class="vs-nav-link">
                        {{ $item['label'] }}
                    </a>
                @endif
            @endforeach
        </nav>
    </div>
</header>
