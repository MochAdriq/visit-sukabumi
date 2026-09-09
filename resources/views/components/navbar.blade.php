@php
// Tentukan kategori yang sedang aktif (baik dari URL parameter, atau dari halaman detail destinasi)
$currentCatSlug = request('category');
if (isset($place) && $place->category) {
    $currentCatSlug = $place->category->slug;
} elseif (isset($currentCategory) && $currentCategory) {
    $currentCatSlug = $currentCategory->slug;
}

$navItems = [
    [
        'label'    => 'Pacu Adrenalin',
        'href'     => '/kategori/aktivitas-seru',
        'activeCategories' => ['aktivitas-seru'],
        'dropdown' => true,
        'intro'    => ['title' => 'Pacu Adrenalin', 'text' => 'Tantang diri Anda dengan aktivitas ekstrem dan petualangan seru di Sukabumi.'],
        'links'    => [
            ['label' => 'Arung Jeram Citarik', 'href' => '/place/arung-jeram-sungai-citarik', 'highlight' => false],
            ['label' => 'Surfing & Ombak',      'href' => '/place/snorkeling-ujung-genteng',   'highlight' => false],
            ['label' => 'Semua Aktivitas Seru', 'href' => '/kategori/aktivitas-seru',    'highlight' => true],
        ],
    ],
    [
        'label'    => 'Santai & Healing',
        'href'     => '/kategori/wisata-alam',
        'activeCategories' => ['wisata-alam', 'wisata-pantai'],
        'dropdown' => true,
        'intro'    => ['title' => 'Santai & Healing', 'text' => 'Lepaskan penat dan nikmati ketenangan alam yang asri di Sukabumi.'],
        'links'    => [
            ['label' => 'Pesona Geopark Ciletuh', 'href' => '/place/geopark-ciletuh',            'highlight' => false],
            ['label' => 'Situ Gunung & Jembatan', 'href' => '/place/situ-gunung',                'highlight' => false],
            ['label' => 'Wisata Pantai',          'href' => '/kategori/wisata-pantai',     'highlight' => false],
            ['label' => 'Semua Wisata Alam',      'href' => '/kategori/wisata-alam',       'highlight' => true],
        ],
    ],
    [
        'label'    => 'Budaya & Sejarah',
        'href'     => '/kategori/wisata-budaya',
        'activeCategories' => ['wisata-budaya', 'kuliner'],
        'dropdown' => true,
        'intro'    => ['title' => 'Budaya & Sejarah', 'text' => 'Kenali lebih dekat warisan budaya, sejarah, dan kuliner otentik Sukabumi.'],
        'links'    => [
            ['label' => 'Kampung Adat',         'href' => '/kategori/wisata-budaya', 'highlight' => false],
            ['label' => 'Wisata Kuliner Lokal', 'href' => '/kategori/kuliner',       'highlight' => false],
            ['label' => 'Jelajah Budaya',       'href' => '/kategori/wisata-budaya', 'highlight' => true],
        ],
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
@endphp

<header class="bg-white sticky top-0 z-50">
    <!-- ── ROW 1: Brand bar ── -->
    <div class="vs-brand-row">
        <!-- Left: Language + Currency -->
        <div class="flex items-center gap-3 z-10">
            <!-- Language Dropdown with Google Translate -->
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

        <!-- Center: Brand — truly centered with absolute positioning -->
        <a href="/" class="absolute left-0 right-0 mx-auto w-fit flex items-center justify-center group py-2">
            <img src="{{ asset('images/logo.png') }}" alt="Visit Sukabumi" class="h-14 md:h-16 object-contain group-hover:opacity-90 transition-opacity drop-shadow-sm" />
        </a>

        <!-- Right: Search & Auth -->
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

    <!-- ── ROW 2: Nav bar with megamenu ── -->
    <div class="vs-nav-row">
        <nav class="max-w-7xl mx-auto px-6 w-full flex items-center justify-center">
            <!-- Home -->
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
</header>

<!-- Google Translate Widget (Hidden) & Custom Script -->
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
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
