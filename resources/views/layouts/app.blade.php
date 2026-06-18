<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>@yield('title', 'MataMadura AI — Portal Berita Madura')</title>
    <meta name="description" content="@yield('meta_description', 'Portal berita Madura berbasis AI. Tanya berita, baca sorotan, dan jelajahi kategori.')">

    {{-- Vite: jalankan `npm run dev` atau `npm run build` --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="mx-auto w-full max-w-app min-h-screen bg-paper shadow-[0_0_60px_rgba(40,30,20,0.10)] overflow-hidden">
        @yield('content')
    </div>
</body>
</html>
