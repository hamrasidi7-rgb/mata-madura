{{--
    Banner anggaran (section utama setelah hero).
    Kartu menonjol berisi grid: label + ikon + nominal Rp.
    Props: $items = Collection<BudgetItem>
--}}
@props(['items' => collect(), 'title' => 'Transparansi Anggaran', 'subtitle' => 'APBD Kabupaten Sumenep 2026'])

<section class="px-[22px] pt-[22px] pb-[26px]">
    <div class="rounded-2xl border border-hair bg-white shadow-card overflow-hidden">
        <div class="flex items-center justify-between px-5 pt-5 pb-3">
            <div>
                <h2 class="font-serif text-[20px] font-semibold leading-tight text-ink-2">{{ $title }}</h2>
                <p class="text-[12px] text-muted mt-0.5">{{ $subtitle }}</p>
            </div>
            <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-accent/10 text-accent">
                <x-icon name="chart" class="w-5 h-5" />
            </span>
        </div>

        <div class="grid grid-cols-2 gap-px bg-hair">
            @foreach ($items as $item)
                <div class="bg-white px-5 py-4">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-cream text-warm">
                            <x-icon :name="$item->icon" class="w-4 h-4" />
                        </span>
                        <span class="text-[11px] font-bold uppercase tracking-wide text-muted">{{ $item->label }}</span>
                    </div>
                    <div class="font-serif text-[22px] font-semibold text-ink-2 leading-none">{{ $item->amount_short }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>
