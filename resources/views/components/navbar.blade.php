@php
// Tentukan kategori yang sedang aktif
$currentCatSlug = request('category');
if (isset($place) && $place->category) {
    $currentCatSlug = $place->category->slug;
} elseif (isset($currentCategory) && $currentCategory) {
    $currentCatSlug = $currentCategory->slug;
}

$navItems = [
        [
            'label'    => 'Apa yang Bisa Dilakukan',
            'href'     => '/aktivitas',
            'activeOn' => 'aktivitas*',
            'dropdown' => true,
            'intro'    => ['title' => 'Aktivitas', 'text' => 'Berbagai kegiatan seru dan menantang untuk mengisi liburan Anda di Sukabumi.'],
            'links'    => [
                ['label' => 'Pacu Adrenalin', 'href' => '/aktivitas/pacu-adrenalin', 'highlight' => false],
                ['label' => 'Hiking & Trekking', 'href' => '/aktivitas/hiking-trekking', 'highlight' => false],
                ['label' => 'Sukabumi untuk Anak', 'href' => '/aktivitas/sukabumi-untuk-anak', 'highlight' => false],
                ['label' => 'Kuliner dan Makanan', 'href' => '/aktivitas/kuliner-makanan', 'highlight' => false],
                ['label' => 'Budaya dan Sejarah', 'href' => '/aktivitas/budaya-sejarah', 'highlight' => false],
                ['label' => 'Santai dan Healing', 'href' => '/aktivitas/santai-healing', 'highlight' => false],
                ['label' => 'Pendidikan dan Edu Wisata', 'href' => '/aktivitas/eduwisata', 'highlight' => false],
                ['label' => 'Belanja Oleh Oleh', 'href' => '/aktivitas/belanja-oleh-oleh', 'highlight' => false],
                ['label' => 'Semua yang dapat dilakukan', 'href' => '/aktivitas', 'highlight' => true],
            ],
        ],
        [
            'label'    => 'Wisata',
            'href'     => '/wisata',
            'activeOn' => 'wisata*',
            'dropdown' => true,
            'intro'    => ['title' => 'Wisata', 'text' => 'Eksplorasi destinasi memukau dari pegunungan hingga pantai selatan.'],
            'links'    => [
                ['label' => 'Wisata Alam', 'href' => '/wisata/wisata-alam', 'highlight' => false],
                ['label' => 'Wisata Pantai', 'href' => '/wisata/wisata-pantai', 'highlight' => false],
                ['label' => 'Wisata Spiritual', 'href' => '/wisata/wisata-spiritual', 'highlight' => false],
                ['label' => 'Semua Wisata', 'href' => '/wisata', 'highlight' => true],
            ],
        ],
        [
            'label'    => 'Tempat Menginap',
            'href'     => '/penginapan',
            'activeOn' => 'penginapan*',
            'dropdown' => false,
        ],
        [
            'label'    => 'Event & Festival',
            'href'     => '/event',
            'activeOn' => 'event*',
            'dropdown' => false,
        ],
        [
            'label'    => 'Seputar Sukabumi',
            'href'     => '#',
            'activeOn' => ['information*', 'panduan-wisata*'],
            'dropdown' => true,
            'intro'    => ['title' => 'Seputar Sukabumi', 'text' => 'Panduan lengkap, informasi sejarah, serta ulasan artikel blog.'],
            'links'    => [
                ['label' => 'Tentang Sukabumi', 'href' => '/information', 'highlight' => false],
                ['label' => 'Panduan Wisata', 'href' => '/panduan-wisata', 'highlight' => false],
                ['label' => 'Blog / Artikel', 'href' => '/blog', 'highlight' => false],
            ],
        ],
    ];
@endphp

{{-- ════════════════════════════════════════════
     DESKTOP HEADER
     ════════════════════════════════════════════ --}}
