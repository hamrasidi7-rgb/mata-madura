{{-- Hero: Tanya AI soal APBD Sumenep --}}
<section id="chator" class="px-[22px] py-[26px] text-center border-b border-hair bg-cream">

    <h1 style="font-family:'Fraunces',serif; font-size:22px; font-weight:600;
               line-height:1.2; letter-spacing:-0.02em; color:#1a1816; margin-bottom:6px;">
        Tanya AI soal APBD Sumenep
    </h1>

    <p style="font-family:'Inter',sans-serif; font-size:13px; color:#79716b;
              line-height:1.45; margin-bottom:18px;">
        Telusuri APBD, dijawab dari data resmi.
    </p>

    <form action="/tanya" method="GET"
          class="text-left bg-white border-[1.5px] border-hair rounded-2xl px-2.5 pt-2.5 pb-2.5
                 max-w-[340px] mx-auto shadow-soft focus-within:border-accent
                 focus-within:ring-4 focus-within:ring-accent/10 transition">
        <input type="text" name="q" value="{{ request('q') }}"
               placeholder="Tanyakan soal anggaran, program, atau pengadaan…"
               class="w-full text-[13px] text-ink placeholder:text-muted/70 border-0 p-0 pb-2.5
                      focus:ring-0 bg-transparent" />
        <div class="flex items-center justify-between">
            <span class="text-[11px] text-muted/70">Tekan Enter untuk bertanya</span>
            <button type="submit" aria-label="Kirim"
                    class="w-[30px] h-[30px] rounded-full bg-accent flex items-center justify-center">
                <x-icon name="arrow-up" class="w-3.5 h-3.5 text-white" />
            </button>
        </div>
    </form>

    <p style="font-family:'Inter',sans-serif; font-size:10px; color:#b0a89e;
              margin-top:12px; line-height:1.4;">
        Bersumber dari APBD &amp; data pengadaan resmi (SiRUP)
    </p>

</section>
