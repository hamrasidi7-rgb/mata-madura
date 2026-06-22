@extends('layouts.app')

@section('title', $article->title . ' — MataMadura AI')
@section('meta_description', $article->deck)

@section('content')

    {{-- Topbar artikel --}}
    <header class="sticky top-0 z-30 flex items-center justify-between px-3.5 py-3
                   bg-paper/80 backdrop-blur-md border-b border-hair">
        <a href="{{ url()->previous() === url()->current() ? route('home') : url()->previous() }}"
           class="flex items-center gap-1.5 text-[13.5px] font-semibold text-ink px-2 py-1.5">
            <x-icon name="arrow-left" class="w-[17px] h-[17px]" /> Kembali
        </a>
        <span class="font-extrabold text-[13px] tracking-tight text-ink">
            mata<span class="text-accent">madura</span>
        </span>
    </header>

    <article class="px-[22px] pt-[26px] pb-10">
        <div class="flex items-center gap-2.5 mb-4">
            <span class="block w-6 h-0.5 bg-[#b21f24]"></span>
            <span style="font-family:'Inter',sans-serif; font-size:11px; font-weight:700; letter-spacing:0.16em; text-transform:uppercase; color:#b21f24;">{{ $article->category->name }}</span>
        </div>

        <h1 style="font-family:'Fraunces',serif; font-size:30px; font-weight:600; line-height:1.12; letter-spacing:-0.02em; color:#14110f; text-wrap:pretty; margin-bottom:1rem;">
            {{ $article->title }}
        </h1>

        @if ($article->deck)
            <p class="font-serif italic text-[18px] leading-snug text-[#5a5246] text-pretty mb-[22px]">
                {{ $article->deck }}
            </p>
        @endif

        <div class="flex items-center gap-2.5 py-3.5 border-y border-hair mb-[22px]">
            @php $byline = $article->author_name ?: ($article->author ?: 'Redaksi MataMadura'); @endphp
            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-warm to-accent text-white
                        font-bold text-[13px] flex items-center justify-center">
                {{ \Illuminate\Support\Str::of($byline)->explode(' ')->map(fn($w) => mb_substr($w, 0, 1))->take(2)->implode('') }}
            </div>
            <div class="text-[12.5px] text-[#6b6358] leading-tight">
                <span class="font-bold text-ink">{{ $byline }}</span><br>
                {{ $article->meta }}
            </div>
        </div>

        @if ($article->image_path)
            <figure class="my-6 max-w-[680px] mx-auto">
                <img src="{{ asset('storage/' . ltrim($article->image_path, '/')) }}"
                     alt="Ilustrasi artikel"
                     class="w-full rounded-2xl object-cover">
                @if (!empty($article->image_caption))
                    <figcaption class="text-[11.5px] italic text-muted mt-2.5 leading-snug">
                        {{ $article->image_caption }}
                    </figcaption>
                @endif
            </figure>
        @endif

        @php
            $paragraphs = preg_split('/\n\s*\n/', trim($article->body ?? ''));
        @endphp
        <div class="article-body max-w-[680px] mx-auto text-[18px] leading-[1.8] text-[#2b2b2b] mt-8">
            @foreach ($paragraphs as $p)
                @if (trim($p) !== '')
                    <p class="mb-6">{!! nl2br(e(trim($p))) !!}</p>
                @endif
            @endforeach
        </div>

        <div class="text-center my-3 text-accent text-[18px]">∎</div>

        {{-- Share --}}
        <div x-data="{ copied: false }"
             class="flex items-center flex-wrap gap-3 py-[18px] border-t border-hair">
            <span style="font-family:'Inter',sans-serif; font-size:11px; font-weight:700;
                         letter-spacing:0.08em; text-transform:uppercase; color:#9a9183; flex:0 0 auto;">
                Bagikan:
            </span>

            <div class="flex items-center gap-2">

                {{-- WhatsApp --}}
                <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . url()->current()) }}"
                   target="_blank" rel="noopener" aria-label="Bagikan ke WhatsApp"
                   class="flex items-center justify-center w-9 h-9 rounded-full bg-[#25D366] hover:opacity-90 transition-opacity">
                    <svg class="w-[18px] h-[18px]" fill="white" viewBox="0 0 24 24">
                        <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.38 1.26 4.79L2 22l5.44-1.42c1.37.74 2.93 1.17 4.6 1.17 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.9 9.9 0 0 0 12.04 2zm5.52 14.21c-.23.65-1.35 1.24-1.84 1.31-.5.08-1.14.11-1.83-.12-.42-.14-.97-.32-1.67-.63-2.94-1.27-4.86-4.23-5.01-4.43-.14-.2-1.17-1.56-1.17-2.97 0-1.41.74-2.1 1-2.39.27-.28.59-.35.79-.35.2 0 .39.01.56.01.18 0 .43-.07.67.51.25.59.84 2.05.91 2.2.08.15.13.33.03.53-.1.2-.15.33-.3.5-.14.18-.3.4-.43.53-.14.14-.29.3-.12.58.17.28.74 1.22 1.58 1.97.99.88 1.83 1.2 2.16 1.35.33.14.52.12.71-.07.2-.2.84-.98 1.06-1.32.22-.33.44-.28.74-.17.3.11 1.91.9 2.24 1.07.33.17.55.25.63.39.08.14.08.82-.15 1.47z"/>
                    </svg>
                </a>

                {{-- Facebook --}}
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                   target="_blank" rel="noopener" aria-label="Bagikan ke Facebook"
                   class="flex items-center justify-center w-9 h-9 rounded-full bg-[#1877F2] hover:opacity-90 transition-opacity">
                    <svg class="w-[18px] h-[18px]" fill="white" viewBox="0 0 24 24">
                        <path d="M24 12.073C24 5.446 18.627 0 12 0S0 5.446 0 12.073c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>

                {{-- X / Twitter --}}
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(url()->current()) }}"
                   target="_blank" rel="noopener" aria-label="Bagikan ke X"
                   class="flex items-center justify-center w-9 h-9 rounded-full bg-black hover:opacity-80 transition-opacity">
                    <svg class="w-[15px] h-[15px]" fill="white" viewBox="0 0 24 24">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.737-8.835L1.254 2.25H8.08l4.253 5.622 5.91-5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                </a>

                {{-- Telegram --}}
                <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}"
                   target="_blank" rel="noopener" aria-label="Bagikan ke Telegram"
                   class="flex items-center justify-center w-9 h-9 rounded-full bg-[#229ED9] hover:opacity-90 transition-opacity">
                    <svg class="w-[18px] h-[18px]" fill="white" viewBox="0 0 24 24">
                        <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.96 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                    </svg>
                </a>

                {{-- Copy Link --}}
                <button type="button"
                        @click="navigator.clipboard.writeText('{{ url()->current() }}'); copied = true; setTimeout(() => copied = false, 2000)"
                        aria-label="Salin tautan"
                        class="flex items-center justify-center w-9 h-9 rounded-full border border-hair bg-white hover:border-accent transition">
                    <svg x-show="!copied" class="w-[15px] h-[15px] text-ink-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="9" y="9" width="13" height="13" rx="2"/>
                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                    </svg>
                    <svg x-show="copied" style="display:none" class="w-[15px] h-[15px] text-green-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                </button>

            </div>

            <span x-show="copied"
                  x-transition:enter="transition ease-out duration-150"
                  x-transition:enter-start="opacity-0"
                  x-transition:enter-end="opacity-100"
                  x-transition:leave="transition ease-in duration-100"
                  x-transition:leave-start="opacity-100"
                  x-transition:leave-end="opacity-0"
                  style="display:none"
                  class="text-[11px] font-semibold text-green-600">
                Tersalin!
            </span>
        </div>

        {{-- Baca berikutnya --}}
        @if ($readNext->isNotEmpty())
            <div class="mt-[34px] pt-[22px] border-t border-hair">
                <h3 class="font-serif text-[18px] font-semibold mb-3.5">Baca berikutnya</h3>
                <div class="flex flex-col">
                    @foreach ($readNext as $next)
                        <x-news-list-item :article="$next" />
                    @endforeach
                </div>
            </div>
        @endif
    </article>

@endsection
