{{--
    x-live-aspirasi: hero card bergulir "LIVE ASPIRASI WARGA".
    Props: $aspirasi (Collection), $aiTotal (int)
--}}
@props(['aspirasi' => collect(), 'aiTotal' => 0])

@php
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
            setTimeout(() => {
                this.current = ((i % this.total) + this.total) % this.total;
                this.fading = false;
            }, 240);
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
    style="background:#0f0d0b; padding:16px;">

    {{-- Card glassmorphism --}}
    <div style="border:1px solid rgba(255,255,255,0.13); border-radius:18px;
                background:rgba(255,255,255,0.07); backdrop-filter:blur(14px);
                -webkit-backdrop-filter:blur(14px);
                box-shadow:0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(255,255,255,0.09);
                padding:16px;
                max-width:680px; margin:0 auto;">

        {{-- Baris 1: Label LIVE --}}
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:10px; flex-wrap:nowrap;">
            <span style="width:8px; height:8px; border-radius:50%; background:#ef4444; flex:0 0 8px;
                         box-shadow:0 0 0 3px rgba(239,68,68,0.25);
                         animation:pulse-dot 1.6s ease-in-out infinite;"></span>
            <span style="font-family:'Inter',sans-serif; font-size:10px; font-weight:800;
                         letter-spacing:0.14em; text-transform:uppercase; color:#ef4444;
                         white-space:nowrap;">LIVE</span>
            <span style="font-family:'Inter',sans-serif; font-size:10px; font-weight:700;
                         letter-spacing:0.06em; text-transform:uppercase;
                         color:rgba(255,255,255,0.5); white-space:nowrap;">ASPIRASI WARGA</span>
        </div>

        {{-- Baris 2: Slides wrapper — height 130px (mobile 360-480px) --}}
        <div style="position:relative; height:130px; overflow:hidden; margin-bottom:10px;">
            @foreach ($slides as $i => $group)
            <div x-show="current === {{ $i }}"
                 :style="fading ? 'opacity:0' : 'opacity:1'"
                 style="position:absolute; inset:0;
                        transition:opacity 0.24s ease;
                        display:flex; flex-direction:column; gap:8px;">
                @foreach ($group as $item)
                <div style="display:flex; align-items:flex-start; gap:9px; min-width:0;">
                    <span style="width:7px; height:7px; border-radius:50%; flex:0 0 7px;
                                 background:{{ $dot[$item->color] ?? '#9ca3af' }};
                                 margin-top:5px;
                                 box-shadow:0 0 5px {{ $dot[$item->color] ?? '#9ca3af' }}88;">
                    </span>
                    <div style="flex:1; min-width:0;">
                        <div style="font-family:'Inter',sans-serif; font-size:13px; font-weight:600;
                                    color:#f5f0e8; line-height:1.3;
                                    overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                            {{ $item->title }}
                        </div>
                        <div style="font-family:'Inter',sans-serif; font-size:10.5px;
                                    color:rgba(255,255,255,0.38); margin-top:2px;
                                    overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                            📍 {{ $item->location }} · {{ $item->time_ago }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>

        {{-- Baris 3: Footer — di flow normal, tidak absolute --}}
        <div style="display:flex; align-items:center; justify-content:space-between; gap:8px;
                    flex-wrap:nowrap;">
            <div style="font-family:'Inter',sans-serif; font-size:10px;
                        color:rgba(255,255,255,0.38); flex:1; min-width:0;
                        overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                🤖 AI menganalisis
                <strong style="color:rgba(255,255,255,0.65);">{{ number_format($aiTotal) }}</strong>
                aspirasi hari ini
            </div>

            <div style="display:flex; align-items:center; gap:6px; flex:0 0 auto;">
                <button @click="prev()" aria-label="Sebelumnya"
                        style="width:24px; height:24px; border-radius:7px;
                               border:1px solid rgba(255,255,255,0.15);
                               background:rgba(255,255,255,0.08); color:rgba(255,255,255,0.6);
                               display:flex; align-items:center; justify-content:center;
                               cursor:pointer; font-size:14px; line-height:1; padding:0;">‹</button>
                <span style="font-family:'Inter',sans-serif; font-size:10px;
                             color:rgba(255,255,255,0.4); min-width:24px; text-align:center;">
                    <span x-text="current + 1"></span>/{{ $total }}
                </span>
                <button @click="next()" aria-label="Berikutnya"
                        style="width:24px; height:24px; border-radius:7px;
                               border:1px solid rgba(255,255,255,0.15);
                               background:rgba(255,255,255,0.08); color:rgba(255,255,255,0.6);
                               display:flex; align-items:center; justify-content:center;
                               cursor:pointer; font-size:14px; line-height:1; padding:0;">›</button>
            </div>
        </div>

    </div>
</section>

<style>
@keyframes pulse-dot {
    0%, 100% { opacity:1; box-shadow:0 0 0 3px rgba(239,68,68,0.25); }
    50%       { opacity:0.7; box-shadow:0 0 0 5px rgba(239,68,68,0.10); }
}
</style>
@endif
