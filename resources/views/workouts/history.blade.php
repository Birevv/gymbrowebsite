<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History — GymBro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-slate-200 font-sans">

    {{-- Navbar --}}
    <header class="flex justify-between items-center px-8 py-4 bg-slate-950/80 backdrop-blur-xl border-b border-slate-700/20">
        <div class="text-xl font-extrabold">🏋️ Gym<span class="text-blue-500">Bro</span></div>
        <nav class="flex gap-6">
            <a href="{{ route('dashboard') }}" class="text-slate-400 text-sm font-medium hover:text-blue-500 transition">Dashboard</a>
            <a href="{{ route('workouts.index') }}" class="text-slate-400 text-sm font-medium hover:text-blue-500 transition">Workouts</a>
            <a href="{{ route('workouts.history') }}" class="text-blue-500 text-sm font-medium">History</a>
        </nav>
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="px-4 py-1.5 text-xs rounded-lg bg-red-500/10 text-red-400 border border-red-500/20 cursor-pointer hover:bg-red-500/20 transition">Logout</button>
        </form>
    </header>

    <div class="max-w-5xl mx-auto px-6 py-8">

        {{-- Header & Filters --}}
        <div class="flex justify-between items-end flex-wrap gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold">Workout History 📋</h1>
                <p class="text-slate-400 mt-1">Semua riwayat latihan kamu.</p>
            </div>
            <div class="flex gap-2 flex-wrap">
                <a href="{{ route('workouts.history') }}"
                   class="px-4 py-1.5 rounded-full text-xs font-semibold border transition no-underline
                       {{ !request('status') ? 'bg-blue-500/15 border-blue-500 text-blue-500' : 'border-slate-600/30 text-slate-400 hover:border-blue-500 hover:text-blue-500' }}">
                    Semua
                </a>
                <a href="{{ route('workouts.history', ['status' => 'completed']) }}"
                   class="px-4 py-1.5 rounded-full text-xs font-semibold border transition no-underline
                       {{ request('status') === 'completed' ? 'bg-blue-500/15 border-blue-500 text-blue-500' : 'border-slate-600/30 text-slate-400 hover:border-blue-500 hover:text-blue-500' }}">
                    ✅ Completed
                </a>
                <a href="{{ route('workouts.history', ['status' => 'partial']) }}"
                   class="px-4 py-1.5 rounded-full text-xs font-semibold border transition no-underline
                       {{ request('status') === 'partial' ? 'bg-blue-500/15 border-blue-500 text-blue-500' : 'border-slate-600/30 text-slate-400 hover:border-blue-500 hover:text-blue-500' }}">
                    ⚡ Partial
                </a>
                <a href="{{ route('workouts.history', ['status' => 'skipped']) }}"
                   class="px-4 py-1.5 rounded-full text-xs font-semibold border transition no-underline
                       {{ request('status') === 'skipped' ? 'bg-blue-500/15 border-blue-500 text-blue-500' : 'border-slate-600/30 text-slate-400 hover:border-blue-500 hover:text-blue-500' }}">
                    ⏭️ Skipped
                </a>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-4 mb-8">
            <div class="bg-slate-800/70 border border-slate-700/20 rounded-xl p-4">
                <div class="text-xs text-slate-500 uppercase">Total</div>
                <div class="text-2xl font-extrabold text-blue-500">{{ $stats['total'] }}</div>
            </div>
            <div class="bg-slate-800/70 border border-slate-700/20 rounded-xl p-4">
                <div class="text-xs text-slate-500 uppercase">Completed</div>
                <div class="text-2xl font-extrabold text-green-500">{{ $stats['completed'] }}</div>
            </div>
            <div class="bg-slate-800/70 border border-slate-700/20 rounded-xl p-4">
                <div class="text-xs text-slate-500 uppercase">Streak 🔥</div>
                <div class="text-2xl font-extrabold text-violet-500">{{ $stats['streak'] }} hari</div>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-slate-800/70 border border-slate-700/20 rounded-2xl overflow-hidden mb-6">
            @if($histories->count())
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
                        @foreach($histories as $h)
                            <tr class="border-b border-slate-700/10 last:border-b-0">
                                <td class="px-4 py-3 text-sm">
                                    <a href="{{ route('workouts.show', $h->exercise) }}" class="text-slate-200 font-semibold hover:text-blue-500 no-underline transition">
                                        {{ $h->exercise->name }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-sm">{{ $h->exercise->level->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm">{{ $h->completed_sets }}/{{ $h->exercise->target_sets }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold
                                        {{ $h->status === 'completed' ? 'bg-green-500/15 text-green-500' : '' }}
                                        {{ $h->status === 'partial' ? 'bg-amber-500/15 text-amber-500' : '' }}
                                        {{ $h->status === 'skipped' ? 'bg-red-500/15 text-red-400' : '' }}">
                                        {{ ucfirst($h->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-400">{{ $h->completed_at->format('d M Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-12 text-slate-500">
                    Belum ada riwayat workout.<br>
                    <a href="{{ route('workouts.index') }}" class="text-blue-500">Mulai latihan sekarang! →</a>
                </div>
            @endif
        </div>

        {{-- Pagination --}}
        @if($histories->hasPages())
            <div class="flex justify-center">
                {{ $histories->appends(request()->query())->links() }}
            </div>
        @endif

    </div>
</body>
</html>
