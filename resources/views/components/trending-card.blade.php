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
        <div style="font-family:'Inter',sans-serif; font-size:10px; font-weight:800; letter-spacing:0.08em; text-transform:uppercase; color:#b21f24; margin-bottom:7px;">
            {{ $article->category->name }}
        </div>
        <h3 style="font-family:'Fraunces',serif; font-size:16.5px; font-weight:600; line-height:1.2; letter-spacing:-0.01em; color:#14110f; margin:0 0 10px; text-wrap:pretty;">
            {{ $article->title }}
        </h3>
        <div style="font-family:'Inter',sans-serif; font-size:11px; color:#9a9183;">
            {{ $article->meta }}
        </div>
    </div>
</a>
