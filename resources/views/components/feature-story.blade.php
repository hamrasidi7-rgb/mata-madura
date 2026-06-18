{{--
    Kartu berita besar / sorotan utama: foto di atas, judul di bawah + ringkasan.
    Props: $article (App\Models\Article), $size = 'lg' | 'md'
--}}
@props(['article', 'size' => 'lg'])

@php
    $titleClass = $size === 'lg'
        ? 'text-[30px] leading-[1.06]'
        : 'text-[21px] leading-[1.15]';
@endphp

<a href="{{ route('article.show', $article) }}" class="block group">
    <div class="w-full aspect-[16/10] {{ $size === 'lg' ? '' : 'rounded-xl' }} overflow-hidden bg-cream mb-4">
        @if ($article->image_path)
            <img src="{{ asset($article->image_path) }}" alt="{{ $article->title }}"
                 class="w-full h-full object-cover" loading="lazy">
        @endif
    </div>
    <div class="{{ $size === 'lg' ? 'px-[22px]' : '' }}">
        <div class="text-[11px] tracking-wider uppercase font-extrabold text-accent mb-2.5">
            {{ $article->category->name }}
        </div>
        <h2 class="font-serif {{ $titleClass }} font-semibold tracking-tight text-ink-2 text-pretty mb-3">
            {{ $article->title }}
        </h2>
        @if ($article->deck)
            <p class="font-serif text-[16px] leading-snug text-[#6b6358] text-pretty mb-3 line-clamp-2">
                {{ $article->deck }}
            </p>
        @endif
        <div class="text-[12.5px] text-muted">{{ $article->meta }}</div>
    </div>
</a>
