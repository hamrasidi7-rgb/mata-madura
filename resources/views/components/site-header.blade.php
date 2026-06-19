{{-- Header sticky: hamburger + wordmark + badge "AI", tombol "+" (Tanya AI baru). --}}
<header class="sticky top-0 z-30 flex items-center justify-between px-4 py-3
               bg-paper/80 backdrop-blur-md border-b border-hair">
    <div class="flex items-center gap-3">
        <button type="button" aria-label="Menu"
                onclick="document.getElementById('mm-menu')?.classList.toggle('hidden')"
                class="w-[42px] h-[42px] flex items-center justify-center rounded-xl border border-hair bg-white">
            <x-icon name="menu" class="w-[19px] h-[19px] text-ink" />
        </button>

        <a href="{{ route('home') }}" class="flex items-center gap-2">
            {{-- Ganti dengan logo asli di public/images/wordmark.png --}}
            <span class="font-extrabold text-[23px] tracking-tight text-ink">mata<span class="text-accent">madura</span></span>
            <span class="inline-flex items-center justify-center px-1 py-px rounded border-[1.5px] border-accent
                         font-extrabold text-[9px] leading-none text-ink">AI</span>
        </a>
    </div>

    <a href="{{ route('home') }}#chator" aria-label="Tanya AI baru"
       class="w-[42px] h-[42px] flex items-center justify-center rounded-xl bg-ink">
        <x-icon name="plus" class="w-[18px] h-[18px] text-white" />
    </a>
</header>

{{-- Panel kategori (toggle dari hamburger) --}}
<nav id="mm-menu" class="hidden sticky top-[61px] z-20 bg-paper/95 backdrop-blur-md border-b border-hair px-4 py-3">
    <div class="grid grid-cols-2 gap-2">
        @foreach ($categories ?? [] as $cat)
            <a href="{{ route('category.show', $cat) }}"
               class="flex items-center justify-between px-4 py-3 rounded-xl border border-hair bg-white
                      text-[14px] font-semibold text-ink hover:border-accent hover:text-accent transition">
                {{ $cat->name }}
                <x-icon name="chevron" class="w-3.5 h-3.5" />
            </a>
        @endforeach
    </div>
</nav>
