@extends('admin.layout')
@section('title', 'Edit Aspirasi')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.aspirasi.index') }}"
       class="text-[13px] text-muted hover:text-accent">← Kembali</a>
    <h1 class="font-serif text-[26px] font-semibold text-ink-2 mt-1">Edit Aspirasi</h1>
</div>

@if ($errors->any())
    <div class="mb-5 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-800 text-[13px]">
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.aspirasi.update', $aspirasi) }}" method="POST"
      class="flex flex-col gap-5 max-w-xl">
    @csrf @method('PUT')

    <div>
        <label class="block text-[13px] font-semibold text-ink mb-1.5">
            Isi Aspirasi <span class="text-accent">*</span>
        </label>
        <textarea name="title" rows="3" required
                  class="w-full rounded-xl border-hair bg-white text-[14px] focus:border-warm focus:ring-warm/20">{{ old('title', $aspirasi->title) }}</textarea>
        @error('title') <p class="text-[12px] text-accent mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-[13px] font-semibold text-ink mb-1.5">Lokasi</label>
        <input type="text" name="location" value="{{ old('location', $aspirasi->location) }}"
               placeholder="mis. Sumenep Kota, Kec. Pragaan"
               class="w-full rounded-xl border-hair bg-white text-[14px] focus:border-warm focus:ring-warm/20">
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-[13px] font-semibold text-ink mb-1.5">Status</label>
            <select name="status"
                    class="w-full rounded-xl border-hair bg-white text-[14px] focus:border-warm focus:ring-warm/20">
                <option value="baru"       @selected(old('status', $aspirasi->status) === 'baru')>🔵 Baru</option>
                <option value="ditanggapi" @selected(old('status', $aspirasi->status) === 'ditanggapi')>🟡 Ditanggapi</option>
                <option value="selesai"    @selected(old('status', $aspirasi->status) === 'selesai')>🟢 Selesai</option>
            </select>
        </div>
        <div>
            <label class="block text-[13px] font-semibold text-ink mb-1.5">Warna ikon di beranda</label>
            <select name="color"
                    class="w-full rounded-xl border-hair bg-white text-[14px] focus:border-warm focus:ring-warm/20">
                <option value="green"  @selected(old('color', $aspirasi->color) === 'green')>🟢 Hijau</option>
                <option value="yellow" @selected(old('color', $aspirasi->color) === 'yellow')>🟡 Kuning</option>
                <option value="blue"   @selected(old('color', $aspirasi->color) === 'blue')>🔵 Biru</option>
                <option value="red"    @selected(old('color', $aspirasi->color) === 'red')>🔴 Merah</option>
            </select>
        </div>
    </div>

    <label class="flex items-center gap-2.5 text-[14px]">
        <input type="checkbox" name="is_active" value="1"
               @checked(old('is_active', $aspirasi->is_active))
               class="rounded border-hair text-accent focus:ring-warm/20">
        Tampilkan di beranda
    </label>

    <div class="flex items-center gap-3 pt-2">
        <button class="px-5 py-2.5 rounded-xl bg-ink text-white text-[14px] font-semibold">Simpan</button>
        <a href="{{ route('admin.aspirasi.index') }}" class="text-[14px] text-muted">Batal</a>
    </div>
</form>
@endsection
