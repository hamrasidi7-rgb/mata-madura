<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — MataMadura AI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream">
    <div class="min-h-screen flex">
        {{-- Sidebar --}}
        <aside class="w-60 flex-none bg-white border-r border-hair p-5 hidden md:block">
            <div class="font-extrabold text-[17px] tracking-tight mb-6">
                mata<span class="text-accent">madura</span>
                <span class="ml-1 text-[10px] border-2 border-accent rounded px-1">AI</span>
            </div>
            <nav class="flex flex-col gap-1 text-[14px]">
                <a href="{{ route('admin.ai-features.index') }}"
                   class="px-3 py-2 rounded-lg font-semibold {{ request()->routeIs('admin.ai-features.*') ? 'bg-accent/10 text-accent' : 'text-ink hover:bg-cream' }}">
                    Fitur AI
                </a>
            </nav>
        </aside>

        {{-- Konten --}}
        <main class="flex-1 p-6 md:p-10 max-w-3xl">
            @if (session('status'))
                <div class="mb-5 px-4 py-3 rounded-xl bg-green-50 border border-green-200 text-green-800 text-[14px]">
                    {{ session('status') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
