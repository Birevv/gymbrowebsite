<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — GymBro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-slate-200 font-sans">

    {{-- Navbar --}}
    <header class="flex justify-between items-center px-8 py-4 bg-slate-950/80 backdrop-blur-xl border-b border-slate-700/20">
        <div class="text-xl font-extrabold">🏋️ Gym<span class="text-blue-500">Bro</span></div>
        <nav class="flex gap-6">
            <a href="{{ route('dashboard') }}" class="text-blue-500 text-sm font-medium">Dashboard</a>
            <a href="{{ route('workouts.index') }}" class="text-slate-400 text-sm font-medium hover:text-blue-500 transition">Workouts</a>
            <a href="{{ route('workouts.history') }}" class="text-slate-400 text-sm font-medium hover:text-blue-500 transition">History</a>
        </nav>
        <div class="flex items-center gap-4">
            <span class="text-sm text-slate-300">{{ $user->name }}</span>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="px-4 py-1.5 text-xs rounded-lg bg-red-500/10 text-red-400 border border-red-500/20 cursor-pointer hover:bg-red-500/20 transition">Logout</button>
            </form>
        </div>
    </header>

    <div class="max-w-5xl mx-auto px-6 py-8">

        {{-- Greeting --}}
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold">Halo, <span class="text-blue-500">{{ $user->name }}</span> 👋</h1>
            <p class="text-slate-400 mt-1">Pantau progres workout kamu di sini.</p>
            @if($user->currentLevel)
                <div class="inline-flex items-center gap-1.5 mt-3 px-4 py-1.5 bg-gradient-to-r from-blue-500/10 to-violet-500/10 border border-blue-500/25 rounded-full text-sm font-bold text-indigo-400">
                    ⚡ Level: {{ $user->currentLevel->name }}
                </div>
            @endif
        </div>

        {{-- Current Level Progress --}}
        @if($currentProgress)
        <div class="bg-gradient-to-r from-blue-500/5 to-violet-500/5 border border-blue-500/20 rounded-2xl p-6 mb-8">
            <h2 class="text-lg font-bold mb-3">📊 Progres Level {{ $user->currentLevel->name }}</h2>
            <div class="bg-slate-950/60 rounded-full h-5 overflow-hidden mb-2">
                <div class="h-full rounded-full bg-gradient-to-r from-blue-500 to-violet-500 flex items-center justify-center text-[0.65rem] font-bold text-white min-w-8 transition-all duration-500"
                     style="width: {{ max($currentProgress['percentage'], 5) }}%">
                    {{ $currentProgress['percentage'] }}%
                </div>
            </div>
            <p class="text-sm text-slate-400">
                <strong class="text-slate-200">{{ $currentProgress['completed'] }}/{{ $currentProgress['total'] }}</strong> exercise selesai.
                @if($currentProgress['percentage'] >= 100)
                    🎉 Semua selesai! Level berikutnya sudah terbuka!
                @else
                    Selesaikan semua untuk membuka level berikutnya.
                @endif
            </p>
        </div>
        @endif

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-slate-800/70 border border-slate-700/20 rounded-2xl p-5 backdrop-blur-sm">
                <div class="text-xs text-slate-500 uppercase tracking-wider">Total Workout</div>
                <div class="text-3xl font-extrabold text-blue-500 mt-1">{{ $stats['total_workouts'] }}</div>
            </div>
            <div class="bg-slate-800/70 border border-slate-700/20 rounded-2xl p-5 backdrop-blur-sm">
                <div class="text-xs text-slate-500 uppercase tracking-wider">Completed</div>
                <div class="text-3xl font-extrabold text-green-500 mt-1">{{ $stats['completed'] }}</div>
            </div>
            <div class="bg-slate-800/70 border border-slate-700/20 rounded-2xl p-5 backdrop-blur-sm">
                <div class="text-xs text-slate-500 uppercase tracking-wider">Minggu Ini</div>
                <div class="text-3xl font-extrabold text-amber-500 mt-1">{{ $stats['this_week'] }}</div>
            </div>
            <div class="bg-slate-800/70 border border-slate-700/20 rounded-2xl p-5 backdrop-blur-sm">
                <div class="text-xs text-slate-500 uppercase tracking-wider">Streak 🔥</div>
                <div class="text-3xl font-extrabold text-violet-500 mt-1">{{ $stats['streak'] }} hari</div>
            </div>
        </div>

        {{-- Recent Workouts --}}
        <div class="flex items-center justify-between text-lg font-bold mb-4">
            <span>Workout Terakhir</span>
            <a href="{{ route('workouts.history') }}" class="text-sm text-blue-500 hover:underline">Lihat Semua →</a>
        </div>
        <div class="bg-slate-800/70 border border-slate-700/20 rounded-2xl overflow-hidden mb-8">
            @if($recentWorkouts->count())
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-950/40 border-b border-slate-700/15">
                            <th class="text-left px-4 py-3 text-xs text-slate-500 uppercase tracking-wider">Exercise</th>
                            <th class="text-left px-4 py-3 text-xs text-slate-500 uppercase tracking-wider">Level</th>
                            <th class="text-left px-4 py-3 text-xs text-slate-500 uppercase tracking-wider">Sets</th>
                            <th class="text-left px-4 py-3 text-xs text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="text-left px-4 py-3 text-xs text-slate-500 uppercase tracking-wider">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentWorkouts as $wh)
                        <tr class="border-b border-slate-700/10 last:border-b-0">
                            <td class="px-4 py-3 text-sm">{{ $wh->exercise->name }}</td>
                            <td class="px-4 py-3 text-sm">{{ $wh->exercise->level->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $wh->completed_sets }}/{{ $wh->exercise->target_sets }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold
                                    {{ $wh->status === 'completed' ? 'bg-green-500/15 text-green-500' : '' }}
                                    {{ $wh->status === 'partial' ? 'bg-amber-500/15 text-amber-500' : '' }}
                                    {{ $wh->status === 'skipped' ? 'bg-red-500/15 text-red-400' : '' }}">
                                    {{ ucfirst($wh->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">{{ $wh->completed_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-8 text-slate-500">Belum ada workout. <a href="{{ route('workouts.index') }}" class="text-blue-500">Mulai sekarang!</a></div>
            @endif
        </div>

        {{-- Levels --}}
        <div class="text-lg font-bold mb-4">Level Workout</div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($levels as $level)
                <div class="relative overflow-hidden rounded-2xl p-5 border transition-all duration-200
                    {{ $level->is_unlocked ? 'bg-slate-800/70 border-slate-700/20 hover:border-blue-500 hover:-translate-y-0.5 cursor-pointer' : 'bg-slate-800/40 border-slate-700/10 opacity-50 cursor-not-allowed' }}
                    {{ $user->current_level_id === $level->id ? 'border-blue-500! shadow-lg shadow-blue-500/10' : '' }}">

                    @unless($level->is_unlocked)
                        <span class="absolute top-3 right-3 text-xl">🔒</span>
                    @endunless

                    <h3 class="font-bold">{{ $level->name }}</h3>
                    <p class="text-xs text-slate-500 mt-0.5">{{ Str::limit($level->descriptions, 60) }}</p>
                    <div class="text-sm text-blue-500 font-semibold mt-2">{{ $level->exercises_count }} exercise</div>

                    @if($level->is_unlocked)
                        <div class="bg-slate-950/60 rounded-full h-1.5 mt-2 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-blue-500 to-violet-500 transition-all duration-500"
                                 style="width: {{ max($level->progress['percentage'], 3) }}%"></div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

    </div>
</body>
</html>
