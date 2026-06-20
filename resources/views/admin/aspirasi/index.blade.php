@extends('admin.layout')
@section('title', 'Aspirasi Warga')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-serif text-[26px] font-semibold text-ink-2">Aspirasi Warga</h1>
        <p class="text-[13px] text-muted mt-1">Kelola aspirasi yang masuk dan ubah statusnya.</p>
    </div>
</div>

{{-- Filter tab status --}}
<div class="flex gap-1 text-[13px] font-semibold border border-hair rounded-lg overflow-hidden w-fit mb-5">
    @foreach (['' => 'Semua ('.$counts['all'].')', 'baru' => 'Baru ('.$counts['baru'].')', 'ditanggapi' => 'Ditanggapi ('.$counts['ditanggapi'].')', 'selesai' => 'Selesai ('.$counts['selesai'].')'] as $val => $label)
        <a href="{{ request()->fullUrlWithQuery(['status' => $val, 'page' => null]) }}"
           class="px-4 py-2 {{ request('status', '') === $val ? 'bg-accent text-white' : 'text-ink-2 hover:bg-cream' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

<div class="bg-white rounded-2xl border border-hair overflow-hidden shadow-soft">
    <table class="w-full text-[13px]">
        <thead class="bg-cream text-ink-2 font-semibold text-left">
            <tr>
                <th class="px-4 py-3 w-[40%]">Isi Aspirasi</th>
                <th class="px-4 py-3">Lokasi</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Waktu</th>
                <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-hair">
            @forelse ($aspirasi as $item)
            <tr class="{{ $item->is_active ? '' : 'opacity-50' }} hover:bg-cream/40 transition">
                <td class="px-4 py-3">
                    <div class="font-semibold text-ink line-clamp-2">{{ $item->title }}</div>
                    @unless ($item->is_active)
                        <span class="text-[10px] text-muted font-bold uppercase">Disembunyikan</span>
                    @endunless
                </td>
                <td class="px-4 py-3 text-ink-2">{{ $item->location ?: '—' }}</td>
                <td class="px-4 py-3">
                    {{-- Ganti status cepat --}}
                    <form action="{{ route('admin.aspirasi.update-status', $item) }}" method="POST">
                        @csrf @method('PATCH')
                        <select name="status" onchange="this.form.submit()"
                                class="text-[12px] rounded-lg border-hair bg-white py-1 pl-2 pr-6
                                       focus:border-accent focus:ring-accent/20
                                       {{ $item->status === 'baru' ? 'text-blue-700' : ($item->status === 'ditanggapi' ? 'text-amber-700' : 'text-green-700') }}">
                            <option value="baru"       @selected($item->status === 'baru')>🔵 Baru</option>
                            <option value="ditanggapi" @selected($item->status === 'ditanggapi')>🟡 Ditanggapi</option>
                            <option value="selesai"    @selected($item->status === 'selesai')>🟢 Selesai</option>
                        </select>
                    </form>
                </td>
                <td class="px-4 py-3 text-ink-2 whitespace-nowrap">{{ $item->time_ago }}</td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-2 justify-end">
                        {{-- Toggle tampil/sembunyikan --}}
                        <form action="{{ route('admin.aspirasi.toggle', $item) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="text-[12px] font-semibold text-muted hover:text-accent px-2 py-1.5"
                                    title="{{ $item->is_active ? 'Sembunyikan dari beranda' : 'Tampilkan di beranda' }}">
                                {{ $item->is_active ? '🙈' : '👁' }}
                            </button>
                        </form>
                        <a href="{{ route('admin.aspirasi.edit', $item) }}"
                           class="text-[13px] font-semibold text-accent px-2 py-1.5">Edit</a>
                        <form action="{{ route('admin.aspirasi.destroy', $item) }}" method="POST"
                              onsubmit="return confirm('Hapus aspirasi ini?')">
                            @csrf @method('DELETE')
                            <button class="text-[13px] font-semibold text-muted hover:text-accent px-2 py-1.5">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-10 text-center text-muted">Belum ada aspirasi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($aspirasi->hasPages())
    <div class="mt-5">{{ $aspirasi->links() }}</div>
@endif
@endsection
