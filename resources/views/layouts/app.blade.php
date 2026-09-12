<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- ══ SEO: Title & Meta Dasar ══ --}}
    @hasSection('title')
        <title>@yield('title')</title>
    @else
        <title>Visit Sukabumi — Panduan Wisata Kabupaten Sukabumi</title>
    @endif

    <meta name="description" content="@yield('meta_description', 'Temukan destinasi wisata, event, penginapan, dan kuliner terbaik di Kabupaten Sukabumi. Panduan perjalanan lengkap dari Visit Sukabumi.')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    {{-- ══ Open Graph (WhatsApp, Facebook, Telegram, LinkedIn) ══ --}}
    <meta property="og:site_name"   content="Visit Sukabumi">
    <meta property="og:locale"      content="id_ID">
    <meta property="og:type"        content="@yield('og_type', 'website')">
    <meta property="og:title"       content="@yield('og_title', '@yield('title', 'Visit Sukabumi — Panduan Wisata Kabupaten Sukabumi')')">
    <meta property="og:description" content="@yield('og_description', '@yield('meta_description', 'Temukan destinasi wisata, event, penginapan, dan kuliner terbaik di Kabupaten Sukabumi.')')">
    <meta property="og:url"         content="@yield('canonical', url()->current())">
    <meta property="og:image"       content="@yield('og_image', asset('assets/images/og-default.jpg'))">
    <meta property="og:image:width"  content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt"   content="@yield('og_image_alt', 'Visit Sukabumi')">

    {{-- ══ Twitter / X Card ══ --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:site"        content="@visitsukabumi">
    <meta name="twitter:title"       content="@yield('og_title', '@yield('title', 'Visit Sukabumi')')">
    <meta name="twitter:description" content="@yield('og_description', '@yield('meta_description', 'Temukan destinasi wisata terbaik di Kabupaten Sukabumi.')')">
    <meta name="twitter:image"       content="@yield('og_image', asset('assets/images/og-default.jpg'))">

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
