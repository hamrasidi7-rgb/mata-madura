@extends('admin.layout')
@section('title', 'Kategori')

@section('content')
<div x-data="{
    showForm: false,
    mode: 'create',
    form: { id: null, name: '', description: '' },
    errors: {},
    storeUrl: '{{ route('admin.categories.store') }}',
    baseUrl: '{{ route('admin.categories.index') }}',

    openCreate() {
        this.mode = 'create';
        this.form = { id: null, name: '', description: '' };
        this.errors = {};
        this.showForm = true;
        this.$nextTick(() => this.$refs.nameInput.focus());
    },
    openEdit(id, name, description) {
        this.mode = 'edit';
        this.form = { id, name, description: description ?? '' };
        this.errors = {};
        this.showForm = true;
        this.$nextTick(() => this.$refs.nameInput.focus());
    },
    get actionUrl() {
        return this.mode === 'create' ? this.storeUrl : this.baseUrl + '/' + this.form.id;
    },

    deleteId: null,
    deleteName: '',
    deleteCount: 0,
    openDelete(id, name, count) {
        this.deleteId = id;
        this.deleteName = name;
        this.deleteCount = count;
    },
    get deleteUrl() {
        return this.baseUrl + '/' + this.deleteId;
    }
}">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-extrabold text-ink tracking-tight">Kategori</h1>
        <button @click="openCreate()"
                class="inline-flex items-center gap-2 bg-accent text-white text-[14px] font-semibold px-4 py-2 rounded-lg hover:bg-accent/90 transition">
            + Tambah Kategori
        </button>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl border border-hair overflow-hidden shadow-card">
        <table class="w-full text-[13px]">
            <thead class="bg-cream text-ink-2 font-semibold text-left">
                <tr>
                    <th class="px-4 py-3 w-[35%]">Nama</th>
                    <th class="px-4 py-3">Slug</th>
                    <th class="px-4 py-3">Deskripsi</th>
                    <th class="px-4 py-3 text-center">Artikel</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-hair">
                @forelse ($categories as $cat)
                <tr class="hover:bg-cream/50 transition">
                    <td class="px-4 py-3 font-semibold text-ink">{{ $cat->name }}</td>
                    <td class="px-4 py-3 text-muted font-mono text-[12px]">{{ $cat->slug }}</td>
                    <td class="px-4 py-3 text-ink-2 line-clamp-1">{{ $cat->description ?: '—' }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="inline-block px-2 py-0.5 rounded-full text-[11px] font-semibold
                                     {{ $cat->articles_count > 0 ? 'bg-accent/10 text-accent' : 'bg-hair text-muted' }}">
                            {{ $cat->articles_count }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3 justify-end">
                            <button type="button"
                                    @click="openEdit({{ $cat->id }}, {{ Js::from($cat->name) }}, {{ Js::from($cat->description) }})"
                                    class="text-ink-2 hover:text-accent font-semibold">
                                Edit
                            </button>
                            <button type="button"
                                    @click="openDelete({{ $cat->id }}, {{ Js::from($cat->name) }}, {{ $cat->articles_count }})"
                                    class="text-accent hover:text-accent/70 font-semibold">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-12 text-center text-ink-2">
                        Belum ada kategori.
                        <button @click="openCreate()" class="text-accent font-semibold ml-1">Tambah sekarang →</button>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal form (create / edit) --}}
    <div x-show="showForm"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
         @keydown.escape.window="showForm = false"
         style="display:none">

        <div @click.outside="showForm = false"
             class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md mx-4">

            <h3 class="font-extrabold text-ink text-[16px] mb-5"
                x-text="mode === 'create' ? 'Tambah Kategori' : 'Edit Kategori'">
            </h3>

            <form :action="actionUrl" method="POST" @submit="showForm = false">
                @csrf
                <input type="hidden" name="_method" :value="mode === 'edit' ? 'PUT' : 'POST'">

                {{-- Nama --}}
                <div class="mb-4">
                    <label class="block text-[12px] font-semibold text-ink-2 mb-1">
                        NAMA KATEGORI <span class="text-accent">*</span>
                    </label>
                    <input type="text" name="name" x-model="form.name" x-ref="nameInput"
                           class="w-full border border-hair rounded-lg px-3 py-2 text-[14px] text-ink focus:outline-none focus:ring-2 focus:ring-accent/40"
                           placeholder="Contoh: Politik, Ekonomi, Olahraga…"
                           required maxlength="100">
                    @error('name')
                        <p class="text-[11px] text-accent mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="mb-5">
                    <label class="block text-[12px] font-semibold text-ink-2 mb-1">DESKRIPSI</label>
                    <textarea name="description" x-model="form.description" rows="3"
                              class="w-full border border-hair rounded-lg px-3 py-2 text-[13px] text-ink resize-none focus:outline-none focus:ring-2 focus:ring-accent/40"
                              placeholder="Deskripsi singkat kategori (opsional)…"
                              maxlength="255"></textarea>
                </div>

                <p class="text-[11px] text-muted mb-5">Slug dibuat otomatis dari nama.</p>

                <div class="flex gap-3 justify-end">
                    <button type="button" @click="showForm = false"
                            class="px-4 py-2 border border-hair rounded-lg text-[13px] font-semibold text-ink-2 hover:bg-cream">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-accent text-white rounded-lg text-[13px] font-semibold hover:bg-accent/90">
                        <span x-text="mode === 'create' ? 'Tambah' : 'Simpan'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal konfirmasi hapus --}}
    <div x-show="deleteId !== null"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
         @keydown.escape.window="deleteId = null"
         style="display:none">

        <div @click.outside="deleteId = null"
             class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm mx-4">

            <h3 class="font-extrabold text-ink text-[16px] mb-2">Hapus Kategori?</h3>

            <template x-if="deleteCount > 0">
                <div class="mb-4 px-3 py-2 bg-amber-50 border border-amber-200 rounded-lg text-[13px] text-amber-800">
                    Kategori "<span x-text="deleteName" class="font-semibold"></span>" masih memiliki
                    <span x-text="deleteCount" class="font-semibold"></span> artikel —
                    tidak bisa dihapus. Pindahkan artikel terlebih dahulu.
                </div>
            </template>

            <template x-if="deleteCount === 0">
                <p class="text-ink-2 text-[13px] mb-5">
                    Kategori "<span x-text="deleteName" class="font-semibold"></span>" akan dihapus permanen.
                </p>
            </template>

            <div class="flex gap-3 justify-end mt-4">
                <button @click="deleteId = null"
                        class="px-4 py-2 border border-hair rounded-lg text-[13px] font-semibold text-ink-2 hover:bg-cream">
                    {{ __('Tutup') }}
                </button>
                <template x-if="deleteCount === 0">
                    <form :action="deleteUrl" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 bg-accent text-white rounded-lg text-[13px] font-semibold hover:bg-accent/90">
                            Ya, Hapus
                        </button>
                    </form>
                </template>
            </div>
        </div>
    </div>

</div>
@endsection
