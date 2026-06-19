<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — MataMadura AI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-cream">
<div class="min-h-screen flex">

    {{-- Sidebar --}}
    <aside class="w-60 flex-none bg-white border-r border-hair p-5 hidden md:flex flex-col gap-6">
        <a href="{{ route('home') }}" class="font-extrabold text-[17px] tracking-tight">
            mata<span class="text-accent">madura</span>
            <span class="ml-1 text-[10px] border-2 border-accent rounded px-1">AI</span>
        </a>

        <nav class="flex flex-col gap-1 text-[14px]">
            <a href="{{ route('admin.articles.index') }}"
               class="px-3 py-2 rounded-lg font-semibold {{ request()->routeIs('admin.articles.*') ? 'bg-accent/10 text-accent' : 'text-ink hover:bg-cream' }}">
                Berita
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="px-3 py-2 rounded-lg font-semibold {{ request()->routeIs('admin.categories.*') ? 'bg-accent/10 text-accent' : 'text-ink hover:bg-cream' }}">
                Kategori
            </a>
            <a href="{{ route('admin.ai-features.index') }}"
               class="px-3 py-2 rounded-lg font-semibold {{ request()->routeIs('admin.ai-features.*') ? 'bg-accent/10 text-accent' : 'text-ink hover:bg-cream' }}">
                Fitur AI
            </a>
        </nav>
    </aside>

    {{-- Konten --}}
    <main class="flex-1 p-6 md:p-10 overflow-x-auto">

        {{-- Flash messages dengan Alpine auto-dismiss --}}
        @foreach (['success' => 'green', 'error' => 'red', 'status' => 'green'] as $key => $color)
            @if (session($key))
                <div x-data="{ show: true }"
                     x-init="setTimeout(() => show = false, 4000)"
                     x-show="show"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="mb-5 flex items-center justify-between px-4 py-3 rounded-xl
                            {{ $color === 'green' ? 'bg-green-50 border border-green-200 text-green-800' : 'bg-red-50 border border-red-200 text-red-800' }}
                            text-[14px]">
                    <span>{{ session($key) }}</span>
                    <button @click="show = false" class="ml-4 opacity-50 hover:opacity-100 text-lg leading-none">&times;</button>
                </div>
            @endif
        @endforeach

        @yield('content')
    </main>

</div>
</body>
</html>
