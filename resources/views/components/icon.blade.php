{{--
    <x-icon name="chart|person|sparkles|road|book|heart|users|chevron|menu|plus|arrow-up|arrow-left" class="..." />
    Kumpulan ikon garis (stroke=currentColor) agar bisa diwarnai lewat class teks.
--}}
@props(['name' => 'sparkles', 'class' => 'w-5 h-5'])

@php
    $paths = [
        'chart'     => '<path d="M4 19V5M4 19h16M8 16l3-4 3 2 4-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>',
        'person'    => '<circle cx="12" cy="8" r="3.4" stroke="currentColor" stroke-width="2" fill="none"/><path d="M5 20a7 7 0 0114 0" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/>',
        'sparkles'  => '<path d="M12 3l1.6 4.4L18 9l-4.4 1.6L12 15l-1.6-4.4L6 9l4.4-1.6L12 3z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" fill="none"/>',
        'road'      => '<path d="M6 21L9 3M18 21L15 3M12 6v2M12 12v2M12 18v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/>',
        'book'      => '<path d="M4 5a2 2 0 012-2h12v16H6a2 2 0 00-2 2V5z" stroke="currentColor" stroke-width="2" stroke-linejoin="round" fill="none"/><path d="M18 19H6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>',
        'heart'     => '<path d="M12 20s-7-4.5-7-9.5A3.5 3.5 0 0112 7a3.5 3.5 0 017 3.5C19 15.5 12 20 12 20z" stroke="currentColor" stroke-width="2" stroke-linejoin="round" fill="none"/>',
        'users'     => '<circle cx="9" cy="8" r="3" stroke="currentColor" stroke-width="2" fill="none"/><path d="M3 19a6 6 0 0112 0M16 6a3 3 0 010 6M21 19a6 6 0 00-4-5.7" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/>',
        'chevron'   => '<path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>',
        'menu'      => '<path d="M4 7h16M4 12h16M4 17h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>',
        'plus'      => '<path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>',
        'arrow-up'  => '<path d="M12 19V5M6 11l6-6 6 6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>',
        'arrow-left'=> '<path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>',
    ];
    $svg = $paths[$name] ?? $paths['sparkles'];
@endphp

<svg viewBox="0 0 24 24" fill="none" {{ $attributes->merge(['class' => $class]) }} aria-hidden="true">
    {!! $svg !!}
</svg>
