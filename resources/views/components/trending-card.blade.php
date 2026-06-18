{{--
    Kartu Trending horizontal dengan nomor peringkat.
    Props: $article, $rank (int)
--}}
@props(['article', 'rank' => 1])

<a href="{{ route('article.show', $article) }}"
   class="snap-start flex-none w-[232px] rounded-2xl border border-hair bg-white shadow-card overflow-hidden">
    <div class="relative h-[132px] bg-cream">
        @if ($article->image_path)
            <img src="{{ asset($article->image_path) }}" alt="{{ $article->title }}"
                 class="w-full h-full object-cover" loading="lazy">
        @endif
        <span class="absolute left-3 top-3 w-8 h-8 rounded-full bg-accent text-white
                     font-serif text-[18px] font-semibold flex items-center justify-center">
            {{ str_pad((string) $rank, 2, '0', STR_PAD_LEFT) }}
        </span>
    </div>
    <div class="px-3.5 pt-3 pb-4">
        <div class="text-[10px] tracking-wider uppercase font-extrabold text-accent mb-[7px]">
            {{ $article->category->name }}
        </div>
        <h3 class="font-serif text-[16.5px] font-semibold leading-tight tracking-tight text-ink-2 text-pretty mb-2.5">
            {{ $article->title }}
        </h3>
        <div class="text-[11px] text-muted">{{ $article->meta }}</div>
    </div>
</a>