<header class="bg-white relative z-[60]">

    {{-- ── DESKTOP: Row 1 Brand bar ── --}}
    <div class="vs-brand-row hidden md:flex relative">
        {{-- Left: Language + Currency --}}
        <div class="flex items-center gap-3 z-10 flex-1">
            <div class="relative group z-50">
                <button class="flex items-center gap-1 text-[13px] font-semibold text-gray-700 hover:text-[#1a6bbf] transition-colors py-2">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9.5" stroke-width="1.5"/>
                        <path d="M2.5 12h19M12 2.5c-2.5 3-4 6-4 9.5s1.5 6.5 4 9.5M12 2.5c2.5 3 4 6 4 9.5s-1.5 6.5-4 9.5" stroke-width="1.3"/>
                    </svg>
                    <span id="current-lang">ID</span>
                    <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="absolute left-0 top-full mt-0 w-36 bg-white border border-gray-100 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all">
                    <div class="py-1">
                        <button onclick="changeGTranslate('id', 'ID')" class="w-full text-left px-4 py-2 text-[13px] font-medium text-gray-700 hover:bg-gray-50 hover:text-[#1a6bbf] transition-colors">Indonesia</button>
                        <button onclick="changeGTranslate('en', 'EN')" class="w-full text-left px-4 py-2 text-[13px] font-medium text-gray-700 hover:bg-gray-50 hover:text-[#1a6bbf] transition-colors">Inggris</button>
                        <button onclick="changeGTranslate('zh-CN', 'CN')" class="w-full text-left px-4 py-2 text-[13px] font-medium text-gray-700 hover:bg-gray-50 hover:text-[#1a6bbf] transition-colors">Mandarin</button>
                        <button onclick="changeGTranslate('ja', 'JA')" class="w-full text-left px-4 py-2 text-[13px] font-medium text-gray-700 hover:bg-gray-50 hover:text-[#1a6bbf] transition-colors">Jepang</button>
                        <button onclick="changeGTranslate('ar', 'AR')" class="w-full text-left px-4 py-2 text-[13px] font-medium text-gray-700 hover:bg-gray-50 hover:text-[#1a6bbf] transition-colors">Arab</button>
                    </div>
                </div>
            </div>
            <button class="flex items-center gap-1 text-[13px] font-semibold text-gray-700 hover:text-[#1a6bbf] transition-colors">
                <span>Rp&ensp;IDR</span>
                <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
        </div>

        {{-- Center: Brand --}}
        <a href="/" class="flex justify-center group px-4 flex-shrink-0">
            <img src="{{ asset('images/logo.png') }}" alt="Visit Sukabumi" class="max-h-[80px] md:max-h-[100px] w-auto object-contain group-hover:opacity-90 transition-opacity drop-shadow-sm" />
        </a>

        {{-- Right: Search & Auth --}}
        <div class="flex items-center gap-4 z-10 justify-end flex-1">
            <button type="button" onclick="openSearchModal()" class="text-gray-500 hover:text-[#1a6bbf] p-2 transition-colors cursor-pointer" aria-label="Buka Pencarian" title="Pencarian">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>

            @auth
                <div class="flex items-center gap-4 border-l border-gray-200 pl-4">
                    <span class="text-[13px] font-semibold text-gray-700 hidden lg:inline">Hai, {{ explode(' ', Auth::user()->name)[0] }}</span>
                    <a href="{{ route('wishlist.index') }}" class="flex items-center gap-1 text-[13px] font-bold text-gray-600 hover:text-[#f9a826] transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        <span class="hidden md:inline">Wishlist</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-[13px] font-bold text-red-500 hover:underline">Keluar</button>
                    </form>
                </div>
            @else
                <div class="flex items-center gap-3 border-l border-gray-200 pl-4">
                    <a href="{{ route('login') }}" class="text-[13px] font-bold text-[#1a6bbf] hover:underline">Masuk</a>
                </div>
            @endauth
        </div>
    </div>
