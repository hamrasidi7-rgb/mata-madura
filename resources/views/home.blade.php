@extends('layouts.app')

@section('title', 'MataMadura AI — Portal Berita Madura')

@section('content')

    {{-- 1. HEADER --}}
    <x-site-header :categories="$categories" />

    {{-- 2. HERO — Tanya AI soal APBD --}}
    <x-hero-chator />

    {{-- 3. STRIP AUDIT RUP --}}
    <x-audit-strip :highlights="$highlights" />

    {{-- 4. ASPIRASI WARGA — kotak kecil, pelengkap --}}
    <x-aspirasi-box :aspirasi="$aspirasi" />

    {{-- 5. BERITA TERBARU — 4 item foto kiri + judul kanan --}}
    @if ($latest->isNotEmpty())
        <section class="px-[22px] pt-[22px] pb-[6px] border-t border-hair">
            <div class="section-eyebrow">
                <h2 class="section-title">Berita Terbaru</h2>
            </div>
            <div class="flex flex-col">
                @foreach ($latest as $article)
                    <x-news-list-item :article="$article" />
                @endforeach
            </div>
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
