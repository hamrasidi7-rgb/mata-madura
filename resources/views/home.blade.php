@extends('layouts.app')

@section('title', 'MataMadura AI — Portal Berita Madura')

@section('content')

    {{-- 1. HEADER --}}
    <x-site-header :categories="$categories" />

    {{-- 2. HERO — Chator AI search bar --}}
    <x-hero-chator />

    {{-- 3. SECTION UTAMA — Banner anggaran (label + ikon + nominal Rp) --}}
    <x-budget-banner :items="$budgetItems" />

    {{-- 4. BERITA TRENDING (kartu horizontal bernomor) --}}
    @if ($trending->isNotEmpty())
        <section class="pt-[22px] pb-[30px] border-t border-hair">
            <div class="section-eyebrow px-[22px]">
                <h2 class="section-title">Berita Trending</h2>
            </div>
            <div class="no-scrollbar flex gap-3.5 overflow-x-auto px-[22px] pb-1.5 snap-x snap-mandatory">
                @foreach ($trending as $i => $article)
                    <x-trending-card :article="$article" :rank="$i + 1" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- 5. BERITA TERBARU (featured + list) --}}
    <section class="px-[22px] pt-[22px] pb-[30px] border-t border-hair">
        <div class="section-eyebrow">
            <h2 class="section-title">Berita Terbaru</h2>
        </div>

        @if ($latestFeatured)
            <div class="pb-[18px] mb-1 border-b border-hair">
                <x-feature-story :article="$latestFeatured" size="md" />
            </div>
        @endif

        <div class="flex flex-col">
            @foreach ($latest as $article)
                <x-news-list-item :article="$article" />
            @endforeach
        </div>
    </section>

    {{-- 6. KATEGORI BERITA --}}
    <section class="px-[22px] pt-2 pb-[34px]">
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
