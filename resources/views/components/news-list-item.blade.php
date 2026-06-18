{{--
    Item Berita Terbaru: foto kiri (±33%) + judul kanan.
    Props: $article
--}}
@props(['article'])

<a href="{{ route('article.show', $article) }}"
   class="flex gap-[15px] items-stretch border-b border-hair py-[18px]">
    <div class="flex-none w-[33%] aspect-[4/3] rounded-[10px] overflow-hidden bg-cream">
        @if ($article->image_path)
            <img src="{{ asset($article->image_path) }}" alt="{{ $article->title }}"
                 class="w-full h-full object-cover" loading="lazy">
        @endif
    </div>
    <div class="flex-1 min-w-0 flex flex-col justify-center">
        <div class="text-[10px] tracking-wider uppercase font-extrabold text-accent mb-[7px]">
            {{ $article->category->name }}
        </div>
        <h3 class="font-serif text-[17px] font-semibold leading-tight tracking-tight text-ink-2 text-pretty mb-2">
            {{ $article->title }}
        </h3>
        <div class="text-[11.5px] text-muted">{{ $article->meta }}</div>
    </div>
</a>
