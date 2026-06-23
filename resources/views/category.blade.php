@extends('layouts.app')

@section('title', $category->name . ' — mataGen AI')
@section('meta_description', $category->description ?: 'Baca berita kategori ' . $category->name . ' di mataGen AI.')

@section('content')

    {{-- Topbar --}}
    <header class="sticky top-0 z-30 flex items-center justify-between px-3.5 py-3
                   bg-paper/80 backdrop-blur-md border-b border-hair">
        <a href="{{ route('home') }}"
           class="flex items-center gap-1.5 text-[13.5px] font-semibold text-ink px-2 py-1.5">
            <x-icon name="arrow-left" class="w-[17px] h-[17px]" /> Beranda
        </a>
        <span class="font-extrabold text-[13px] tracking-tight text-ink">
            mata<span class="text-accent">madura</span>
        </span>
    </header>

    {{-- Header kategori --}}
    <div class="px-[22px] pt-[26px] pb-[18px] border-b border-hair">
        <div class="flex items-center gap-2.5 mb-2">
            <span class="block w-6 h-0.5 bg-accent"></span>
            <span style="font-family:'Inter',sans-serif; font-size:11px; font-weight:700;
                         letter-spacing:0.16em; text-transform:uppercase; color:#b21f24;">
                Kategori
            </span>
        </div>
        <h1 style="font-family:'Fraunces',serif; font-size:26px; font-weight:600;
                   line-height:1.15; letter-spacing:-0.02em; color:#14110f; margin:0 0 6px;">
            {{ $category->name }}
        </h1>
        @if ($category->description)
            <p class="text-[13px] text-[#6b6358] leading-snug">{{ $category->description }}</p>
        @endif
    </div>

    {{-- Daftar artikel --}}
    @if ($articles->isNotEmpty())
        <section class="px-[22px] pb-10">
            <div class="flex flex-col">
                @foreach ($articles as $article)
                    <x-news-list-item :article="$article" />
                @endforeach
            </div>

            @if ($articles->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $articles->links() }}
                </div>
            @endif
        </section>
    @else
        <div class="px-[22px] py-[60px] text-center">
            <p style="font-family:'Fraunces',serif; font-size:18px; color:#9a9183;">
                Belum ada artikel di kategori ini.
            </p>
            <a href="{{ route('home') }}"
               class="inline-block mt-4 text-[13px] font-semibold text-accent hover:underline">
                ← Kembali ke beranda
            </a>
        </div>
    @endif

    <x-site-footer />

@endsection
