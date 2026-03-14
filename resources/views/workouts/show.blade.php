<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $exercise->name }} — GymBro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-slate-200 font-sans">

    {{-- Navbar --}}
    <header class="flex justify-between items-center px-8 py-4 bg-slate-950/80 backdrop-blur-xl border-b border-slate-700/20">
        <div class="text-xl font-extrabold">🏋️ Gym<span class="text-blue-500">Bro</span></div>
        <nav class="flex gap-6">
            <a href="{{ route('dashboard') }}" class="text-slate-400 text-sm font-medium hover:text-blue-500 transition">Dashboard</a>
            <a href="{{ route('workouts.index') }}" class="text-blue-500 text-sm font-medium">Workouts</a>
            <a href="{{ route('workouts.history') }}" class="text-slate-400 text-sm font-medium hover:text-blue-500 transition">History</a>
        </nav>
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="px-4 py-1.5 text-xs rounded-lg bg-red-500/10 text-red-400 border border-red-500/20 cursor-pointer hover:bg-red-500/20 transition">Logout</button>
        </form>
    </header>

    <div class="max-w-3xl mx-auto px-6 py-8">
        <a href="{{ route('workouts.index') }}" class="inline-flex items-center gap-1 text-blue-500 text-sm mb-6 hover:underline no-underline">← Kembali ke Daftar Workout</a>

        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/25 text-green-500 px-4 py-3 rounded-xl mb-6 text-sm">{{ session('success') }}</div>
        @endif

        {{-- Livewire Volt Workout Session Component --}}
        <livewire:workout-session :exercise="$exercise" />

        {{-- Recent History --}}
        @if($history->count())
        <div class="mt-8">
            <h2 class="text-lg font-bold mb-4">Riwayat Terakhir</h2>
            <div class="flex flex-col gap-2">
                @foreach($history as $h)
                    <div class="flex justify-between items-center bg-slate-800/50 border border-slate-700/10 rounded-xl px-4 py-3">
                        <div>
                            <span class="font-semibold">{{ $h->completed_sets }}/{{ $exercise->target_sets }} sets</span>
                            <span class="ml-2 inline-block px-2 py-0.5 rounded-full text-xs font-semibold
                                {{ $h->status === 'completed' ? 'bg-green-500/15 text-green-500' : '' }}
                                {{ $h->status === 'partial' ? 'bg-amber-500/15 text-amber-500' : '' }}
                                {{ $h->status === 'skipped' ? 'bg-red-500/15 text-red-400' : '' }}">
                                {{ ucfirst($h->status) }}
                            </span>
                        </div>
                        <span class="text-slate-500 text-xs">{{ $h->completed_at->diffForHumans() }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    @livewireScripts
</body>
</html>
