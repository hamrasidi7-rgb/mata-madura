{{-- Form fields bersama untuk create & edit. $feature, $action, $method --}}
<form action="{{ $action }}" method="POST" class="flex flex-col gap-5 max-w-xl">
    @csrf
    @if (($method ?? 'POST') !== 'POST')
        @method($method)
    @endif

    <div>
        <label class="block text-[13px] font-semibold text-ink mb-1.5">Judul</label>
        <input type="text" name="title" value="{{ old('title', $feature->title) }}" required
               class="w-full rounded-xl border-hair bg-white text-[14px] focus:border-warm focus:ring-warm/20">
        @error('title') <p class="text-[12px] text-accent mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-[13px] font-semibold text-ink mb-1.5">Deskripsi</label>
        <textarea name="description" rows="2" required
                  class="w-full rounded-xl border-hair bg-white text-[14px] focus:border-warm focus:ring-warm/20">{{ old('description', $feature->description) }}</textarea>
        @error('description') <p class="text-[12px] text-accent mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-[13px] font-semibold text-ink mb-1.5">Ikon</label>
            <select name="icon"
                    class="w-full rounded-xl border-hair bg-white text-[14px] focus:border-warm focus:ring-warm/20">
                @foreach (['chart' => 'Chart / Tren', 'person' => 'Person / Tokoh', 'sparkles' => 'Sparkles', 'book' => 'Book', 'users' => 'Users', 'heart' => 'Heart'] as $val => $label)
                    <option value="{{ $val }}" @selected(old('icon', $feature->icon) === $val)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-[13px] font-semibold text-ink mb-1.5">Urutan</label>
            <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $feature->sort_order ?? 0) }}"
                   class="w-full rounded-xl border-hair bg-white text-[14px] focus:border-warm focus:ring-warm/20">
        </div>
    </div>

    <div>
        <label class="block text-[13px] font-semibold text-ink mb-1.5">Route atau URL</label>
        <input type="text" name="route_or_url" value="{{ old('route_or_url', $feature->route_or_url) }}"
               placeholder="mis. ai.trends  atau  https://…"
               class="w-full rounded-xl border-hair bg-white text-[14px] focus:border-warm focus:ring-warm/20">
        <p class="text-[12px] text-muted mt-1">Boleh nama route Laravel (jika terdaftar) atau URL penuh.</p>
    </div>

    <label class="flex items-center gap-2.5 text-[14px]">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $feature->is_active))
               class="rounded border-hair text-accent focus:ring-warm/20">
        Aktif (tampil di homepage)
    </label>

    <div class="flex items-center gap-3 pt-2">
        <button class="px-5 py-2.5 rounded-xl bg-ink text-white text-[14px] font-semibold">Simpan</button>
        <a href="{{ route('admin.ai-features.index') }}" class="text-[14px] text-muted">Batal</a>
    </div>
</form>
