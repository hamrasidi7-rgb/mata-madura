{{-- Kotak kecil aspirasi warga — pelengkap, bukan hero utama.
     Props: $aspirasi (Collection<Aspirasi>, max 3) --}}
@props(['aspirasi' => collect()])

@php
    $dotColor = ['green' => '#22c55e', 'yellow' => '#f59e0b', 'blue' => '#3b82f6', 'red' => '#ef4444'];
@endphp

<section class="px-[22px] py-[16px] border-b border-hair">
    <div class="border border-hair rounded-2xl overflow-hidden bg-white">

        {{-- Feed 3 aspirasi terakhir --}}
        <div class="divide-y divide-hair">
            @forelse ($aspirasi->take(3) as $item)
            <div class="flex items-center gap-3 px-4 py-3 min-w-0">
                <span style="width:8px; height:8px; border-radius:50%; flex:0 0 8px;
                             background:{{ $dotColor[$item->color] ?? '#9ca3af' }};"></span>
                <span style="font-family:'Inter',sans-serif; font-size:13px; color:#1a1816;
                             flex:1; min-width:0; overflow:hidden; text-overflow:ellipsis;
                             white-space:nowrap;">
                    {{ $item->title }}
                </span>
                <span style="font-family:'Inter',sans-serif; font-size:10.5px; color:#b0a89e;
                             flex:0 0 auto; white-space:nowrap;">
                    {{ $item->time_ago }}
                </span>
            </div>
            @empty
            <div class="px-4 py-3 text-[13px] text-muted">Belum ada aspirasi.</div>
            @endforelse
        </div>

        {{-- CTA kirim aspirasi --}}
        <a href="/aspirasi"
           class="flex items-center gap-2 px-4 py-3 bg-cream
                  hover:bg-hair transition text-[13px] font-semibold"
           style="color:#C0392B;">
            <span class="flex-1 min-w-0 overflow-hidden text-ellipsis whitespace-nowrap">
                Punya keluhan atau usulan? Sampaikan di sini
            </span>
            <span class="flex-none">→</span>
        </a>

    </div>
</section>
