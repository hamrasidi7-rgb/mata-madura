@extends('layouts.app')
@section('title', 'Sampaikan Aspirasi — mataGen')

@section('content')
<div class="px-[22px] py-[36px] max-w-xl mx-auto">

    <a href="{{ route('home') }}"
       class="inline-flex items-center gap-1.5 text-[13px] text-ink-2 mb-[24px]">
        ← Kembali ke beranda
    </a>

    <h1 style="font-family:'Fraunces',serif; font-size:24px; font-weight:600;
               color:#1a1816; margin-bottom:6px; line-height:1.2;">
        Sampaikan Aspirasi Anda
    </h1>
    <p style="font-family:'Inter',sans-serif; font-size:13px; color:#79716b;
              margin-bottom:24px; line-height:1.5;">
        Keluhan, usulan, atau laporan Anda akan ditinjau tim redaksi sebelum ditampilkan.
    </p>

    @if (session('submitted'))
        {{-- Pesan sukses setelah kirim --}}
        <div class="px-5 py-6 rounded-2xl border border-green-200 bg-green-50 text-center">
            <div style="font-size:32px; margin-bottom:10px;">✅</div>
            <p style="font-family:'Fraunces',serif; font-size:17px; font-weight:600;
                      color:#1a1816; margin-bottom:8px;">Terima kasih!</p>
            <p style="font-family:'Inter',sans-serif; font-size:13px; color:#79716b;
                      line-height:1.5; margin-bottom:20px;">
                Aspirasi Anda akan ditinjau sebelum ditampilkan di beranda.
            </p>
            <a href="{{ route('home') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-[13px] font-semibold text-white"
               style="background:#C0392B;">
                Kembali ke beranda
            </a>
        </div>

    @else
        {{-- Form kirim aspirasi --}}
        @if ($errors->any())
            <div class="mb-4 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-800 text-[13px]">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('aspirasi.store') }}" method="POST"
              class="flex flex-col gap-4">
            @csrf

            <div>
                <label class="block text-[13px] font-semibold text-ink mb-1.5">
                    Isi aspirasi <span class="text-accent">*</span>
                </label>
                <textarea name="title" rows="4" required maxlength="500"
                          placeholder="Ceritakan keluhan, usulan, atau laporan Anda…"
                          class="w-full rounded-xl border border-hair bg-white text-[14px] px-3 py-2.5
                                 focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/10">{{ old('title') }}</textarea>
                @error('title')
                    <p class="text-[12px] text-accent mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-[13px] font-semibold text-ink mb-1.5">
                    Lokasi <span class="text-muted font-normal">(opsional)</span>
                </label>
                <input type="text" name="location" value="{{ old('location') }}"
                       placeholder="mis. Kec. Pragaan, Desa Pinggir Papas"
                       class="w-full rounded-xl border border-hair bg-white text-[14px] px-3 py-2.5
                              focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/10">
            </div>

            <p class="text-[11px] text-muted leading-1.4">
                Aspirasi Anda akan ditinjau tim redaksi sebelum ditampilkan.
                Hindari menyertakan data pribadi orang lain.
            </p>

            <button type="submit"
                    class="w-full py-3 rounded-xl text-[14px] font-semibold text-white transition"
                    style="background:#C0392B;">
                Kirim Aspirasi
            </button>
        </form>
    @endif

</div>
@endsection
