@extends('layouts.app')

@section('title', 'mataGen AI — Portal AI Berbasis Data & Berita')

@section('content')

    {{-- 1. HEADER --}}
    <x-site-header :categories="$categories" />

    {{-- 2. HERO — Tanya AI soal APBD --}}
    <x-hero-chator />

    {{-- 3. STRIP AUDIT RUP --}}
    <x-audit-strip :highlights="$highlights" />

    {{-- 4. ASPIRASI WARGA — kotak kecil, pelengkap --}}
    <x-aspirasi-box :aspirasi="$aspirasi" />

    {{-- 5. BERITA TERBARU — 1 featured besar + list horizontal sisanya --}}
    @if ($latest->isNotEmpty())
        @php
            $featured = $latest->first();
            $rest     = $latest->slice(1)->take(3);
        @endphp
        <section class="px-[22px] pt-[22px] pb-[6px] border-t border-hair">
            <div class="section-eyebrow">
                <h2 class="section-title">Berita Terbaru</h2>
            </div>

            {{-- Kartu featured (vertikal) --}}
            <article class="mb-8">
                <a href="{{ route('article.show', $featured) }}" class="block">
                    <div class="aspect-[16/10] rounded-2xl overflow-hidden mb-4 bg-cream">
                        @if ($featured->image_path)
                            <img src="{{ asset('storage/' . ltrim($featured->image_path, '/')) }}"
                                 alt="{{ $featured->title }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <x-icon name="chart" class="w-10 h-10 text-hair" />
                            </div>
                        @endif
                    </div>
                    <span style="font-family:'Inter',sans-serif; font-size:11px; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; color:#c8372d;">
                        {{ $featured->category->name }}
                    </span>
                    <h3 style="font-family:'Fraunces',serif; font-size:24px; font-weight:600; line-height:1.2; color:#1c1814; margin:8px 0 8px;">
                        {{ $featured->title }}
                    </h3>
                    <div style="font-family:'Inter',sans-serif; font-size:12.5px; color:#6b6358;">
                        {{ $featured->read_minutes ?? 5 }} menit baca
                        · {{ $featured->published_at?->translatedFormat('d M Y') }}
                    </div>
                </a>
            </article>

            {{-- Garis pemisah --}}
            <hr class="border-hair mb-6">

            {{-- Kartu list (horizontal) --}}
            @foreach ($rest as $item)
                <article class="flex gap-4 mb-6">
                    <a href="{{ route('article.show', $item) }}" class="shrink-0">
                        <div class="w-24 h-24 rounded-xl overflow-hidden bg-cream">
                            @if ($item->image_path)
                                <img src="{{ asset('storage/' . ltrim($item->image_path, '/')) }}"
                                     alt="{{ $item->title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <x-icon name="chart" class="w-6 h-6 text-hair" />
                                </div>
                            @endif
                        </div>
                    </a>
                    <div class="min-w-0">
                        <span style="font-family:'Inter',sans-serif; font-size:10px; font-weight:800; letter-spacing:0.08em; text-transform:uppercase; color:#c8372d;">
                            {{ $item->category->name }}
                        </span>
                        <h4 style="font-family:'Fraunces',serif; font-size:16px; font-weight:600; line-height:1.25; color:#1c1814; margin:4px 0 0;">
                            <a href="{{ route('article.show', $item) }}">{{ $item->title }}</a>
                        </h4>
                        <div style="font-family:'Inter',sans-serif; font-size:11px; color:#6b6358; margin-top:4px;">
                            {{ $item->read_minutes ?? 5 }} menit baca
                            · {{ $item->published_at?->translatedFormat('d M Y') }}
                        </div>
                    </div>
                </article>
            @endforeach

        </section>
    @endif

    {{-- 6. KATEGORI BERITA --}}
    <section class="px-[22px] pt-[22px] pb-[34px] border-t border-hair">
        <div class="section-eyebrow">
            <h2 class="section-title">Kategori Berita</h2>
        </div>
        <div class="grid grid-cols-2 gap-2.5">
            @foreach ($categories as $category)
                <x-category-card :category="$category" />
            @endforeach
        </div>
    </section>

    {{-- 7. FITUR AI --}}
    @if ($aiFeatures->isNotEmpty())
        <section class="px-[22px] pt-1 pb-[34px]">
            <div class="section-eyebrow">
                <h2 class="section-title">Fitur AI</h2>
            </div>
            <div class="flex flex-col gap-3">
                @foreach ($aiFeatures as $feature)
                    <x-ai-feature-card :feature="$feature" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- FOOTER --}}
    <x-site-footer />

@endsection
