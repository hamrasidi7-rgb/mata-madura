@extends('admin.layout')
@section('title', 'Edit Artikel')

@section('content')
<div x-data="{
    slug: '{{ old('slug', $article->slug) }}',
    slugEdited: true,
    imagePreview: null,
    makeSlug(str) {
        return str.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .trim().replace(/\s+/g, '-')
    },
    onTitleInput(val) {
        if (!this.slugEdited) this.slug = this.makeSlug(val)
    }
}">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.articles.index') }}" class="text-ink-2 hover:text-accent text-[13px]">← Kembali</a>
        <h1 class="text-2xl font-extrabold text-ink tracking-tight">Edit Artikel</h1>
    </div>

    @if ($errors->any())
        <div class="mb-5 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-800 text-[13px]">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Kolom kiri: konten utama --}}
            <div class="lg:col-span-2 flex flex-col gap-5">

                {{-- Judul --}}
                <div class="bg-white rounded-2xl border border-hair p-5 shadow-card">
                    <label class="block text-[12px] font-semibold text-ink-2 mb-1">JUDUL <span class="text-accent">*</span></label>
                    <input type="text" name="title"
                           @input="onTitleInput($event.target.value)"
                           class="w-full text-[20px] font-extrabold text-ink border-none outline-none placeholder:text-hair"
                           placeholder="Judul artikel…"
                           value="{{ old('title', $article->title) }}" required>

                    <div class="mt-3 pt-3 border-t border-hair">
                        <label class="block text-[11px] font-semibold text-ink-2 mb-1">SLUG URL</label>
                        <div class="flex items-center gap-2">
                            <span class="text-[12px] text-muted">/berita/</span>
                            <input type="text" name="slug"
                                   x-model="slug"
                                   @input="slugEdited = true"
                                   class="flex-1 text-[12px] text-ink border border-hair rounded-lg px-2 py-1 focus:outline-none focus:ring-2 focus:ring-accent/40">
                        </div>
                    </div>
                </div>

                {{-- Ringkasan --}}
                <div class="bg-white rounded-2xl border border-hair p-5 shadow-card">
                    <label class="block text-[12px] font-semibold text-ink-2 mb-1">RINGKASAN (EXCERPT)</label>
                    <textarea name="deck" rows="3"
                              class="w-full text-[14px] text-ink border-none outline-none resize-none placeholder:text-hair"
                              placeholder="Deskripsi singkat…">{{ old('deck', $article->deck) }}</textarea>
                </div>

                {{-- Konten --}}
                <div class="bg-white rounded-2xl border border-hair p-5 shadow-card">
                    <label class="block text-[12px] font-semibold text-ink-2 mb-1">KONTEN <span class="text-accent">*</span></label>
                    <textarea name="body" rows="20"
                              class="w-full text-[14px] text-ink border-none outline-none resize-y placeholder:text-hair font-mono"
                              placeholder="Isi artikel…" required>{{ old('body', $article->body) }}</textarea>
                </div>

            </div>

            {{-- Kolom kanan: metadata --}}
            <div class="flex flex-col gap-5">

                {{-- Publish --}}
                <div class="bg-white rounded-2xl border border-hair p-5 shadow-card">
                    <h3 class="text-[12px] font-semibold text-ink-2 mb-3">PUBLIKASI</h3>

                    @if($article->published_at)
                        <p class="text-[11px] text-muted mb-2">
                            Diterbitkan {{ $article->published_at->format('d M Y, H:i') }}
                        </p>
                    @endif

                    <label class="block text-[12px] text-ink-2 mb-1">Status</label>
                    <select name="status"
                            class="w-full border border-hair rounded-lg px-3 py-2 text-[13px] text-ink mb-4 focus:outline-none focus:ring-2 focus:ring-accent/40">
                        <option value="draft" {{ old('status', $article->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $article->status) === 'published' ? 'selected' : '' }}>Published</option>
                    </select>

                    <div class="flex gap-3">
                        <a href="{{ route('admin.articles.index') }}"
                           class="flex-1 text-center px-4 py-2 border border-hair rounded-lg text-[13px] font-semibold text-ink-2 hover:bg-cream">
                            Batal
                        </a>
                        <button type="submit"
                                class="flex-1 px-4 py-2 bg-accent text-white rounded-lg text-[13px] font-semibold hover:bg-accent/90">
                            Perbarui
                        </button>
                    </div>
                </div>

                {{-- Kategori & Meta --}}
                <div class="bg-white rounded-2xl border border-hair p-5 shadow-card flex flex-col gap-4">
                    <h3 class="text-[12px] font-semibold text-ink-2">KATEGORI & PENULIS</h3>

                    <div>
                        <label class="block text-[12px] text-ink-2 mb-1">Kategori <span class="text-accent">*</span></label>
                        <select name="category_id"
                                class="w-full border border-hair rounded-lg px-3 py-2 text-[13px] text-ink focus:outline-none focus:ring-2 focus:ring-accent/40" required>
                            <option value="">— Pilih kategori —</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $article->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[12px] text-ink-2 mb-1">Penulis</label>
                        <input type="text" name="author" value="{{ old('author', $article->author) }}"
                               class="w-full border border-hair rounded-lg px-3 py-2 text-[13px] text-ink focus:outline-none focus:ring-2 focus:ring-accent/40"
                               placeholder="Nama penulis">
                    </div>

                    <div>
                        <label class="block text-[12px] text-ink-2 mb-1">Estimasi baca (menit)</label>
                        <input type="number" name="read_minutes" value="{{ old('read_minutes', $article->read_minutes) }}" min="1" max="60"
                               class="w-full border border-hair rounded-lg px-3 py-2 text-[13px] text-ink focus:outline-none focus:ring-2 focus:ring-accent/40">
                    </div>
                </div>

                {{-- Gambar --}}
                <div class="bg-white rounded-2xl border border-hair p-5 shadow-card" x-data="{ preview: null }">
                    <h3 class="text-[12px] font-semibold text-ink-2 mb-3">FOTO UTAMA</h3>

                    {{-- Gambar saat ini --}}
                    @if($article->image_path)
                        <div x-show="!preview" class="mb-3">
                            <img src="{{ Storage::url($article->image_path) }}"
                                 class="w-full h-36 object-cover rounded-lg">
                            <p class="text-[11px] text-muted mt-1">Gambar saat ini</p>
                        </div>
                    @endif

                    <div x-show="preview" class="mb-3">
                        <img :src="preview" class="w-full h-36 object-cover rounded-lg">
                        <p class="text-[11px] text-muted mt-1">Preview gambar baru</p>
                    </div>

                    <label class="block w-full cursor-pointer border-2 border-dashed border-hair rounded-lg p-4 text-center text-[12px] text-ink-2 hover:border-accent transition">
                        <span>{{ $article->image_path ? 'Ganti gambar' : 'Upload gambar' }}</span>
                        <input type="file" name="image" accept="image/*" class="hidden"
                               @change="preview = URL.createObjectURL($event.target.files[0])">
                    </label>
                    <p class="text-[11px] text-muted mt-1">JPG/PNG, maks 2 MB</p>
                </div>

                {{-- Flag --}}
                <div class="bg-white rounded-2xl border border-hair p-5 shadow-card">
                    <h3 class="text-[12px] font-semibold text-ink-2 mb-3">FLAG</h3>
                    <label class="flex items-center gap-2 text-[13px] text-ink cursor-pointer mb-2">
                        <input type="checkbox" name="is_featured" value="1"
                               {{ old('is_featured', $article->is_featured) ? 'checked' : '' }}
                               class="accent-accent">
                        Sorotan Utama
                    </label>
                    <label class="flex items-center gap-2 text-[13px] text-ink cursor-pointer">
                        <input type="checkbox" name="is_trending" value="1"
                               {{ old('is_trending', $article->is_trending) ? 'checked' : '' }}
                               class="accent-accent">
                        Trending
                    </label>
                </div>

            </div>
        </div>
    </form>

</div>
@endsection
