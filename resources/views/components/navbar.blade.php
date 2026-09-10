@php
// Tentukan kategori yang sedang aktif
$currentCatSlug = request('category');
if (isset($place) && $place->category) {
    $currentCatSlug = $place->category->slug;
} elseif (isset($currentCategory) && $currentCategory) {
    $currentCatSlug = $currentCategory->slug;
}

$navItems = Cache::remember('dynamic_navbar_items', 3600, function () {
    $getTopPlaces = function(array $categorySlugs, $limit = 2) {
        return \App\Models\Place::whereHas('category', function($q) use ($categorySlugs) {
            $q->whereIn('slug', $categorySlugs);
        })->where('status', 'published')
          ->withCount('reviews')
          ->orderByDesc('reviews_count')
          ->take($limit)
          ->get();
    };

    $adrenalinPlaces = $getTopPlaces(['aktivitas-seru'], 2);
    $healingPlaces = $getTopPlaces(['wisata-alam', 'wisata-pantai'], 2);
    $budayaPlaces = $getTopPlaces(['wisata-budaya', 'kuliner'], 2);

    $mapPlacesToLinks = function($places, $allLabel, $allHref) {
        $links = [];
        foreach ($places as $place) {
            $links[] = [
                'label' => $place->name,
                'href' => '/place/' . $place->slug,
                'highlight' => false
            ];
        }
        $links[] = [
            'label' => $allLabel,
            'href' => $allHref,
            'highlight' => true
        ];
        return $links;
    };

    return [
        [
            'label'    => 'Pacu Adrenalin',
            'href'     => '/kategori/aktivitas-seru',
            'activeCategories' => ['aktivitas-seru'],
            'dropdown' => true,
            'intro'    => ['title' => 'Pacu Adrenalin', 'text' => 'Tantang diri Anda dengan aktivitas ekstrem dan petualangan seru di Sukabumi.'],
            'links'    => $mapPlacesToLinks($adrenalinPlaces, 'Semua Aktivitas Seru', '/kategori/aktivitas-seru'),
        ],
        [
            'label'    => 'Santai & Healing',
            'href'     => '/kategori/wisata-alam',
            'activeCategories' => ['wisata-alam', 'wisata-pantai'],
            'dropdown' => true,
            'intro'    => ['title' => 'Santai & Healing', 'text' => 'Lepaskan penat dan nikmati ketenangan alam yang asri di Sukabumi.'],
            'links'    => $mapPlacesToLinks($healingPlaces, 'Semua Wisata Alam', '/kategori/wisata-alam'),
        ],
        [
            'label'    => 'Budaya & Sejarah',
            'href'     => '/kategori/wisata-budaya',
            'activeCategories' => ['wisata-budaya', 'kuliner'],
            'dropdown' => true,
            'intro'    => ['title' => 'Budaya & Sejarah', 'text' => 'Kenali lebih dekat warisan budaya, sejarah, dan kuliner otentik Sukabumi.'],
            'links'    => $mapPlacesToLinks($budayaPlaces, 'Jelajah Budaya', '/kategori/wisata-budaya'),
        ],
        [
            'label'    => 'Tempat Menginap',
            'href'     => '/kategori/hotel-resort',
            'activeCategories' => ['hotel-resort'],
            'dropdown' => false,
        ],
        [
            'label'    => 'Event & Festival',
            'href'     => '/event',
            'activeOn' => 'event*',
            'dropdown' => false,
        ],
        [
            'label'    => 'Panduan Wisata',
            'href'     => '/information',
            'activeOn' => 'information*',
            'dropdown' => false,
        ],
    ];
});
@endphp

{{-- ════════════════════════════════════════════
     DESKTOP HEADER
     ════════════════════════════════════════════ --}}
