@extends('layouts.app')
@section('title', 'Sampaikan Aspirasi — MataMadura')

@section('content')
<div class="px-[22px] py-[40px] max-w-xl mx-auto">

    <a href="{{ route('home') }}"
       class="inline-flex items-center gap-1.5 text-[13px] text-ink-2 mb-[28px]">
        ← Kembali ke beranda
    </a>

    <h1 style="font-family:'Fraunces',serif; font-size:24px; font-weight:600;
               color:#1a1816; margin-bottom:12px; line-height:1.2;">
        Sampaikan Aspirasi Anda
    </h1>

    <div class="px-4 py-5 rounded-2xl border border-hair bg-white text-center">
        <div style="font-size:32px; margin-bottom:12px;">📮</div>
        <p style="font-family:'Fraunces',serif; font-size:17px; font-weight:600;
                  color:#1a1816; margin-bottom:8px;">
            Formulir aspirasi sedang disiapkan
        </p>
        <p style="font-family:'Inter',sans-serif; font-size:13px; color:#79716b;
                  line-height:1.5; margin-bottom:20px;">
            Segera hadir — Anda akan dapat menyampaikan keluhan,<br>
            usulan, dan laporan langsung dari halaman ini.
        </p>
        <a href="{{ route('home') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-[13px] font-semibold
                  text-white"
           style="background:#C0392B;">
            ← Kembali ke beranda
        </a>
    </div>

</div>
@endsection
