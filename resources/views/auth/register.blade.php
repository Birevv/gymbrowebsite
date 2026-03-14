<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — GymBro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-slate-200 font-sans">

    <div class="w-full max-w-md bg-slate-800/80 backdrop-blur-xl border border-slate-600/30 rounded-2xl p-10 shadow-2xl">
        <h1 class="text-3xl font-extrabold text-center mb-1">🏋️ Gym<span class="text-blue-500">Bro</span></h1>
        <p class="text-center text-slate-400 text-sm mb-8">Buat akun baru dan mulai latihan</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Name --}}
            <div class="mb-5">
                <label for="name" class="block text-sm font-semibold text-slate-300 mb-1.5">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                       placeholder="Masukkan nama kamu" required autofocus
                       class="w-full px-4 py-3 bg-slate-900/60 border border-slate-600/40 rounded-xl text-slate-100 placeholder-slate-500 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Email --}}
            <div class="mb-5">
                <label for="email" class="block text-sm font-semibold text-slate-300 mb-1.5">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                       placeholder="contoh@email.com" required
                       class="w-full px-4 py-3 bg-slate-900/60 border border-slate-600/40 rounded-xl text-slate-100 placeholder-slate-500 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Password --}}
            <div class="mb-5">
                <label for="password" class="block text-sm font-semibold text-slate-300 mb-1.5">Password</label>
                <input type="password" id="password" name="password"
                       placeholder="Minimal 8 karakter" required
                       class="w-full px-4 py-3 bg-slate-900/60 border border-slate-600/40 rounded-xl text-slate-100 placeholder-slate-500 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                @error('password') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mb-5">
                <label for="password_confirmation" class="block text-sm font-semibold text-slate-300 mb-1.5">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       placeholder="Ulangi password" required
                       class="w-full px-4 py-3 bg-slate-900/60 border border-slate-600/40 rounded-xl text-slate-100 placeholder-slate-500 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
            </div>

            <button type="submit"
                    class="w-full py-3.5 mt-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded-xl cursor-pointer transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-blue-500/30 active:scale-[0.98]">
                Daftar Sekarang 🚀
            </button>
        </form>

        <p class="text-center mt-6 text-sm text-slate-400">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-500 font-semibold hover:underline">Login di sini</a>
        </p>
    </div>

</body>

</html>
