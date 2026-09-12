<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php
        $pageTitle = trim($__env->yieldContent('title'));
        $defaultTitle = 'Visit Sukabumi — Panduan Wisata Kabupaten Sukabumi';
        $metaTitle = $pageTitle ?: $defaultTitle;

        $pageDesc = trim($__env->yieldContent('meta_description'));
        $defaultDesc = 'Temukan destinasi wisata, event, penginapan, dan kuliner terbaik di Kabupaten Sukabumi. Panduan perjalanan lengkap dari Visit Sukabumi.';
        $metaDesc = $pageDesc ?: $defaultDesc;

        $ogTitle = trim($__env->yieldContent('og_title')) ?: $metaTitle;
        $ogDesc  = trim($__env->yieldContent('og_description')) ?: $metaDesc;
        $ogImage = trim($__env->yieldContent('og_image')) ?: asset('assets/images/og-default.jpg');
        $ogUrl   = trim($__env->yieldContent('canonical')) ?: url()->current();
    @endphp

    {{-- ══ SEO: Title & Meta Dasar ══ --}}
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDesc }}">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    <link rel="canonical" href="{{ $ogUrl }}">

    {{-- ══ Open Graph (WhatsApp, Facebook, Telegram, LinkedIn) ══ --}}
    <meta property="og:site_name"   content="Visit Sukabumi">
    <meta property="og:locale"      content="id_ID">
    <meta property="og:type"        content="@yield('og_type', 'website')">
    <meta property="og:title"       content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDesc }}">
    <meta property="og:url"         content="{{ $ogUrl }}">
    <meta property="og:image"       content="{{ $ogImage }}">
    <meta property="og:image:width"  content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt"   content="@yield('og_image_alt', 'Visit Sukabumi')">

    {{-- ══ Twitter / X Card ══ --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:site"        content="@visitsukabumi">
    <meta name="twitter:title"       content="{{ $ogTitle }}">
    <meta name="twitter:description" content="{{ $ogDesc }}">
    <meta name="twitter:image"       content="{{ $ogImage }}">

    {{-- ══ Structured Data / JSON-LD (per-halaman) ══ --}}
    @stack('structured_data')

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,700,900" rel="stylesheet"/>

    {{-- Lottie Player --}}
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- GLightbox CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css"/>

    {{-- Vite CSS --}}
    @vite(['resources/css/app.css'])
</head>
<body class="antialiased">
    @yield('content')

    {{-- GLightbox JS --}}
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const lightbox = GLightbox({
                selector: '.glightbox',
                touchNavigation: true,
                loop: true,
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