</header>

    {{-- ── DESKTOP: Row 2 Nav bar with megamenu ── --}}
    <div class="vs-nav-row hidden md:block sticky top-0 z-50 bg-white shadow-sm border-b border-gray-100">
        <nav class="max-w-7xl mx-auto px-6 w-full flex items-center justify-center">
            <a href="/" class="vs-nav-link vs-nav-link-home flex items-center justify-center {{ request()->is('/') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </a>

            @foreach($navItems as $item)
                @php
                    $isActive = false;
                    if (isset($item['activeCategories'])) {
                        $isActive = request()->is('place*') && in_array($currentCatSlug, $item['activeCategories']);
                    } elseif (isset($item['activeOn'])) {
                        $isActive = request()->is($item['activeOn']);
                    } else {
                        $isActive = $item['href'] !== '#' && request()->is(ltrim($item['href'], '/'));
                    }
                @endphp
                @if($item['dropdown'])
                    <div class="vs-nav-item">
                        <a href="{{ $item['href'] }}" class="vs-nav-link {{ $isActive ? 'active' : '' }}">
                            {{ $item['label'] }}
                            <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="transition-transform duration-200">
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
                    <a href="{{ $item['href'] }}" class="vs-nav-link {{ $isActive ? 'active' : '' }}">
                        {{ $item['label'] }}
                    </a>
                @endif
            @endforeach
        </nav>
    </div>

    {{-- ════════════════════════════════════════════
         MOBILE NAVBAR — ☰ Logo Search style
         ════════════════════════════════════════════ --}}
<div class="md:hidden sticky top-0 z-50 shadow-sm">
    <div class="flex items-center justify-between px-4 h-[120px] border-b border-gray-200 bg-white relative overflow-hidden">

        {{-- Left: Hamburger --}}
        <button id="mobile-menu-btn" onclick="toggleMobileMenu()" class="flex items-center justify-center w-10 h-10 text-gray-700 hover:text-[#1a6bbf] transition-colors z-10" aria-label="Menu">
            <svg id="hamburger-icon" width="26" height="26" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        {{-- Center: Logo --}}
        <a href="/" class="absolute inset-y-0 left-0 right-0 mx-auto w-fit flex items-center justify-center">
            <img src="{{ asset('images/logo.png') }}" alt="Visit Sukabumi" class="h-[100px] max-w-[260px] object-contain drop-shadow-sm" />
        </a>

        {{-- Right: Search icon only --}}
        <div class="flex items-center z-10">
            <button type="button" onclick="openSearchModal()" class="flex items-center justify-center w-10 h-10 text-gray-700 hover:text-[#1a6bbf] transition-colors cursor-pointer" aria-label="Search">
                <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Search Bar (hidden by default) --}}
    <div id="mobile-search-bar" class="hidden bg-white border-b border-gray-200 px-4 py-3">
        <form action="{{ route('place.index') }}" method="GET" class="flex items-center bg-gray-100 rounded-full px-4 py-2 gap-2">
            <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="q" placeholder="Cari destinasi, kuliner, hotel..." autofocus
                class="flex-1 bg-transparent text-sm text-gray-700 outline-none placeholder-gray-400"/>
            <button type="submit" class="text-[#1a6bbf] font-bold text-sm flex-shrink-0">Cari</button>
        </form>
    </div>
</div>

{{-- ════════════════════════════════════════════
     MOBILE DRAWER MENU (full-screen slide-in)
     ════════════════════════════════════════════ --}}
{{-- Overlay --}}
<div id="mobile-overlay" onclick="closeMobileMenu()" class="md:hidden fixed inset-0 bg-black/50 z-[999] hidden opacity-0 transition-opacity duration-300"></div>

{{-- Drawer --}}
<div id="mobile-drawer" class="md:hidden fixed top-0 left-0 h-full w-[85vw] max-w-sm bg-white z-[1000] shadow-2xl transform -translate-x-full transition-transform duration-300 ease-in-out flex flex-col">
        
