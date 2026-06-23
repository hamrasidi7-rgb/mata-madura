<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin — mataGen AI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream min-h-screen flex items-center justify-center px-4">

<div class="w-full max-w-sm">

    {{-- Logo --}}
    <div class="text-center mb-8">
        <a href="{{ route('home') }}" class="inline-block font-extrabold text-[22px] tracking-tight text-ink">
            mata<span class="text-accent">Gen</span>
            <span class="ml-1 text-[11px] border-2 border-accent rounded px-1 align-middle">AI</span>
        </a>
        <p class="text-[13px] text-muted mt-1">Panel Redaksi</p>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-2xl shadow-card border border-hair px-8 py-8">

        <h1 class="text-[18px] font-extrabold text-ink mb-6">Masuk ke Admin</h1>

        {{-- Error --}}
        @if ($errors->any())
            <div class="mb-4 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-800 text-[13px]">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf

            {{-- Email --}}
            <div class="mb-4">
                <label class="block text-[12px] font-semibold text-ink-2 mb-1">EMAIL</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border border-hair rounded-lg px-3 py-2.5 text-[14px] text-ink focus:outline-none focus:ring-2 focus:ring-accent/40"
                       placeholder="admin@matagen.com"
                       autofocus required>
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label class="block text-[12px] font-semibold text-ink-2 mb-1">PASSWORD</label>
                <input type="password" name="password"
                       class="w-full border border-hair rounded-lg px-3 py-2.5 text-[14px] text-ink focus:outline-none focus:ring-2 focus:ring-accent/40"
                       placeholder="••••••••"
                       required>
            </div>

            {{-- Remember me --}}
            <label class="flex items-center gap-2 text-[13px] text-ink-2 mb-6 cursor-pointer">
                <input type="checkbox" name="remember" class="accent-accent">
                Ingat saya
            </label>

            <button type="submit"
                    class="w-full bg-accent text-white font-semibold py-2.5 rounded-lg text-[14px] hover:bg-accent/90 transition">
                Masuk
            </button>
        </form>

    </div>

    <p class="text-center text-[11px] text-muted mt-6">
        © {{ date('Y') }} mataGen AI
    </p>

</div>

</body>
</html>
