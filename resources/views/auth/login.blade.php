<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — GymBro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-slate-200 font-sans">

    <div class="w-full max-w-md bg-slate-800/80 backdrop-blur-xl border border-slate-600/30 rounded-2xl p-10 shadow-2xl">
        <h1 class="text-3xl font-extrabold text-center mb-1">🏋️ Gym<span class="text-blue-500">Bro</span></h1>
        <p class="text-center text-slate-400 text-sm mb-8">Masuk ke akun kamu</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div class="mb-5">
                <label for="email" class="block text-sm font-semibold text-slate-300 mb-1.5">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                       placeholder="contoh@email.com" required autofocus
                       class="w-full px-4 py-3 bg-slate-900/60 border border-slate-600/40 rounded-xl text-slate-100 placeholder-slate-500 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Password --}}
            <div class="mb-5">
                <label for="password" class="block text-sm font-semibold text-slate-300 mb-1.5">Password</label>
                <input type="password" id="password" name="password"
                       placeholder="Masukkan password" required
                       class="w-full px-4 py-3 bg-slate-900/60 border border-slate-600/40 rounded-xl text-slate-100 placeholder-slate-500 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                @error('password') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center gap-2 mb-5">
                <input type="checkbox" id="remember" name="remember"
                       class="w-4 h-4 accent-blue-500 rounded">
                <label for="remember" class="text-sm text-slate-400 cursor-pointer">Ingat saya</label>
            </div>

            <button type="submit"
                    class="w-full py-3.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded-xl cursor-pointer transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-blue-500/30 active:scale-[0.98]">
                Login 💪
            </button>
        </form>

        <p class="text-center mt-6 text-sm text-slate-400">
            Belum punya akun? <a href="{{ route('register') }}" class="text-blue-500 font-semibold hover:underline">Daftar gratis</a>
        </p>
    </div>

</body>

</html>