{{-- Drawer Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <img src="{{ asset('images/logo.png') }}" alt="Visit Sukabumi" class="h-14 object-contain" />
        <button onclick="closeMobileMenu()" class="text-gray-500 hover:text-gray-900 p-1">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Auth Banner --}}
    @auth
        <div class="px-5 py-4 bg-[#f0f7ff] border-b border-blue-100">
            <p class="text-sm text-gray-500">Halo,</p>
            <p class="font-bold text-gray-900">{{ Auth::user()->name }}</p>
        </div>
    @else
        <div class="px-5 py-4 bg-[#f0f7ff] border-b border-blue-100 flex items-center justify-between">
            <p class="text-sm text-gray-600">Masuk untuk akses penuh</p>
            <a href="{{ route('login') }}" class="text-sm font-bold text-[#1a6bbf] border border-[#1a6bbf] px-4 py-1.5 rounded-full hover:bg-[#1a6bbf] hover:text-white transition-colors">Masuk</a>
        </div>
    @endauth

    {{-- Nav Links --}}
    <nav class="flex-1 overflow-y-auto py-2">
        <a href="/" class="flex items-center gap-3 px-5 py-3.5 text-sm font-bold text-gray-900 hover:bg-gray-50 hover:text-[#1a6bbf] transition-colors border-b border-gray-50 {{ request()->is('/') ? 'text-[#1a6bbf]' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Beranda
        </a>

        @foreach($navItems as $idx => $item)
            @if($item['dropdown'])
                {{-- Accordion item --}}
                <div class="border-b border-gray-50">
                    <button onclick="toggleAccordion({{ $idx }})"
                        class="w-full flex items-center justify-between px-5 py-3.5 text-sm font-bold text-gray-900 hover:bg-gray-50 hover:text-[#1a6bbf] transition-colors text-left">
                        <span>{{ $item['label'] }}</span>
                        <svg id="acc-icon-{{ $idx }}" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="acc-panel-{{ $idx }}" class="hidden bg-gray-50 pb-1">
                        @foreach($item['links'] as $link)
                            <a href="{{ $link['href'] }}"
                                class="block px-8 py-2.5 text-sm {{ $link['highlight'] ? 'font-bold text-[#1a6bbf]' : 'text-gray-600' }} hover:text-[#1a6bbf] transition-colors">
                                @if($link['highlight'])
                                    → {{ $link['label'] }}
                                @else
                                    {{ $link['label'] }}
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                <a href="{{ $item['href'] }}" class="flex items-center px-5 py-3.5 text-sm font-bold text-gray-900 hover:bg-gray-50 hover:text-[#1a6bbf] transition-colors border-b border-gray-50">
                    {{ $item['label'] }}
                </a>
            @endif
        @endforeach

        {{-- Wishlist & User actions --}}
        <div class="mt-2 border-t border-gray-100 pt-1">
            <a href="{{ route('wishlist.index') }}" class="flex items-center gap-3 px-5 py-3.5 text-sm font-bold text-gray-800 hover:bg-gray-50 hover:text-[#f9a826] transition-colors">
                <svg class="w-5 h-5 text-[#f9a826]" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                Wishlist Saya
            </a>
            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-5 py-3.5 text-sm font-bold text-red-500 hover:bg-red-50 transition-colors text-left">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Keluar
                    </button>
                </form>
            @endauth
        </div>
    </nav>

    {{-- Footer --}}
    <div class="px-5 py-4 border-t border-gray-100">
        <p class="text-xs text-gray-400 text-center">© {{ date('Y') }} Visit Sukabumi</p>
    </div>
</div>

{{-- ════════════════════════════════════════════
     GLOBAL SEARCH MODAL (Desktop & Mobile)
     ════════════════════════════════════════════ --}}
