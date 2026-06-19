{{--
    x-live-aspirasi: hero card bergulir "LIVE ASPIRASI WARGA".
    Props: $aspirasi (Collection), $aiTotal (int)
--}}
@props(['aspirasi' => collect(), 'aiTotal' => 0])

@php
    $slides = $aspirasi->chunk(3)->values();
    $total  = $slides->count();
    $dot = ['green'=>'#22c55e','yellow'=>'#f59e0b','blue'=>'#3b82f6','red'=>'#ef4444'];
@endphp

@if ($slides->isNotEmpty())
<section
    x-data="{
        current: 0,
        total: {{ $total }},
        timer: null,
        touchX: null,
        next() { this.current = (this.current + 1) % this.total; },
        prev() { this.current = (this.current - 1 + this.total) % this.total; },
        start() { this.timer = setInterval(() => this.next(), 5000); },
        stop()  { clearInterval(this.timer); }
    }"
    x-init="start()"
    @mouseenter="stop()"
    @mouseleave="start()"
    @touchstart.passive="touchX = $event.touches[0].clientX"
    @touchend.passive="
        if (touchX !== null) {
            const d = touchX - $event.changedTouches[0].clientX;
            if (Math.abs(d) > 48) d > 0 ? next() : prev();
            touchX = null;
        }
    "
    style="background:#0f0d0b; padding:14px 16px;">

    <div style="border:1px solid rgba(255,255,255,0.12); border-radius:18px;
                background:rgba(255,255,255,0.07); backdrop-filter:blur(16px);
                -webkit-backdrop-filter:blur(16px);
                box-shadow:0 4px 28px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.08);
                padding:16px 18px;
                max-width:480px; margin:0 auto;">

        {{-- Label LIVE --}}
        <div style="display:flex; align-items:center; gap:7px; margin-bottom:12px;">
            <span style="width:7px; height:7px; border-radius:50%; background:#ef4444; flex:0 0 7px;
                         animation:pulse-dot 1.6s ease-in-out infinite;"></span>
            <span style="font-family:'Inter',sans-serif; font-size:9.5px; font-weight:800;
                         letter-spacing:0.14em; text-transform:uppercase; color:#ef4444;">LIVE</span>
            <span style="font-family:'Inter',sans-serif; font-size:9.5px; font-weight:600;
                         letter-spacing:0.08em; text-transform:uppercase;
                         color:rgba(255,255,255,0.45);">ASPIRASI WARGA</span>
        </div>

        {{-- Slides — x-transition native Alpine, semua slides absolute dalam wrapper tetap --}}
        <div style="position:relative; height:120px; overflow:hidden; margin-bottom:12px;">
            @foreach ($slides as $i => $group)
            <div x-show="current === {{ $i }}"
                 x-transition:enter="transition-opacity duration-300 ease-out"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity duration-200 ease-in"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 style="position:absolute; inset:0;
                        display:flex; flex-direction:column; gap:9px;">
                @foreach ($group as $item)
                <div style="display:flex; align-items:flex-start; gap:10px; min-width:0;">
                    <span style="flex:0 0 7px; width:7px; height:7px; border-radius:50%; margin-top:4px;
                                 background:{{ $dot[$item->color] ?? '#9ca3af' }};"></span>
                    <div style="flex:1; min-width:0; overflow:hidden;">
                        <div style="font-family:'Inter',sans-serif; font-size:13px; font-weight:600;
                                    color:#f0ebe2; line-height:1.25;
                                    white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            {{ $item->title }}
                        </div>
                        <div style="font-family:'Inter',sans-serif; font-size:10px;
                                    color:rgba(255,255,255,0.35); margin-top:3px;
                                    white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            📍 {{ $item->location }} · {{ $item->time_ago }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>

        {{-- Footer --}}
        <div style="display:flex; align-items:center; justify-content:space-between; gap:8px;">
            <div style="font-family:'Inter',sans-serif; font-size:9.5px;
                        color:rgba(255,255,255,0.35); flex:1; min-width:0;
                        white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                🤖 AI menganalisis
                <strong style="color:rgba(255,255,255,0.6);">{{ number_format($aiTotal) }}</strong>
                aspirasi hari ini
            </div>
            <div style="display:flex; align-items:center; gap:5px; flex:0 0 auto;">
                <button @click="prev()" aria-label="Sebelumnya"
                        style="width:22px; height:22px; border-radius:6px; padding:0;
                               border:1px solid rgba(255,255,255,0.15);
                               background:rgba(255,255,255,0.07); color:rgba(255,255,255,0.55);
                               display:flex; align-items:center; justify-content:center;
                               cursor:pointer; font-size:13px; line-height:1;">‹</button>
                <span style="font-family:'Inter',sans-serif; font-size:9.5px;
                             color:rgba(255,255,255,0.35); min-width:22px; text-align:center;">
                    <span x-text="current + 1"></span>/{{ $total }}
                </span>
                <button @click="next()" aria-label="Berikutnya"
                        style="width:22px; height:22px; border-radius:6px; padding:0;
                               border:1px solid rgba(255,255,255,0.15);
                               background:rgba(255,255,255,0.07); color:rgba(255,255,255,0.55);
                               display:flex; align-items:center; justify-content:center;
                               cursor:pointer; font-size:13px; line-height:1;">›</button>
            </div>
        </div>

    </div>
</section>

<style>
@keyframes pulse-dot {
    0%,100% { box-shadow:0 0 0 2px rgba(239,68,68,0.3); }
    50%      { box-shadow:0 0 0 4px rgba(239,68,68,0.1); }
}
@media (min-width:768px) {
    /* Desktop: card sedikit lebih lebar dan lebih bernapas, tapi tetap elegan */
    .aspirasi-section > div {
        max-width: 560px !important;
        padding: 20px 22px !important;
    }
}
</style>
@endif
