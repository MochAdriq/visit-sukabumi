@php
// Tentukan kategori/tag yang sedang aktif
$currentCatSlug = request('category');
if (isset($place) && $place->category) {
    $currentCatSlug = $place->category->slug;
} elseif (isset($currentCategory) && $currentCategory) {
    $currentCatSlug = $currentCategory->slug;
}

// Tag aktif (dari URL saat ini)
$currentTagSlug = request()->route('tag') instanceof \App\Models\Tag
    ? request()->route('tag')->slug
    : null;

$navData = Cache::remember('navbar_v2_tags', 3600, function () {
    $activityTags = \App\Models\Tag::activity()->get();
    $wisataTags   = \App\Models\Tag::wisata()->get();
    return compact('activityTags', 'wisataTags');
});

$activityTags = $navData['activityTags'];
$wisataTags   = $navData['wisataTags'];

// Bagi activity tags: kiri (3 item) dan kanan (sisanya)
$activityLeft  = $activityTags->take(3);
$activityRight = $activityTags->skip(3);
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
            <a href="/search" class="text-gray-500 hover:text-[#1a6bbf] p-2 transition-colors">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </a>

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

            {{-- 1. Apa yang Bisa Dilakukan (Activity Tags - Megamenu) --}}
            <div class="vs-nav-item">
                <a href="{{ route('tag.show.activity', $activityTags->first()->slug ?? 'semua') }}" class="vs-nav-link {{ request()->is('aktivitas*') ? 'active' : '' }}">
                    Apa yang Bisa Dilakukan
                    <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="transition-transform duration-200">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>
                <div class="vs-megamenu !w-[600px] !left-1/2 !-translate-x-1/2">
                    <div class="p-6 grid grid-cols-2 gap-x-8 gap-y-4">
                        {{-- Kiri --}}
                        <div class="space-y-2">
                            @foreach($activityLeft as $tag)
                                <a href="{{ $tag->url }}" class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group">
                                    <div class="mt-0.5 text-gray-400 group-hover:text-[#00aa6c]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $tag->icon_svg !!}</svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-sm text-gray-900 group-hover:text-[#1a6bbf]">{{ $tag->name }}</div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        {{-- Kanan --}}
                        <div class="space-y-2">
                            @foreach($activityRight as $tag)
                                <a href="{{ $tag->url }}" class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group">
                                    <div class="mt-0.5 text-gray-400 group-hover:text-[#00aa6c]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $tag->icon_svg !!}</svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-sm text-gray-900 group-hover:text-[#1a6bbf]">{{ $tag->name }}</div>
                                    </div>
                                </a>
                            @endforeach
                            
                            <div class="pt-2 mt-2 border-t border-gray-100">
                                <a href="{{ route('tag.show.activity', $activityTags->first()->slug ?? 'semua') }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-50 transition-colors group">
                                    <div class="font-bold text-sm text-[#1a6bbf]">Semua Aktivitas &rarr;</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. Wisata (Wisata Tags - Dropdown) --}}
            <div class="vs-nav-item">
                <a href="{{ route('tag.show.wisata', $wisataTags->first()->slug ?? 'semua') }}" class="vs-nav-link {{ request()->is('wisata*') ? 'active' : '' }}">
                    Wisata
                    <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="transition-transform duration-200">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>
                <div class="absolute top-full left-0 mt-0 w-56 bg-white border border-gray-100 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                    <div class="py-2">
                        @foreach($wisataTags as $tag)
                            <a href="{{ $tag->url }}" class="block px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:text-[#1a6bbf] transition-colors">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- 3. Tempat Menginap --}}
            <a href="{{ route('penginapan.index') }}" class="vs-nav-link {{ request('type') == 'penginapan' ? 'active' : '' }}">
                Tempat Menginap
            </a>

            {{-- 4. Event & Festival --}}
            <a href="{{ route('event.index') }}" class="vs-nav-link {{ request()->is('event*') ? 'active' : '' }}">
                Event & Festival
            </a>

            {{-- 5. Seputar Sukabumi (Dropdown) --}}
            <div class="vs-nav-item">
                <a href="#" class="vs-nav-link {{ request()->is('information*') || request()->is('tentang*') ? 'active' : '' }}">
                    Seputar Sukabumi
                    <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="transition-transform duration-200">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>
                <div class="absolute top-full left-0 mt-0 w-48 bg-white border border-gray-100 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                    <div class="py-2">
                        <a href="{{ route('information.index') }}" class="block px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:text-[#1a6bbf] transition-colors">
                            Tentang Sukabumi
                        </a>
                        <span class="block px-4 py-2.5 text-sm font-semibold text-gray-400 cursor-not-allowed" title="Segera Hadir">
                            Blog / Artikel
                        </span>
                    </div>
                </div>
            </div>
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
            <button onclick="toggleMobileSearch()" class="flex items-center justify-center w-10 h-10 text-gray-700 hover:text-[#1a6bbf] transition-colors" aria-label="Search">
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

        {{-- 1. Apa yang Bisa Dilakukan (Accordion) --}}
        <div class="border-b border-gray-50">
            <button onclick="toggleAccordion('activity')" class="w-full flex items-center justify-between px-5 py-3.5 text-sm font-bold text-gray-900 hover:bg-gray-50 hover:text-[#1a6bbf] transition-colors text-left">
                <span>Apa yang Bisa Dilakukan</span>
                <svg id="acc-icon-activity" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div id="acc-panel-activity" class="hidden bg-gray-50 pb-2 pt-1">
                @foreach($activityTags as $tag)
                    <a href="{{ $tag->url }}" class="block px-8 py-2.5 text-sm text-gray-600 hover:text-[#1a6bbf] transition-colors">
                        {{ $tag->name }}
                    </a>
                @endforeach
                <a href="{{ route('tag.show.activity', $activityTags->first()->slug ?? 'semua') }}" class="block px-8 py-2.5 text-sm font-bold text-[#1a6bbf] hover:text-[#135a9e] transition-colors">
                    → Semua Aktivitas
                </a>
            </div>
        </div>

        {{-- 2. Wisata (Accordion) --}}
        <div class="border-b border-gray-50">
            <button onclick="toggleAccordion('wisata')" class="w-full flex items-center justify-between px-5 py-3.5 text-sm font-bold text-gray-900 hover:bg-gray-50 hover:text-[#1a6bbf] transition-colors text-left">
                <span>Wisata</span>
                <svg id="acc-icon-wisata" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div id="acc-panel-wisata" class="hidden bg-gray-50 pb-2 pt-1">
                @foreach($wisataTags as $tag)
                    <a href="{{ $tag->url }}" class="block px-8 py-2.5 text-sm text-gray-600 hover:text-[#1a6bbf] transition-colors">
                        {{ $tag->name }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- 3. Tempat Menginap --}}
        <a href="{{ route('penginapan.index') }}" class="flex items-center px-5 py-3.5 text-sm font-bold text-gray-900 hover:bg-gray-50 hover:text-[#1a6bbf] transition-colors border-b border-gray-50">
            Tempat Menginap
        </a>

        {{-- 4. Event & Festival --}}
        <a href="{{ route('event.index') }}" class="flex items-center px-5 py-3.5 text-sm font-bold text-gray-900 hover:bg-gray-50 hover:text-[#1a6bbf] transition-colors border-b border-gray-50">
            Event & Festival
        </a>

        {{-- 5. Seputar Sukabumi (Accordion) --}}
        <div class="border-b border-gray-50">
            <button onclick="toggleAccordion('seputar')" class="w-full flex items-center justify-between px-5 py-3.5 text-sm font-bold text-gray-900 hover:bg-gray-50 hover:text-[#1a6bbf] transition-colors text-left">
                <span>Seputar Sukabumi</span>
                <svg id="acc-icon-seputar" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div id="acc-panel-seputar" class="hidden bg-gray-50 pb-2 pt-1">
                <a href="{{ route('information.index') }}" class="block px-8 py-2.5 text-sm text-gray-600 hover:text-[#1a6bbf] transition-colors">
                    Tentang Sukabumi
                </a>
                <span class="block px-8 py-2.5 text-sm text-gray-400 cursor-not-allowed">
                    Blog / Artikel (Segera Hadir)
                </span>
            </div>
        </div>

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
    bar.classList.toggle('hidden');
    if (!bar.classList.contains('hidden')) {
        bar.querySelector('input').focus();
    }
}
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
