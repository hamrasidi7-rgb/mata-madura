{{-- Hero: Tanya AI soal APBD Sumenep --}}
<section id="chator" class="px-[22px] py-[26px] text-center border-b border-hair bg-cream">

    {{-- Brand: ikon kiri + kolom kanan (Chator AI + Powered by menempel di bawahnya) --}}
    <div class="flex items-center justify-center gap-[9px] mb-[18px]">
        <svg width="26" height="26" viewBox="0 0 32 32" fill="none"
             style="height:26px;width:auto;display:block;opacity:0.5;flex:none;">
            <path d="M16 2.5 L27.5 9.25 L27.5 22.75 L16 29.5 L4.5 22.75 L4.5 9.25 Z"
                  stroke="#5ab8c4" stroke-width="1.8" stroke-linejoin="round" fill="none"/>
            <path d="M7 16 C9 10 23 10 25 16 C23 22 9 22 7 16 Z"
                  stroke="#5ab8c4" stroke-width="1.4" fill="none"/>
            <circle cx="16" cy="16" r="2.6" fill="#5ab8c4"/>
        </svg>
        <div class="flex flex-col items-center" style="gap:2px;">
            <span style="font-family:'Inter',sans-serif; font-weight:700; font-size:25px;
                         letter-spacing:-0.02em; color:#1a1816; line-height:1;">Chator AI</span>
            <span style="font-family:'Inter',sans-serif; font-weight:400; font-size:7px;
                         letter-spacing:0.01em; color:#9a9183; line-height:1;">Powered by mataGen.ai</span>
        </div>
    </div>

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
               placeholder="Tanyakan soal anggaran Sumenep…"
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
