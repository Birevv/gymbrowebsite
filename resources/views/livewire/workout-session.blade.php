<?php

use Livewire\Volt\Component;
use App\Models\Exercise;
use App\Models\WorkoutHistory;
use Illuminate\Support\Facades\Auth;

new class extends Component {

    public Exercise $exercise;
    public int $currentSet = 0;
    public bool $isCompleted = false;
    public ?string $levelUpName = null;

    public function mount(Exercise $exercise)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->canAccessExercise($exercise)) {
            $this->redirect(route('workouts.index'));
            return;
        }
        $this->exercise = $exercise;
    }

    public function completeSet()
    {
        $this->currentSet++;

        if ($this->currentSet >= $this->exercise->target_sets) {
            $this->finishWorkout();
        }
    }

    public function finishWorkout()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        WorkoutHistory::create([
            'user_id'        => $user->id,
            'exercise_id'    => $this->exercise->id,
            'completed_sets' => $this->currentSet,
            'status'         => 'completed',
            'completed_at'   => now(),
        ]);

        $newLevel = $user->checkAndLevelUp();
        if ($newLevel) {
            $this->levelUpName = $newLevel->name;
        }

        $this->isCompleted = true;
    }
}; ?>

<div>
    {{-- Level Up Banner --}}
    @if ($levelUpName)
        <div class="bg-gradient-to-r from-green-500/10 to-blue-500/10 border-2 border-green-500/30 rounded-2xl p-8 text-center mb-6 animate-pulse">
            <div class="text-5xl">🎉🏆🎉</div>
            <h2 class="text-2xl font-extrabold text-green-500 mt-2">LEVEL UP!</h2>
            <p class="text-slate-400 mt-2">Kamu naik ke level <strong class="text-green-500">{{ $levelUpName }}</strong>!</p>
        </div>
    @endif

    {{-- Exercise Card --}}
    <div class="max-w-lg mx-auto bg-slate-800/80 border border-slate-600/30 rounded-2xl p-8 backdrop-blur-xl shadow-2xl">

        {{-- Header --}}
        <div class="text-center mb-6">
            <span class="text-xs px-2.5 py-1 rounded-full bg-blue-500/15 text-blue-500 font-semibold">
                {{ $exercise->level->name ?? 'Workout' }}
            </span>
            <h2 class="text-2xl font-extrabold text-slate-100 mt-3">{{ $exercise->name }}</h2>
            @if ($exercise->description)
                <p class="text-slate-400 mt-2 text-sm">{{ $exercise->description }}</p>
            @endif

            <div class="mt-4 inline-flex gap-3">
                <span class="bg-blue-500/10 text-blue-400 px-4 py-1.5 rounded-full font-bold text-sm">
                    🎯 {{ $exercise->target_sets }} Sets
                </span>
                @if ($exercise->target_reps)
                    <span class="bg-violet-500/10 text-violet-400 px-4 py-1.5 rounded-full font-bold text-sm">
                        💪 {{ $exercise->target_reps }} Reps
                    </span>
                @endif
            </div>
        </div>

        @if ($isCompleted)
            {{-- Completed State --}}
            <div class="text-center py-8">
                <div class="w-20 h-20 bg-green-500/15 text-green-500 rounded-full flex items-center justify-center mx-auto mb-4 text-4xl border-2 border-green-500/25">
                    ✓
                </div>
                <h3 class="text-xl font-extrabold text-slate-100">Latihan Selesai! 🎉</h3>
                <p class="text-slate-400 mt-2 mb-6">Kerja bagus! Progres kamu telah disimpan.</p>

                <div class="flex gap-3 justify-center flex-wrap">
                    <a href="{{ route('dashboard') }}"
                       class="px-5 py-2.5 bg-slate-700/30 text-slate-300 rounded-xl font-semibold text-sm border border-slate-600/30 no-underline hover:bg-slate-700/50 transition">
                        ← Dashboard
                    </a>
                    <a href="{{ route('workouts.index') }}"
                       class="px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl font-bold text-sm no-underline hover:-translate-y-0.5 transition">
                        Latihan Lain →
                    </a>
                </div>
            </div>
        @else
            {{-- Active Workout State --}}
            <div class="text-center py-6">
                <p class="text-slate-500 text-xs uppercase tracking-wider mb-2">Progres Saat Ini</p>
                <div class="text-6xl font-black text-slate-100 mb-2">
                    {{ $currentSet }}
                    <span class="text-2xl text-slate-500 font-medium">/ {{ $exercise->target_sets }}</span>
                </div>

                {{-- Progress Bar --}}
                <div class="bg-slate-950/60 rounded-full h-3 overflow-hidden my-6">
                    <div class="h-full rounded-full bg-gradient-to-r from-blue-500 to-violet-500 transition-all duration-400"
                         style="width: {{ $exercise->target_sets > 0 ? ($currentSet / $exercise->target_sets) * 100 : 0 }}%">
                    </div>
                </div>

                <button wire:click="completeSet"
                    class="w-full py-4 text-lg font-extrabold bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-2xl cursor-pointer shadow-lg shadow-blue-500/25 transition hover:-translate-y-0.5 hover:shadow-xl hover:shadow-blue-500/35 active:scale-[0.97]">
                    Selesai 1 Set 🔥
                </button>
            </div>
        @endif
    </div>
</div>
