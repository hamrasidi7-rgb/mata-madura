{{--
    x-ai-feature-card: kartu fitur AI.
    Ikon (kotak rounded, background pastel soft) + judul serif bold + deskripsi muted + chevron.
    Seluruh kartu clickable. Konsisten dengan x-category-card.
    Props: $feature (App\Models\AiFeature)
--}}
@props(['feature'])

@php
    // Warna pastel soft berbeda per ikon agar kartu punya identitas.
    $tones = [
        'chart'  => 'bg-warm/10 text-warm',
        'person' => 'bg-accent/10 text-accent',
    ];
    $tone = $tones[$feature->icon] ?? 'bg-cream text-ink';
@endphp

<a href="{{ $feature->link }}"
   class="flex items-center gap-3.5 px-4 py-4 rounded-2xl border border-hair bg-white shadow-soft
          hover:border-warm transition">
    <span class="flex-none w-[46px] h-[46px] rounded-xl flex items-center justify-center {{ $tone }}">
        <x-icon :name="$feature->icon" class="w-6 h-6" />
    </span>
    <span class="flex-1 min-w-0">
        <span class="block font-serif text-[17px] font-semibold text-ink-2 mb-0.5">{{ $feature->title }}</span>
        <span class="block text-[12.5px] leading-snug text-muted">{{ $feature->description }}</span>
    </span>
    <x-icon name="chevron" class="flex-none w-4 h-4 text-[#c8c0b2]" />
</a>