<div id="search-modal" style="display: none; position: fixed; inset: 0; z-index: 99999;" class="items-center justify-center p-4">
    {{-- Backdrop --}}
    <div id="search-modal-backdrop" onclick="closeSearchModal()" style="position: fixed; inset: 0; z-index: 1;" class="bg-black/70 backdrop-blur-sm transition-opacity duration-300 opacity-0"></div>

    {{-- Modal Content Card --}}
    <div id="search-modal-box" onclick="event.stopPropagation()" style="position: relative; z-index: 2;" class="w-full max-w-2xl bg-white rounded-2xl shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 border border-gray-100 my-auto">
        {{-- Search Input Form --}}
        <form action="{{ route('place.index') }}" method="GET" class="p-4 md:p-6 border-b border-gray-100">
            <div class="flex items-center gap-3 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus-within:border-[#1a6bbf] focus-within:ring-2 focus-within:ring-[#1a6bbf]/20 transition-all">
                <svg class="w-6 h-6 text-[#1a6bbf] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="global-search-input" name="q" placeholder="Cari destinasi, wisata, pantai, hotel, kuliner..." class="w-full bg-transparent text-gray-800 text-base md:text-lg font-medium outline-none placeholder-gray-400 border-none focus:ring-0 p-0" autocomplete="off" />
                <button type="button" onclick="closeSearchModal()" class="text-gray-400 hover:text-gray-600 p-1 transition-colors cursor-pointer" title="Tutup">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="flex items-center justify-between mt-3 text-xs text-gray-500">
                <span>Tekan <kbd class="px-1.5 py-0.5 bg-gray-100 border border-gray-200 rounded text-[10px] font-semibold text-gray-700">Enter</kbd> untuk mencari</span>
                <span class="hidden sm:inline">Tekan <kbd class="px-1.5 py-0.5 bg-gray-100 border border-gray-200 rounded text-[10px] font-semibold text-gray-700">Esc</kbd> untuk menutup</span>
            </div>
        </form>

        {{-- Quick Suggested Keywords --}}
        <div class="px-4 md:px-6 py-4 bg-gray-50/70">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2.5">Pencarian Populer:</p>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('place.index', ['q' => 'Pantai']) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white border border-gray-200 text-xs font-semibold text-gray-700 hover:border-[#1a6bbf] hover:text-[#1a6bbf] hover:bg-blue-50/50 transition-all shadow-sm">
                    <svg class="w-3.5 h-3.5 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Wisata Pantai
                </a>
                <a href="{{ route('place.index', ['q' => 'Curug']) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white border border-gray-200 text-xs font-semibold text-gray-700 hover:border-[#1a6bbf] hover:text-[#1a6bbf] hover:bg-blue-50/50 transition-all shadow-sm">
                    <svg class="w-3.5 h-3.5 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l7 4 7-4M5 3v10l7 4 7-4V3"/></svg>
                    Curug & Air Terjun
                </a>
                <a href="{{ route('place.index', ['type' => 'penginapan']) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white border border-gray-200 text-xs font-semibold text-gray-700 hover:border-[#1a6bbf] hover:text-[#1a6bbf] hover:bg-blue-50/50 transition-all shadow-sm">
                    <svg class="w-3.5 h-3.5 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Hotel & Penginapan
                </a>
                <a href="{{ route('place.index', ['q' => 'Kuliner']) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white border border-gray-200 text-xs font-semibold text-gray-700 hover:border-[#1a6bbf] hover:text-[#1a6bbf] hover:bg-blue-50/50 transition-all shadow-sm">
                    <svg class="w-3.5 h-3.5 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Kuliner Khas
                </a>
                <a href="{{ route('place.index', ['q' => 'Palabuhanratu']) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white border border-gray-200 text-xs font-semibold text-gray-700 hover:border-[#1a6bbf] hover:text-[#1a6bbf] hover:bg-blue-50/50 transition-all shadow-sm">
                    <svg class="w-3.5 h-3.5 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Palabuhanratu
                </a>
                <a href="{{ route('place.index', ['q' => 'Ciletuh']) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white border border-gray-200 text-xs font-semibold text-gray-700 hover:border-[#1a6bbf] hover:text-[#1a6bbf] hover:bg-blue-50/50 transition-all shadow-sm">
                    <svg class="w-3.5 h-3.5 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                    Geopark Ciletuh
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Google Translate Widget (Hidden) --}}
<div id="google_translate_element" style="display:none;"></div>
<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'id', autoDisplay: false}, 'google_translate_element');
}

