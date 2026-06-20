@extends('admin.layout')
@section('title', 'Moderasi Aspirasi')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-serif text-[26px] font-semibold text-ink-2">Moderasi Aspirasi</h1>
        <p class="text-[13px] text-muted mt-1">Tinjau aspirasi warga sebelum ditampilkan di beranda.</p>
    </div>
</div>

{{-- Tab moderasi --}}
<div class="flex gap-1 text-[13px] font-semibold border border-hair rounded-lg overflow-hidden w-fit mb-5">
    @foreach ([
        'pending'  => ['label' => 'Menunggu', 'count' => $counts['pending'],  'color' => 'text-amber-700'],
        'approved' => ['label' => 'Disetujui','count' => $counts['approved'], 'color' => 'text-green-700'],
        'rejected' => ['label' => 'Ditolak',  'count' => $counts['rejected'], 'color' => 'text-red-700'],
    ] as $val => $cfg)
        <a href="{{ request()->fullUrlWithQuery(['mod' => $val, 'page' => null]) }}"
           class="px-4 py-2 flex items-center gap-1.5
                  {{ $mod === $val ? 'bg-accent text-white' : 'text-ink-2 hover:bg-cream' }}">
            {{ $cfg['label'] }}
            @if ($cfg['count'] > 0)
                <span class="text-[11px] font-bold px-1.5 py-0.5 rounded-full
                             {{ $mod === $val ? 'bg-white/30' : 'bg-cream' }}">
                    {{ $cfg['count'] }}
                </span>
            @endif
        </a>
    @endforeach
</div>

@if ($mod === 'pending' && $counts['pending'] === 0)
    <div class="px-4 py-10 text-center text-muted rounded-2xl border border-hair bg-white">
        ✅ Tidak ada aspirasi yang menunggu moderasi.
    </div>
@else

