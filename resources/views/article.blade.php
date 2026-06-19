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
            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-warm to-accent text-white
                        font-bold text-[13px] flex items-center justify-center">
                {{ \Illuminate\Support\Str::of($article->author)->explode(' ')->map(fn($w) => mb_substr($w, 0, 1))->take(2)->implode('') }}
            </div>
            <div class="text-[12.5px] text-[#6b6358] leading-tight">
                <span class="font-bold text-ink">{{ $article->author }}</span><br>
                {{ $article->meta }}
            </div>
        </div>

        @if ($article->image_path)
            <figure class="mb-2">
                <div class="w-full aspect-[16/10] rounded-2xl overflow-hidden bg-cream">
                    <img src="{{ asset($article->image_path) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                </div>
                @if ($article->image_caption)
                    <figcaption class="text-[11.5px] italic text-muted mt-2.5 leading-snug">{{ $article->image_caption }}</figcaption>
                @endif
            </figure>
        @endif

        <div class="article-body mt-[22px]">
            {!! $article->body !!}
        </div>

        <div class="text-center my-3 text-accent text-[18px]">∎</div>

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
