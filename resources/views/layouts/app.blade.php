<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    @php
        $ogTitle = View::yieldContent('og_title')
            ?: 'mataGen AI — Portal AI Berbasis Data & Berita';
        $ogDesc  = View::yieldContent('og_description')
            ?: 'Menggabungkan Kecerdasan Buatan dengan Data Terpercaya dan Berita Terkini — akurat & relevan.';
        $ogImage = View::yieldContent('og_image')
            ?: asset('images/og-image.jpg');
    @endphp

    <title>@yield('title', 'mataGen AI — Portal AI Berbasis Data & Berita')</title>
    <meta name="description" content="{{ $ogDesc }}">

    {{-- Open Graph --}}
    <meta property="og:type"         content="website">
    <meta property="og:url"          content="{{ url()->current() }}">
    <meta property="og:site_name"    content="mataGen AI">
    <meta property="og:locale"       content="id_ID">
    <meta property="og:title"        content="{{ $ogTitle }}">
    <meta property="og:description"  content="{{ $ogDesc }}">
    <meta property="og:image"        content="{{ $ogImage }}">
    <meta property="og:image:width"  content="1200">
    <meta property="og:image:height" content="630">

    {{-- Twitter Card --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="{{ $ogTitle }}">
    <meta name="twitter:description" content="{{ $ogDesc }}">
    <meta name="twitter:image"       content="{{ $ogImage }}">

    {{-- Vite: jalankan `npm run dev` atau `npm run build` --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="mx-auto w-full max-w-app min-h-screen bg-paper shadow-[0_0_60px_rgba(40,30,20,0.10)] overflow-hidden">
        @yield('content')
    </div>
</body>
</html>
