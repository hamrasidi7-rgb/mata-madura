@extends('admin.layout')
@section('title', 'Strip Audit')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-serif text-[26px] font-semibold text-ink-2">Strip Audit</h1>
        <p class="text-[13px] text-muted mt-1">Kelola 3 angka yang tampil di strip ringkasan beranda.</p>
    </div>
    <a href="{{ route('admin.audit-highlights.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-ink text-white text-[14px] font-semibold">
        + Tambah
    </a>
</div>

<div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 text-[13px] text-amber-800 mb-5">
    Hanya highlight berstatus <strong>aktif</strong> yang tampil di beranda.
    Disarankan menampilkan <strong>3 angka</strong> agar strip rapi.
    Aktif saat ini: <strong>{{ $highlights->where('is_active', true)->count() }}</strong>
</div>

<ul class="flex flex-col gap-3">
    @forelse ($highlights as $h)
    <li class="flex items-center gap-3.5 px-4 py-3.5 rounded-2xl border border-hair bg-white shadow-soft">
        <span class="flex-none w-8 h-8 rounded-lg bg-cream text-ink-2 flex items-center justify-center
                     text-[12px] font-bold">
            {{ $h->order }}
        </span>
        <span class="flex-1 min-w-0">
            <span class="block text-[15px] font-bold text-accent">{{ $h->value }}</span>
            <span class="block text-[13px] text-ink-2 truncate">{{ $h->label }}</span>
        </span>
        @if ($h->is_active)
            <span class="text-[11px] font-bold uppercase text-green-700 px-2 py-1 rounded bg-green-50">Aktif</span>
        @else
            <span class="text-[11px] font-bold uppercase text-muted px-2 py-1 rounded bg-cream">Nonaktif</span>
        @endif
        <a href="{{ route('admin.audit-highlights.edit', $h) }}"
           class="text-[13px] font-semibold text-accent px-3 py-1.5">Ubah</a>
        <form action="{{ route('admin.audit-highlights.destroy', $h) }}" method="POST"
              onsubmit="return confirm('Hapus highlight ini?')">
            @csrf @method('DELETE')
            <button class="text-[13px] font-semibold text-muted hover:text-accent px-2 py-1.5">Hapus</button>
        </form>
    </li>
    @empty
    <li class="px-4 py-10 text-center text-muted">Belum ada data. Klik "Tambah".</li>
    @endforelse
</ul>
@endsection