{{-- Modal tolak (Alpine) --}}
<div x-data="{ open: false, id: null, title: '' }"
     @keydown.escape.window="open = false">

    {{-- Tabel aspirasi --}}
    <div class="bg-white rounded-2xl border border-hair overflow-hidden shadow-soft">
        <table class="w-full text-[13px]">
            <thead class="bg-cream text-ink-2 font-semibold text-left">
                <tr>
                    <th class="px-4 py-3 w-[40%]">Aspirasi</th>
                    <th class="px-4 py-3">Lokasi</th>
                    <th class="px-4 py-3">Waktu</th>
                    @if ($mod === 'approved')
                        <th class="px-4 py-3">Status</th>
                    @endif
                    @if ($mod === 'rejected')
                        <th class="px-4 py-3">Alasan Tolak</th>
                    @endif
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-hair">
                @forelse ($aspirasi as $item)
                <tr class="hover:bg-cream/40 transition">
                    <td class="px-4 py-3">
                        <div class="font-semibold text-ink line-clamp-2">{{ $item->title }}</div>
                    </td>
                    <td class="px-4 py-3 text-ink-2">{{ $item->location ?: '—' }}</td>
                    <td class="px-4 py-3 text-ink-2 whitespace-nowrap">{{ $item->time_ago }}</td>

                    @if ($mod === 'approved')
                    <td class="px-4 py-3">
                        <form action="{{ route('admin.aspirasi.update-status', $item) }}" method="POST">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()"
                                    class="text-[12px] rounded-lg border-hair bg-white py-1 pl-2 pr-6">
                                <option value="baru"       @selected($item->status === 'baru')>🔵 Baru</option>
                                <option value="ditanggapi" @selected($item->status === 'ditanggapi')>🟡 Ditanggapi</option>
                                <option value="selesai"    @selected($item->status === 'selesai')>🟢 Selesai</option>
                            </select>
                        </form>
                    </td>
                    @endif

                    @if ($mod === 'rejected')
                    <td class="px-4 py-3 text-ink-2 text-[12px] italic">
                        {{ $item->rejection_reason ?: '—' }}
                    </td>
                    @endif

                    <td class="px-4 py-3">
                        <div class="flex items-center gap-1 justify-end flex-wrap">

                            @if ($mod === 'pending')
                                {{-- Setujui --}}
                                <form action="{{ route('admin.aspirasi.approve', $item) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="px-3 py-1.5 rounded-lg bg-green-600 text-white text-[12px] font-semibold hover:bg-green-700">
                                        Setujui
                                    </button>
                                </form>
                                {{-- Tolak (buka modal) --}}
                                <button type="button"
                                        @click="open = true; id = {{ $item->id }}; title = {{ Js::from(Str::limit($item->title, 50)) }}"
                                        class="px-3 py-1.5 rounded-lg border border-red-200 text-red-600 text-[12px] font-semibold hover:bg-red-50">
                                    Tolak
                                </button>
                                {{-- Edit --}}
                                <a href="{{ route('admin.aspirasi.edit', $item) }}"
                                   class="text-[12px] font-semibold text-accent px-2 py-1.5">Edit</a>
                            @endif

                            @if ($mod === 'approved')
                                {{-- Toggle tampil --}}
                                <form action="{{ route('admin.aspirasi.toggle', $item) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="text-[12px] font-semibold text-muted hover:text-accent px-2 py-1.5"
                                            title="{{ $item->is_active ? 'Sembunyikan' : 'Tampilkan' }}">
                                        {{ $item->is_active ? '🙈 Sembunyikan' : '👁 Tampilkan' }}
                                    </button>
                                </form>
                                {{-- Kembali pending --}}
                                <form action="{{ route('admin.aspirasi.pending', $item) }}" method="POST"
                                      onsubmit="return confirm('Kembalikan ke antrian pending?')">
                                    @csrf @method('PATCH')
                                    <button class="text-[12px] font-semibold text-muted hover:text-accent px-2 py-1.5">
                                        Pending
                                    </button>
                                </form>
                                {{-- Tolak --}}
                                <button type="button"
                                        @click="open = true; id = {{ $item->id }}; title = {{ Js::from(Str::limit($item->title, 50)) }}"
                                        class="text-[12px] font-semibold text-red-500 hover:text-red-700 px-2 py-1.5">
                                    Tolak
                                </button>
                            @endif

                            @if ($mod === 'rejected')
                                {{-- Setujui ulang --}}
                                <form action="{{ route('admin.aspirasi.approve', $item) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="px-3 py-1.5 rounded-lg bg-green-600 text-white text-[12px] font-semibold hover:bg-green-700">
                                        Setujui
                                    </button>
                                </form>
                                {{-- Kembali pending --}}
                                <form action="{{ route('admin.aspirasi.pending', $item) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="text-[12px] font-semibold text-muted hover:text-accent px-2 py-1.5">
                                        Pending
                                    </button>
                                </form>
                                {{-- Hapus permanen --}}
                                <form action="{{ route('admin.aspirasi.destroy', $item) }}" method="POST"
                                      onsubmit="return confirm('Hapus permanen aspirasi ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-[12px] font-semibold text-red-500 hover:text-red-700 px-2 py-1.5">
                                        Hapus
                                    </button>
                                </form>
                            @endif

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-10 text-center text-muted">Tidak ada aspirasi di tab ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($aspirasi->hasPages())
        <div class="mt-5">{{ $aspirasi->links() }}</div>
    @endif

    {{-- Modal tolak dengan alasan --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4"
         style="display:none">
        <div @click.outside="open = false"
             class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm">
            <h3 class="font-semibold text-ink text-[16px] mb-1">Tolak Aspirasi</h3>
            <p class="text-[12px] text-muted mb-4" x-text="'\"' + title + '\"'"></p>

            <form :action="'/admin/aspirasi/' + id + '/reject'" method="POST">
                @csrf @method('PATCH')
                <div class="mb-4">
                    <label class="block text-[12px] font-semibold text-ink mb-1.5">
                        Alasan penolakan <span class="text-muted font-normal">(opsional, untuk arsip internal)</span>
                    </label>
                    <input type="text" name="rejection_reason"
                           placeholder="mis. mengandung data pribadi, tidak relevan…"
                           class="w-full rounded-xl border-hair bg-white text-[13px] focus:border-warm focus:ring-warm/20">
                </div>
                <div class="flex gap-3 justify-end">
                    <button type="button" @click="open = false"
                            class="px-4 py-2 border border-hair rounded-lg text-[13px] text-ink-2 hover:bg-cream">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg text-[13px] font-semibold hover:bg-red-700">
                        Ya, Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endif
@endsection
