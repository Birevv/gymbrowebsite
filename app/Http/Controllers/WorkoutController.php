<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Level;
use App\Models\WorkoutHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkoutController extends Controller
{
    /**
     * Daftar semua exercises, dikelompokkan per level.
     * Masing-masing level ditandai locked/unlocked berdasarkan progres user.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $levels = Level::with('exercises')
            ->orderBy('order_priority')
            ->get()
            ->map(function ($level) use ($user) {
                $level->is_unlocked = $user->canAccessLevel($level);
                $level->progress    = $user->levelProgress($level);
                return $level;
            });

        return view('workouts.index', compact('levels', 'user'));
    }

    /**
     * Detail exercise — memulai workout session.
     * Cek akses level terlebih dahulu.
     */
    public function show(Exercise $exercise)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $exercise->load('level');

        // Guard: cek apakah user bisa akses exercise ini
        if (!$user->canAccessExercise($exercise)) {
            return redirect()->route('workouts.index')
                ->with('error', '🔒 Level ini masih terkunci! Selesaikan semua exercise di level kamu dulu.');
        }

        $history = WorkoutHistory::where('user_id', $user->id)
            ->where('exercise_id', $exercise->id)
            ->orderByDesc('completed_at')
            ->take(5)
            ->get();

        return view('workouts.show', compact('exercise', 'history'));
    }

    /**
     * Complete / record workout.
     * Setelah record, cek apakah user bisa level up.
     */
    public function complete(Request $request, Exercise $exercise)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $exercise->load('level');

        // Guard: cek akses
        if (!$user->canAccessExercise($exercise)) {
            return redirect()->route('workouts.index')
                ->with('error', '🔒 Kamu tidak punya akses ke exercise ini.');
        }

        $validated = $request->validate([
            'completed_sets' => 'required|integer|min:0',
            'status'         => 'required|in:completed,partial,skipped',
        ]);

        WorkoutHistory::create([
            'user_id'        => $user->id,
            'exercise_id'    => $exercise->id,
            'completed_sets' => $validated['completed_sets'],
            'status'         => $validated['status'],
            'completed_at'   => now(),
        ]);

        // Cek level up
        $newLevel = $user->checkAndLevelUp();

        if ($newLevel) {
            return redirect()->route('workouts.index')
                ->with('level_up', $newLevel->name);
        }

        return redirect()->route('workouts.show', $exercise)
            ->with('success', 'Workout recorded! 💪');
    }

    /**
     * Workout history milik user yang login.
     */
    public function history(Request $request)
    {
        $query = WorkoutHistory::with('exercise.level')
            ->where('user_id', Auth::id())
            ->orderByDesc('completed_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $histories = $query->paginate(15);

        $stats = [
            'total'     => WorkoutHistory::where('user_id', Auth::id())->count(),
            'completed' => WorkoutHistory::where('user_id', Auth::id())->where('status', 'completed')->count(),
            'streak'    => $this->calculateStreak(Auth::id()),
        ];

        return view('workouts.history', compact('histories', 'stats'));
    }

    /**
     * User dashboard — summary progres + gamifikasi.
     */
    public function dashboard()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->load('currentLevel');

        $recentWorkouts = WorkoutHistory::with('exercise.level')
            ->where('user_id', $user->id)
            ->orderByDesc('completed_at')
            ->take(5)
            ->get();

        $stats = [
            'total_workouts' => WorkoutHistory::where('user_id', $user->id)->count(),
            'completed'      => WorkoutHistory::where('user_id', $user->id)->where('status', 'completed')->count(),
            'this_week'      => WorkoutHistory::where('user_id', $user->id)
                ->where('completed_at', '>=', now()->startOfWeek())
                ->count(),
            'streak'         => $this->calculateStreak($user->id),
        ];

        // Level info untuk gamifikasi
        $levels = Level::withCount(['exercises'])->orderBy('order_priority')->get()
            ->map(function ($level) use ($user) {
                $level->is_unlocked = $user->canAccessLevel($level);
                $level->progress    = $user->levelProgress($level);
                return $level;
            });

        // Progres di level sekarang
        $currentProgress = $user->currentLevel
            ? $user->levelProgress($user->currentLevel)
            : null;

        return view('workouts.dashboard', compact('user', 'recentWorkouts', 'stats', 'levels', 'currentProgress'));
    }

    /**
     * Menghitung berapa hari berturut-turut user workout.
     */
    private function calculateStreak(int $userId): int
    {
        $dates = WorkoutHistory::where('user_id', $userId)
            ->where('status', 'completed')
            ->orderByDesc('completed_at')
            ->pluck('completed_at')
            ->map(fn ($d) => $d->format('Y-m-d'))
            ->unique()
            ->values();

        if ($dates->isEmpty()) return 0;

        $streak = 0;
        $checkDate = now()->format('Y-m-d');

        if ($dates->first() !== $checkDate) {
            $checkDate = now()->subDay()->format('Y-m-d');
        }

        foreach ($dates as $date) {
            if ($date === $checkDate) {
                $streak++;
                $checkDate = Carbon::parse($checkDate)->subDay()->format('Y-m-d');
            } else {
                break;
            }
        }

        return $streak;
    }
}
