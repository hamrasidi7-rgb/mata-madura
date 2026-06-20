{{-- Strip 3 angka audit RUP. Props: $highlights (Collection<AuditHighlight>) --}}
@props(['highlights' => collect()])

@if ($highlights->isNotEmpty())
<section class="px-[22px] py-[18px] border-b border-hair bg-white">

    {{-- Judul strip --}}
    <div class="flex items-center justify-between mb-[14px]">
        <span style="font-family:'Inter',sans-serif; font-size:11px; font-weight:700;
                     letter-spacing:0.06em; text-transform:uppercase; color:#1a1816;">
            Audit RUP Sumenep &middot; TA 2026
        </span>
        <span style="font-family:'Inter',sans-serif; font-size:10px; color:#b0a89e;">
            diperbarui berkala
        </span>
    </div>

    {{-- 3 kolom angka --}}
    <div class="grid grid-cols-3 gap-3 mb-[14px]">
        @foreach ($highlights as $h)
        <div class="text-center">
            <div style="font-family:'Inter',sans-serif; font-size:20px; font-weight:800;
                        letter-spacing:-0.02em; color:#C0392B; line-height:1.1;">
                {{ $h->value }}
            </div>
            <div style="font-family:'Inter',sans-serif; font-size:10px; color:#79716b;
                        margin-top:4px; line-height:1.3;">
                {{ $h->label }}
            </div>
        </div>
        @endforeach
    </div>

    {{-- Disclaimer AI --}}
    <p style="font-family:'Inter',sans-serif; font-size:10px; color:#b0a89e;
              line-height:1.45; border-top:1px solid #e8e3d9; padding-top:10px; margin:0;">
        Data merupakan hasil klasifikasi AI dan dapat keliru.
        Gunakan sebagai acuan dan bantuan semata untuk mendukung pemantauan publik.
    </p>

</section>
@endif
