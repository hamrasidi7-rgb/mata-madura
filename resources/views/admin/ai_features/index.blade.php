@extends('admin.layout')

@section('title', 'Fitur AI')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="font-serif text-[26px] font-semibold text-ink-2">Fitur AI</h1>
            <p class="text-[13px] text-muted mt-1">Tambah, ubah, dan urutkan kartu Fitur AI di homepage. Seret untuk mengurutkan.</p>
        </div>
        <a href="{{ route('admin.ai-features.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-ink text-white text-[14px] font-semibold">
            <x-icon name="plus" class="w-4 h-4" /> Tambah
        </a>
    </div>

    <ul id="feature-list" class="flex flex-col gap-3">
        @forelse ($features as $feature)
            <li data-id="{{ $feature->id }}"
                class="flex items-center gap-3.5 px-4 py-3.5 rounded-2xl border border-hair bg-white shadow-soft">
                <span class="drag-handle cursor-grab text-muted select-none" title="Seret untuk urutkan">⠿</span>
                <span class="flex-none w-11 h-11 rounded-xl bg-cream text-warm flex items-center justify-center">
                    <x-icon :name="$feature->icon" class="w-5 h-5" />
                </span>
                <span class="flex-1 min-w-0">
                    <span class="block font-serif text-[16px] font-semibold text-ink-2">{{ $feature->title }}</span>
                    <span class="block text-[12.5px] text-muted truncate">{{ $feature->description }}</span>
                </span>
                @unless ($feature->is_active)
                    <span class="text-[11px] font-bold uppercase text-muted px-2 py-1 rounded bg-cream">Nonaktif</span>
                @endunless
                <a href="{{ route('admin.ai-features.edit', $feature) }}"
                   class="text-[13px] font-semibold text-accent px-3 py-1.5">Ubah</a>
                <form action="{{ route('admin.ai-features.destroy', $feature) }}" method="POST"
                      onsubmit="return confirm('Hapus fitur ini?')">
                    @csrf @method('DELETE')
                    <button class="text-[13px] font-semibold text-muted hover:text-accent px-2 py-1.5">Hapus</button>
                </form>
            </li>
        @empty
            <li class="px-4 py-10 text-center text-muted">Belum ada fitur AI. Klik “Tambah”.</li>
        @endforelse
    </ul>

    {{-- Drag-reorder (SortableJS via CDN). Memanggil endpoint reorder. --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <script>
        const list = document.getElementById('feature-list');
        if (list && window.Sortable) {
            Sortable.create(list, {
                handle: '.drag-handle',
                animation: 150,
                onEnd() {
                    const ids = [...list.querySelectorAll('[data-id]')].map(el => el.dataset.id);
                    fetch('{{ route('admin.ai-features.reorder') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ ids }),
                    });
                },
            });
        }
    </script>
@endsection
