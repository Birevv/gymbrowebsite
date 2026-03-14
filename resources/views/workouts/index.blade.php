<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workouts — GymBro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

    <div class="max-w-5xl mx-auto px-6 py-8">
        <h1 class="text-2xl font-extrabold mb-1">Daftar Workout 💪</h1>
        <p class="text-slate-400 mb-8">Selesaikan semua exercise di level kamu untuk membuka level berikutnya.</p>

        {{-- Flash: Error --}}
        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/25 text-red-400 px-4 py-3 rounded-xl mb-6 text-sm">{{ session('error') }}</div>
        @endif

        {{-- Flash: Level Up! --}}
        @if(session('level_up'))
            <div class="bg-gradient-to-r from-green-500/10 to-blue-500/10 border-2 border-green-500/30 rounded-2xl p-8 text-center mb-8 animate-pulse">
                <div class="text-5xl mb-2">🎉🏆🎉</div>
                <h2 class="text-2xl font-extrabold text-green-500">LEVEL UP!</h2>
                <p class="text-slate-400 mt-2">Selamat! Kamu naik ke level <strong class="text-green-500">{{ session('level_up') }}</strong>. Tantangan baru menunggu!</p>
            </div>
        @endif

        @foreach($levels as $level)
            @php
                $isCurrent = $user->current_level_id === $level->id;
                $isUnlocked = $level->is_unlocked;
                $progress = $level->progress;
            @endphp

            <div class="mb-10">
                {{-- Level Header --}}
                <div class="flex items-center gap-3 flex-wrap pb-3 mb-3 border-b border-slate-700/20">
                    <span>
                        @if($isCurrent) 🎯
                        @elseif($isUnlocked) ✅
                        @else 🔒
                        @endif
                    </span>

                    <span class="text-lg font-bold">{{ $level->name }}</span>

                    @if($isCurrent)
                        <span class="text-xs px-2.5 py-0.5 rounded-full bg-green-500/15 text-green-500 font-semibold">Level Kamu</span>
                    @elseif($isUnlocked)
                        <span class="text-xs px-2.5 py-0.5 rounded-full bg-blue-500/15 text-blue-500 font-semibold">Terbuka</span>
                    @else
                        <span class="text-xs px-2.5 py-0.5 rounded-full bg-slate-600/15 text-slate-500 font-semibold">Terkunci</span>
                    @endif

                    @if($isUnlocked)
                        <span class="ml-auto text-sm text-slate-400">
                            <strong class="text-slate-200">{{ $progress['completed'] }}/{{ $progress['total'] }}</strong> selesai
                        </span>
                    @endif
                </div>

                {{-- Progress bar --}}
                @if($isUnlocked)
                <div class="bg-slate-950/60 rounded-full h-1.5 overflow-hidden mb-4">
                    <div class="h-full rounded-full bg-gradient-to-r from-blue-500 to-violet-500 transition-all duration-500"
                         style="width: {{ max($progress['percentage'], 2) }}%"></div>
                </div>
                @endif

                {{-- Exercises --}}
                <div class="relative {{ !$isUnlocked ? 'min-h-44' : '' }}">
                    @unless($isUnlocked)
                        <div class="absolute inset-0 z-10 bg-slate-950/70 backdrop-blur-sm rounded-2xl flex flex-col items-center justify-center gap-2">
                            <span class="text-4xl">🔒</span>
                            <p class="text-sm text-slate-400 text-center max-w-xs">
                                Selesaikan semua exercise di level
                                <strong class="text-amber-500">{{ $levels->filter(fn($l) => $l->order_priority < $level->order_priority)->sortByDesc('order_priority')->first()?->name ?? 'sebelumnya' }}</strong>
                                untuk membuka level ini.
                            </p>
                        </div>
                    @endunless

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($level->exercises as $exercise)
                            <div class="relative bg-slate-800/70 border border-slate-700/20 rounded-2xl p-5 flex flex-col transition-all duration-200 hover:border-blue-500 hover:-translate-y-0.5">
                                {{-- Done badge --}}
                                @if($isUnlocked && $user->workoutHistories()->where('exercise_id', $exercise->id)->where('status', 'completed')->exists())
                                    <span class="absolute top-3 right-3 text-xs px-2 py-0.5 rounded-full bg-green-500/15 text-green-500 font-semibold">✅ Done</span>
                                @endif

                                <h3 class="font-bold mb-1">{{ $exercise->name }}</h3>
                                <p class="text-xs text-slate-400 flex-1 mb-3">{{ Str::limit($exercise->description, 80) }}</p>
                                <div class="flex gap-2 mb-4">
                                    <span class="text-xs px-2 py-0.5 rounded bg-slate-700/30 text-slate-300">{{ $exercise->target_sets }} Sets</span>
                                    @if($exercise->target_reps)
                                        <span class="text-xs px-2 py-0.5 rounded bg-slate-700/30 text-slate-300">{{ $exercise->target_reps }} Reps</span>
                                    @else
                                        <span class="text-xs px-2 py-0.5 rounded bg-slate-700/30 text-slate-300">Timed</span>
                                    @endif
                                </div>

                                @if($isUnlocked)
                                    <a href="{{ route('workouts.show', $exercise) }}"
                                       class="block text-center py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold text-sm rounded-xl transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-blue-500/25 no-underline">
                                        Mulai Latihan 🔥
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</body>
</html>
