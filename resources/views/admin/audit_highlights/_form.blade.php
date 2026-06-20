{{-- Form bersama create & edit. Terima: $highlight, $action, $method --}}
<form action="{{ $action }}" method="POST" class="flex flex-col gap-5 max-w-xl">
    @csrf
    @if (($method ?? 'POST') !== 'POST')
        @method($method)
    @endif

    <div class="grid grid-cols-2 gap-4">
        <div class="col-span-2">
            <label class="block text-[13px] font-semibold text-ink mb-1.5">
                Label <span class="text-accent">*</span>
            </label>
            <input type="text" name="label" value="{{ old('label', $highlight->label) }}" required
                   placeholder="mis. Total Paket RUP Teraudit"
                   class="w-full rounded-xl border-hair bg-white text-[14px] focus:border-warm focus:ring-warm/20">
            @error('label') <p class="text-[12px] text-accent mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-[13px] font-semibold text-ink mb-1.5">
                Nilai / Angka <span class="text-accent">*</span>
            </label>
            <input type="text" name="value" value="{{ old('value', $highlight->value) }}" required
                   placeholder="mis. 3.450 atau Rp 1,2 T"
                   class="w-full rounded-xl border-hair bg-white text-[14px] focus:border-warm focus:ring-warm/20">
            <p class="text-[12px] text-muted mt-1">String bebas — tulis persis seperti yang ingin ditampilkan.</p>
            @error('value') <p class="text-[12px] text-accent mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-[13px] font-semibold text-ink mb-1.5">Urutan</label>
            <input type="number" name="order" min="0" value="{{ old('order', $highlight->order ?? 0) }}"
                   class="w-full rounded-xl border-hair bg-white text-[14px] focus:border-warm focus:ring-warm/20">
        </div>
    </div>

    <label class="flex items-center gap-2.5 text-[14px]">
        <input type="checkbox" name="is_active" value="1"
               @checked(old('is_active', $highlight->is_active))
               class="rounded border-hair text-accent focus:ring-warm/20">
        Aktif (tampil di beranda)
    </label>

    <div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 text-[12px] text-amber-800">
        Hanya highlight berstatus aktif yang tampil di beranda.
        Disarankan menampilkan 3 angka agar strip rapi.
    </div>

    <div class="flex items-center gap-3 pt-2">
        <button class="px-5 py-2.5 rounded-xl bg-ink text-white text-[14px] font-semibold">Simpan</button>
        <a href="{{ route('admin.audit-highlights.index') }}" class="text-[14px] text-muted">Batal</a>
    </div>
</form>
