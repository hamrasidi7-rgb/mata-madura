{{-- Footer: wordmark + tautan redaksi. --}}
<footer class="px-[22px] pt-8 pb-10 border-t border-hair bg-cream">
    <div class="font-extrabold text-[18px] tracking-tight text-ink mb-[18px]">
        mata<span class="text-accent">Gen</span>
        <span class="ml-1 inline-flex items-center justify-center px-1.5 py-px rounded-md border-2 border-accent text-[10px] text-ink align-middle">AI</span>
    </div>
    <div class="grid grid-cols-2 gap-x-4 gap-y-3 mb-[22px]">
        @foreach (['Tentang Kami','Redaksi','Pedoman Media Siber','Kontak','Privacy Policy','AI Disclaimer'] as $link)
            <a href="#" class="text-[13px] text-[#5a5246] hover:text-accent transition">{{ $link }}</a>
        @endforeach
    </div>
    <div class="text-[11px] text-muted leading-relaxed border-t border-hair pt-4">
        matagen.com<br>
        © {{ date('Y') }} mataGen AI. Konten dibantu AI Chator.
    </div>
</footer>
