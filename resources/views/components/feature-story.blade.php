{{--
    Kartu berita besar / sorotan utama: foto di atas, judul di bawah + ringkasan.
    Props: $article (App\Models\Article), $size = 'lg' | 'md'
--}}
@props(['article', 'size' => 'lg'])

@php
    $isLg = $size === 'lg';
@endphp

<a href="{{ route('article.show', $article) }}" class="block group">
    <div class="w-full aspect-[16/10] {{ $isLg ? '' : 'rounded-xl' }} overflow-hidden bg-cream mb-4">
        @if ($article->image_path)
            <img src="{{ asset($article->image_path) }}" alt="{{ $article->title }}"
                 class="w-full h-full object-cover" loading="lazy">
        @endif
    </div>
    <div class="{{ $isLg ? 'px-[22px]' : '' }}">
        {{-- Kicker / kategori --}}
        <div style="font-family:'Inter',sans-serif; font-size:11px; font-weight:800; letter-spacing:0.06em; text-transform:uppercase; color:#b21f24; margin-bottom:10px;">
            {{ $article->category->name }}
        </div>

        {{-- Judul --}}
        @if ($isLg)
            <h2 style="font-family:'Fraunces',serif; font-size:30px; font-weight:600; line-height:1.06; letter-spacing:-0.02em; color:#14110f; margin:0 0 12px; text-wrap:pretty;">
                {{ $article->title }}
            </h2>
        @else
            <h2 style="font-family:'Fraunces',serif; font-size:21px; font-weight:600; line-height:1.15; letter-spacing:-0.015em; color:#14110f; margin:0 0 10px; text-wrap:pretty;">
                {{ $article->title }}
            </h2>
        @endif

        {{-- Deck --}}
        @if ($article->deck)
            <p style="font-family:'Fraunces',serif; font-size:16px; line-height:1.45; color:#6b6358; margin:0 0 12px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                {{ $article->deck }}
            </p>
        @endif

        {{-- Meta --}}
        <div style="font-family:'Inter',sans-serif; font-size:{{ $isLg ? '12.5' : '11.5' }}px; color:#9a9183;">
            {{ $article->meta }}
        </div>
    </div>
</a>