function changeGTranslate(langCode, langLabel) {
    var teCombo = document.querySelector('.goog-te-combo');
    if (teCombo) {
        teCombo.value = langCode;
        teCombo.dispatchEvent(new Event('change'));
        document.getElementById('current-lang').innerText = langLabel;
    }
}

// ── MOBILE MENU ──────────────────────────────────────
function toggleMobileMenu() {
    const drawer = document.getElementById('mobile-drawer');
    const overlay = document.getElementById('mobile-overlay');
    if (drawer.classList.contains('-translate-x-full')) {
        openMobileMenu();
    } else {
        closeMobileMenu();
    }
}

function openMobileMenu() {
    const drawer = document.getElementById('mobile-drawer');
    const overlay = document.getElementById('mobile-overlay');
    overlay.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    requestAnimationFrame(() => {
        overlay.classList.remove('opacity-0');
        overlay.classList.add('opacity-100');
        drawer.classList.remove('-translate-x-full');
        drawer.classList.add('translate-x-0');
    });
}

function closeMobileMenu() {
    const drawer = document.getElementById('mobile-drawer');
    const overlay = document.getElementById('mobile-overlay');
    drawer.classList.add('-translate-x-full');
    drawer.classList.remove('translate-x-0');
    overlay.classList.remove('opacity-100');
    overlay.classList.add('opacity-0');
    document.body.style.overflow = '';
    setTimeout(() => overlay.classList.add('hidden'), 300);
}

function toggleAccordion(idx) {
    const panel = document.getElementById('acc-panel-' + idx);
    const icon = document.getElementById('acc-icon-' + idx);
    if (panel.classList.contains('hidden')) {
        panel.classList.remove('hidden');
        icon.classList.add('rotate-180');
    } else {
        panel.classList.add('hidden');
        icon.classList.remove('rotate-180');
    }
}

function toggleMobileSearch() {
    const bar = document.getElementById('mobile-search-bar');
    if (bar) {
        bar.classList.toggle('hidden');
        if (!bar.classList.contains('hidden')) {
            bar.querySelector('input').focus();
        }
    }
}

// ── GLOBAL SEARCH MODAL ──────────────────────────────
function openSearchModal() {
    const modal = document.getElementById('search-modal');
    const backdrop = document.getElementById('search-modal-backdrop');
    const box = document.getElementById('search-modal-box');
    const input = document.getElementById('global-search-input');

    if (!modal) return;
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    setTimeout(() => {
        if (backdrop) {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
        }
        if (box) {
            box.classList.remove('scale-95', 'opacity-0');
            box.classList.add('scale-100', 'opacity-100');
        }
        if (input) input.focus();
    }, 20);
}

function closeSearchModal() {
    const modal = document.getElementById('search-modal');
    const backdrop = document.getElementById('search-modal-backdrop');
    const box = document.getElementById('search-modal-box');

    if (!modal) return;
    if (backdrop) {
        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
    }
    if (box) {
        box.classList.remove('scale-100', 'opacity-100');
        box.classList.add('scale-95', 'opacity-0');
    }
    document.body.style.overflow = '';

    setTimeout(() => {
        modal.style.display = 'none';
    }, 250);
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('search-modal');
        if (modal && modal.style.display === 'flex') {
            closeSearchModal();
        }
    }
});
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
