@extends('admin.layout')
@section('title', 'Profil')

@section('content')
<div class="max-w-xl">

    <h1 class="text-2xl font-extrabold text-ink tracking-tight mb-6">Profil & Password</h1>

    {{-- === SECTION 1: Nama & Email === --}}
    <div class="bg-white rounded-2xl border border-hair shadow-card p-6 mb-6">
        <h2 class="text-[13px] font-semibold text-ink-2 mb-4">INFORMASI AKUN</h2>

        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-[12px] font-semibold text-ink-2 mb-1">NAMA</label>
                <input type="text" name="name"
                       value="{{ old('name', $user->name) }}"
                       class="w-full border border-hair rounded-lg px-3 py-2 text-[14px] text-ink focus:outline-none focus:ring-2 focus:ring-accent/40"
                       required maxlength="100">
                @error('name')
                    <p class="text-[11px] text-accent mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-[12px] font-semibold text-ink-2 mb-1">EMAIL</label>
                <input type="email" name="email"
                       value="{{ old('email', $user->email) }}"
                       class="w-full border border-hair rounded-lg px-3 py-2 text-[14px] text-ink focus:outline-none focus:ring-2 focus:ring-accent/40"
                       required maxlength="255">
                @error('email')
                    <p class="text-[11px] text-accent mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="px-5 py-2 bg-accent text-white rounded-lg text-[13px] font-semibold hover:bg-accent/90 transition">
                Simpan Perubahan
            </button>
        </form>
    </div>

    {{-- === SECTION 2: Ganti Password === --}}
    <div class="bg-white rounded-2xl border border-hair shadow-card p-6">
        <h2 class="text-[13px] font-semibold text-ink-2 mb-4">GANTI PASSWORD</h2>

        <form action="{{ route('admin.profile.password') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-[12px] font-semibold text-ink-2 mb-1">PASSWORD LAMA</label>
                <input type="password" name="current_password"
                       class="w-full border border-hair rounded-lg px-3 py-2 text-[14px] text-ink focus:outline-none focus:ring-2 focus:ring-accent/40"
                       placeholder="••••••••" required>
                @error('current_password')
                    <p class="text-[11px] text-accent mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-[12px] font-semibold text-ink-2 mb-1">PASSWORD BARU</label>
                <input type="password" name="password"
                       class="w-full border border-hair rounded-lg px-3 py-2 text-[14px] text-ink focus:outline-none focus:ring-2 focus:ring-accent/40"
                       placeholder="Min. 8 karakter" required>
                @error('password')
                    <p class="text-[11px] text-accent mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-[12px] font-semibold text-ink-2 mb-1">KONFIRMASI PASSWORD BARU</label>
                <input type="password" name="password_confirmation"
                       class="w-full border border-hair rounded-lg px-3 py-2 text-[14px] text-ink focus:outline-none focus:ring-2 focus:ring-accent/40"
                       placeholder="Ulangi password baru" required>
            </div>

            <button type="submit"
                    class="px-5 py-2 bg-ink text-white rounded-lg text-[13px] font-semibold hover:bg-ink/80 transition">
                Ubah Password
            </button>
        </form>
    </div>

</div>
@endsection
