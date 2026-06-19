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
        <div style="font-family:'Inter',sans-serif; font-size:10px; font-weight:800; letter-spacing:0.08em; text-transform:uppercase; color:#b21f24; margin-bottom:7px;">
            {{ $article->category->name }}
        </div>
        <h3 style="font-family:'Fraunces',serif; font-size:17px; font-weight:600; line-height:1.2; letter-spacing:-0.01em; color:#14110f; margin:0 0 8px; text-wrap:pretty;">
            {{ $article->title }}
        </h3>
        <div style="font-family:'Inter',sans-serif; font-size:11.5px; color:#9a9183;">
            {{ $article->meta }}
        </div>
    </div>
</a>
