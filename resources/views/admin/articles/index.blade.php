@extends('admin.layout')
@section('title', 'Artikel')

@section('content')
<div x-data="{ deleteId: null, deleteTitle: '' }">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-extrabold text-ink tracking-tight">Artikel</h1>
        <a href="{{ route('admin.articles.create') }}"
           class="inline-flex items-center gap-2 bg-accent text-white text-[14px] font-semibold px-4 py-2 rounded-lg hover:bg-accent/90 transition">
            + Tulis Artikel Baru
        </a>
    </div>

    {{-- Filter tab + search --}}
    <div class="flex flex-col sm:flex-row gap-3 mb-5">
        <div class="flex gap-1 text-[13px] font-semibold border border-hair rounded-lg overflow-hidden w-fit">
            @foreach ([''=>'Semua ('.$counts['all'].')', 'published'=>'Published ('.$counts['published'].')', 'draft'=>'Draft ('.$counts['draft'].')'] as $val => $label)
                <a href="{{ request()->fullUrlWithQuery(['status' => $val, 'page' => null]) }}"
                   class="px-4 py-2 {{ request('status', '') === $val ? 'bg-accent text-white' : 'text-ink-2 hover:bg-cream' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <form method="GET" class="flex gap-2 flex-1 max-w-xs">
            @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
            <input type="text" name="q" value="{{ request('q') }}"
                   placeholder="Cari judul…"
                   class="flex-1 border border-hair rounded-lg px-3 py-2 text-[13px] focus:outline-none focus:ring-2 focus:ring-accent/40">
            <button class="px-3 py-2 bg-ink text-white rounded-lg text-[13px] hover:bg-ink/80">Cari</button>
            @if(request('q'))
                <a href="{{ request()->fullUrlWithQuery(['q' => null]) }}"
                   class="px-3 py-2 border border-hair rounded-lg text-[13px] text-ink-2 hover:bg-cream">×</a>
            @endif
        </form>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl border border-hair overflow-hidden shadow-card">
        <table class="w-full text-[13px]">
            <thead class="bg-cream text-ink-2 font-semibold text-left">
                <tr>
                    <th class="px-4 py-3 w-[38%]">Judul</th>
                    <th class="px-4 py-3">Penulis</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Views</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-hair">
                @forelse ($articles as $article)
                <tr class="hover:bg-cream/50 transition">
                    <td class="px-4 py-3">
                        <div class="font-semibold text-ink line-clamp-1">{{ $article->title }}</div>
                        @if($article->deck)
                            <div class="text-ink-2 text-[12px] line-clamp-1 mt-0.5">{{ $article->deck }}</div>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-ink-2 text-[12px]">
                        {{ $article->author_name ?: 'Redaksi mataGen' }}
                    </td>
                    <td class="px-4 py-3 text-ink-2">
                        {{ $article->category?->name ?? '—' }}
                    </td>
                    <td class="px-4 py-3">
                        @if($article->status === 'published')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-green-100 text-green-700">
                                ● Published
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-amber-100 text-amber-700">
                                ○ Draft
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right text-ink-2">{{ number_format($article->views ?? 0) }}</td>
                    <td class="px-4 py-3 text-ink-2 whitespace-nowrap">
                        {{ $article->created_at->format('d M Y') }}
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3 justify-end">
                            <a href="{{ route('admin.articles.edit', $article) }}"
                               class="text-ink-2 hover:text-accent font-semibold">Edit</a>
                            <button type="button"
                                    @click="deleteId = {{ $article->id }}; deleteTitle = {{ Js::from($article->title) }}"
                                    class="text-accent hover:text-accent/70 font-semibold">Hapus</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-12 text-center text-ink-2">
                        Belum ada artikel.
                        <a href="{{ route('admin.articles.create') }}" class="text-accent font-semibold ml-1">Tulis sekarang →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($articles->hasPages())
        <div class="mt-5">{{ $articles->links() }}</div>
    @endif

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
            <h3 class="font-extrabold text-ink text-[16px] mb-2">Hapus Artikel?</h3>
            <p class="text-ink-2 text-[13px] mb-5">
                "<span x-text="deleteTitle" class="font-semibold"></span>" akan dihapus permanen beserta gambarnya.
            </p>
            <div class="flex gap-3 justify-end">
                <button @click="deleteId = null"
                        class="px-4 py-2 border border-hair rounded-lg text-[13px] font-semibold text-ink-2 hover:bg-cream">
                    Batal
                </button>
                <form :action="'/admin/articles/' + deleteId" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 bg-accent text-white rounded-lg text-[13px] font-semibold hover:bg-accent/90">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
