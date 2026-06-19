{{--
    x-live-aspirasi: hero card bergulir "LIVE ASPIRASI WARGA".
    Props: $aspirasi (Collection), $aiTotal (int)
--}}
@props(['aspirasi' => collect(), 'aiTotal' => 0])

@php
    // Kelompokkan per 3 → tiap slide berisi 3 baris
    $slides = $aspirasi->chunk(3)->values();
    $total  = $slides->count();

    $dot = [
        'green'  => '#22c55e',
        'yellow' => '#f59e0b',
        'blue'   => '#3b82f6',
        'red'    => '#ef4444',
    ];
@endphp

@if ($slides->isNotEmpty())
<section
    x-data="{
        current: 0,
        total: {{ $total }},
        timer: null,
        touchX: null,
        fading: false,
        goTo(i) {
            if (this.fading) return;
            this.fading = true;
            setTimeout(() => { this.current = ((i % this.total) + this.total) % this.total; this.fading = false; }, 250);
        },
        next() { this.goTo(this.current + 1); },
        prev() { this.goTo(this.current - 1); },
        start() { this.timer = setInterval(() => this.next(), 5000); },
        stop()  { clearInterval(this.timer); }
    }"
    x-init="start()"
    @mouseenter="stop()"
    @mouseleave="start()"
    @touchstart.passive="touchX = $event.touches[0].clientX"
    @touchend.passive="
        if (touchX !== null) {
            let d = touchX - $event.changedTouches[0].clientX;
            if (Math.abs(d) > 48) d > 0 ? next() : prev();
            touchX = null;
        }
    "
    style="background:#0f0d0b; padding:20px 22px 22px;">

    <div style="position:relative; border:1px solid rgba(255,255,255,0.13); border-radius:18px;
                background:rgba(255,255,255,0.07); backdrop-filter:blur(14px);
                -webkit-backdrop-filter:blur(14px);
                box-shadow:0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(255,255,255,0.09);
                padding:18px 20px; min-height:148px; overflow:hidden;">

        {{-- Header LIVE --}}
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:14px;">
            <span style="width:8px; height:8px; border-radius:50%; background:#ef4444;
                         box-shadow:0 0 0 3px rgba(239,68,68,0.25); flex:0 0 auto;
                         animation:pulse-dot 1.6s ease-in-out infinite;"></span>
            <span style="font-family:'Inter',sans-serif; font-size:11px; font-weight:800;
                         letter-spacing:0.14em; text-transform:uppercase; color:#ef4444;">LIVE</span>
            <span style="font-family:'Inter',sans-serif; font-size:11px; font-weight:700;
                         letter-spacing:0.06em; text-transform:uppercase; color:rgba(255,255,255,0.55);">ASPIRASI WARGA</span>
        </div>

        {{-- Slides --}}
        @foreach ($slides as $i => $group)
        <div x-show="current === {{ $i }}"
             :style="fading ? 'opacity:0;transition:opacity 0.25s ease' : 'opacity:1;transition:opacity 0.25s ease'"
             style="position:{{ $i === 0 ? 'relative' : 'absolute' }}; top:{{ $i === 0 ? 'auto' : '52px' }}; left:0; width:100%; padding:0 20px; box-sizing:border-box;">
            <div style="display:flex; flex-direction:column; gap:10px;">
                @foreach ($group as $item)
                <div style="display:flex; align-items:flex-start; gap:10px;">
                    <span style="width:8px; height:8px; border-radius:50%; background:{{ $dot[$item->color] ?? '#9ca3af' }};
                                 flex:0 0 auto; margin-top:5px;
                                 box-shadow:0 0 6px {{ $dot[$item->color] ?? '#9ca3af' }}66;"></span>
                    <div style="flex:1; min-width:0;">
                        <div style="font-family:'Inter',sans-serif; font-size:14px; font-weight:600;
                                    color:#f5f0e8; line-height:1.3; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            {{ $item->title }}
                        </div>
                        <div style="font-family:'Inter',sans-serif; font-size:11px; color:rgba(255,255,255,0.4); margin-top:2px;">
                            📍 {{ $item->location }} &nbsp;·&nbsp; {{ $item->time_ago }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

        {{-- Footer: AI info + navigator --}}
        <div style="position:absolute; bottom:14px; left:20px; right:20px;
                    display:flex; align-items:center; justify-content:space-between; gap:8px;">

            <div style="font-family:'Inter',sans-serif; font-size:11px; color:rgba(255,255,255,0.45);">
                🤖 AI menganalisis <strong style="color:rgba(255,255,255,0.7);">{{ number_format($aiTotal) }}</strong> aspirasi hari ini
            </div>

            <div style="display:flex; align-items:center; gap:8px; flex:0 0 auto;">
                {{-- Prev --}}
                <button @click="prev()" aria-label="Sebelumnya"
                        style="width:26px; height:26px; border-radius:8px; border:1px solid rgba(255,255,255,0.15);
                               background:rgba(255,255,255,0.08); color:rgba(255,255,255,0.6);
                               display:flex; align-items:center; justify-content:center;
                               cursor:pointer; font-size:12px; line-height:1;">‹</button>

                {{-- Indicator --}}
                <span style="font-family:'Inter',sans-serif; font-size:11px; color:rgba(255,255,255,0.45); min-width:28px; text-align:center;">
                    <span x-text="current + 1"></span>/{{ $total }}
                </span>

                {{-- Next --}}
                <button @click="next()" aria-label="Berikutnya"
                        style="width:26px; height:26px; border-radius:8px; border:1px solid rgba(255,255,255,0.15);
                               background:rgba(255,255,255,0.08); color:rgba(255,255,255,0.6);
                               display:flex; align-items:center; justify-content:center;
                               cursor:pointer; font-size:12px; line-height:1;">›</button>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes pulse-dot {
    0%, 100% { opacity: 1; box-shadow: 0 0 0 3px rgba(239,68,68,0.25); }
    50%       { opacity: 0.7; box-shadow: 0 0 0 5px rgba(239,68,68,0.10); }
}
</style>
@endif
