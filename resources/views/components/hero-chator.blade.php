{{-- Hero Chator AI: lockup + kotak input "Tanya ke AI". --}}
<section id="chator" class="px-[22px] py-[26px] text-center border-b border-hair bg-cream">
    <p class="mb-[18px]" style="font-family:'Inter',sans-serif; font-size:13px; font-weight:400;
              line-height:1.5; color:#79716b;">
        Sampaikan keluhan, usulan, atau cari informasi publik
        dengan bantuan AI.
    </p>

    <form action="{{ route('ai.ask') }}" method="GET"
          class="text-left bg-white border-[1.5px] border-hair rounded-2xl px-2.5 pt-2.5 pb-2.5
                 max-w-[340px] mx-auto shadow-soft focus-within:border-warm
                 focus-within:ring-4 focus-within:ring-warm/10 transition">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Tulis aspirasi atau pertanyaan…"
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
