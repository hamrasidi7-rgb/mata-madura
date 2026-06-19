@extends('layouts.app')

@section('title', 'MataMadura AI — Portal Berita Madura')

@section('content')

    {{-- 1. HEADER --}}
    <x-site-header :categories="$categories" />

    {{-- 2. HERO — Chator AI search bar --}}
    <x-hero-chator />

    {{-- 3. BANNER ANGGARAN --}}
    <x-budget-banner :items="$budgetItems" />

    {{-- 4. SOROTAN UTAMA — foto full-bleed, aspect 16:10 --}}
    @if ($sorotanUtama)
        <section class="border-t border-hair">
            <x-feature-story :article="$sorotanUtama" size="lg" />
        </section>
    @endif

    {{-- 5. LIVE ASPIRASI WARGA --}}
    <x-live-aspirasi :aspirasi="$aspirasi" :aiTotal="$aspirasiAiTotal" />

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
