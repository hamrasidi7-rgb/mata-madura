{{-- Hero Chator AI: lockup + kotak input "Tanya ke AI". --}}
<section id="chator" class="px-[22px] py-[26px] text-center border-b border-hair bg-cream">
    <div class="flex items-center justify-center gap-[9px] mb-[18px]">
        <img src="/images/chator-icon.png" alt="" class="h-8 w-auto opacity-50 block">
        <div class="flex flex-col items-start leading-[1.15]">
            <span style="font-family:'Inter',sans-serif; font-weight:700; font-size:19px; letter-spacing:-0.02em; color:#1a1816;">Chator AI</span>
            <span style="font-family:'Inter',sans-serif; font-weight:400; font-size:7px; letter-spacing:0.01em; color:#9a9183; margin-top:2px;">Powered by mataGen.ai</span>
        </div>
    </div>

    <form action="{{ route('ai.ask') }}" method="GET"
          class="text-left bg-white border-[1.5px] border-hair rounded-2xl px-2.5 pt-2.5 pb-2.5
                 max-w-[340px] mx-auto shadow-soft focus-within:border-warm
                 focus-within:ring-4 focus-within:ring-warm/10 transition">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Tanya ke AI"
               class="w-full text-[13px] text-ink placeholder:text-muted/80 border-0 p-0 pb-2.5
                      focus:ring-0 bg-transparent" />
        <div class="flex items-center justify-between">
            <span class="text-[11px] text-muted/80">Tekan Enter untuk mengirim</span>
            <button type="submit" aria-label="Kirim"
                    class="w-[30px] h-[30px] rounded-full bg-ink flex items-center justify-center">
                <x-icon name="arrow-up" class="w-3.5 h-3.5 text-white" />
            </button>
        </div>
    </form>
</section>