<header class="bg-white sticky top-0 z-50">

    {{-- ── DESKTOP: Row 1 Brand bar ── --}}
    <div class="vs-brand-row hidden md:flex">
        {{-- Left: Language + Currency --}}
        <div class="flex items-center gap-3 z-10">
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
                        <button onclick="changeGTranslate('id', 'ID')" class="w-full text-left px-4 py-2 text-[13px] font-medium text-gray-700 hover:bg-gray-50 hover:text-[#1a6bbf] transition-colors">Indonesian</button>
                        <button onclick="changeGTranslate('en', 'EN')" class="w-full text-left px-4 py-2 text-[13px] font-medium text-gray-700 hover:bg-gray-50 hover:text-[#1a6bbf] transition-colors">English</button>
                        <button onclick="changeGTranslate('zh-CN', 'CN')" class="w-full text-left px-4 py-2 text-[13px] font-medium text-gray-700 hover:bg-gray-50 hover:text-[#1a6bbf] transition-colors">Chinese</button>
                        <button onclick="changeGTranslate('ja', 'JA')" class="w-full text-left px-4 py-2 text-[13px] font-medium text-gray-700 hover:bg-gray-50 hover:text-[#1a6bbf] transition-colors">Japanese</button>
                        <button onclick="changeGTranslate('ar', 'AR')" class="w-full text-left px-4 py-2 text-[13px] font-medium text-gray-700 hover:bg-gray-50 hover:text-[#1a6bbf] transition-colors">Arabic</button>
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
        <a href="/" class="absolute left-0 right-0 mx-auto w-fit flex items-center justify-center group py-2">
            <img src="{{ asset('images/logo.png') }}" alt="Visit Sukabumi" class="h-20 md:h-24 object-contain group-hover:opacity-90 transition-opacity drop-shadow-sm" />
        </a>

        {{-- Right: Search & Auth --}}
        <div class="flex items-center gap-4 z-10">
            <form class="flex items-center border border-gray-300 rounded-sm px-2.5 py-[5px] gap-2 focus-within:border-[#1a6bbf] transition-colors" action="/search">
                <input type="search" name="keywords" placeholder="Search" class="text-[13px] text-gray-700 bg-transparent outline-none w-[130px] placeholder-gray-400" />
                <button type="submit" class="text-gray-400 hover:text-[#1a6bbf] flex-shrink-0">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </form>

            @auth
                <div class="flex items-center gap-4 border-l border-gray-200 pl-4">
                    <span class="text-[13px] font-semibold text-gray-700">Hai, {{ explode(' ', Auth::user()->name)[0] }}</span>
                    <a href="{{ route('wishlist.index') }}" class="flex items-center gap-1 text-[13px] font-bold text-gray-600 hover:text-[#f9a826] transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        <span class="hidden md:inline">Wishlist</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-[13px] font-bold text-red-500 hover:underline">Logout</button>
                    </form>
                </div>
            @else
                <div class="flex items-center gap-3 border-l border-gray-200 pl-4">
                    <a href="{{ route('login') }}" class="text-[13px] font-bold text-[#1a6bbf] hover:underline">Log in</a>
                </div>
            @endauth
        </div>
    </div>

    {{-- ── DESKTOP: Row 2 Nav bar with megamenu ── --}}
    <div class="vs-nav-row hidden md:block">
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
    <div class="md:hidden flex items-center justify-between px-4 h-[76px] border-b border-gray-200 bg-white relative">

        {{-- Left: Hamburger --}}
        <button id="mobile-menu-btn" onclick="toggleMobileMenu()" class="flex items-center justify-center w-10 h-10 text-gray-700 hover:text-[#1a6bbf] transition-colors" aria-label="Menu">
            <svg id="hamburger-icon" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        {{-- Center: Logo --}}
        <a href="/" class="absolute left-0 right-0 mx-auto w-fit flex items-center justify-center">
            <img src="{{ asset('images/logo.png') }}" alt="Visit Sukabumi" class="h-14 object-contain drop-shadow-sm" />
        </a>

        {{-- Right: Search icon (toggle inline search) + Login --}}
        <div class="flex items-center gap-2">
            <button onclick="toggleMobileSearch()" class="flex items-center justify-center w-10 h-10 text-gray-700 hover:text-[#1a6bbf] transition-colors" aria-label="Search">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
            @auth
                <a href="{{ route('wishlist.index') }}" class="flex items-center justify-center w-10 h-10 text-gray-600 hover:text-[#f9a826] transition-colors">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </a>
            @else
                <a href="{{ route('login') }}" class="text-[13px] font-bold text-[#1a6bbf] px-3 py-1.5 border border-[#1a6bbf] rounded-full hover:bg-[#1a6bbf] hover:text-white transition-colors">
                    Log in
                </a>
            @endauth
        </div>
    </div>

    {{-- Mobile Search Bar (hidden by default) --}}
    <div id="mobile-search-bar" class="md:hidden hidden bg-white border-b border-gray-200 px-4 py-3">
        <form action="{{ route('place.index') }}" method="GET" class="flex items-center bg-gray-100 rounded-full px-4 py-2 gap-2">
            <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="q" placeholder="Cari destinasi, kuliner, hotel..." autofocus
                class="flex-1 bg-transparent text-sm text-gray-700 outline-none placeholder-gray-400"/>
            <button type="submit" class="text-[#1a6bbf] font-bold text-sm flex-shrink-0">Cari</button>
        </form>
    </div>
</header>

{{-- ════════════════════════════════════════════
     MOBILE DRAWER MENU (full-screen slide-in)
     ════════════════════════════════════════════ --}}
{{-- Overlay --}}
<div id="mobile-overlay" onclick="closeMobileMenu()" class="md:hidden fixed inset-0 bg-black/50 z-[999] hidden opacity-0 transition-opacity duration-300"></div>

{{-- Drawer --}}
<div id="mobile-drawer" class="md:hidden fixed top-0 left-0 h-full w-[85vw] max-w-sm bg-white z-[1000] shadow-2xl transform -translate-x-full transition-transform duration-300 ease-in-out flex flex-col">

    {{-- Drawer Header --}}
    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
        <img src="{{ asset('images/logo.png') }}" alt="Visit Sukabumi" class="h-9 object-contain" />
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
            <a href="{{ route('login') }}" class="text-sm font-bold text-[#1a6bbf] border border-[#1a6bbf] px-4 py-1.5 rounded-full hover:bg-[#1a6bbf] hover:text-white transition-colors">Log in</a>
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

        {{-- Extra links --}}
        @auth
            <div class="mt-2 border-t border-gray-100 pt-2">
                <a href="{{ route('wishlist.index') }}" class="flex items-center gap-3 px-5 py-3.5 text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-[#f9a826] transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    Wishlist Saya
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-5 py-3.5 text-sm font-bold text-red-500 hover:bg-red-50 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        @endauth
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
