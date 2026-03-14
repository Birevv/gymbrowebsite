<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'current_level_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ─── Relations ───────────────────────────────────────

    public function currentLevel(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'current_level_id');
    }

    public function workoutHistories(): HasMany
    {
        return $this->hasMany(WorkoutHistory::class);
    }

    // ─── Helpers ─────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user bisa mengakses level tertentu.
     * User bisa akses level-nya sendiri dan semua level di bawahnya.
     */
    public function canAccessLevel(Level $level): bool
    {
        if ($this->isAdmin()) return true;

        $currentLevel = $this->currentLevel;
        if (!$currentLevel) return false;

        return $level->order_priority <= $currentLevel->order_priority;
    }

    /**
     * Cek apakah user bisa mengakses exercise tertentu.
     */
    public function canAccessExercise(Exercise $exercise): bool
    {
        $exercise->loadMissing('level');
        return $this->canAccessLevel($exercise->level);
    }

    /**
     * Hitung progres penyelesaian exercise di level tertentu.
     * Return: ['completed' => int, 'total' => int, 'percentage' => int]
     */
    public function levelProgress(Level $level): array
    {
        $totalExercises = $level->exercises()->count();

        // Hitung exercise unik yang sudah completed oleh user di level ini
        $completedExercises = WorkoutHistory::where('user_id', $this->id)
            ->where('status', 'completed')
            ->whereHas('exercise', fn ($q) => $q->where('level_id', $level->id))
            ->distinct('exercise_id')
            ->count('exercise_id');

        return [
            'completed'  => $completedExercises,
            'total'      => $totalExercises,
            'percentage' => $totalExercises > 0
                ? (int) round(($completedExercises / $totalExercises) * 100)
                : 0,
        ];
    }

    /**
     * Cek apakah user sudah menyelesaikan semua exercise di level-nya
     * dan bisa naik ke level berikutnya.
     */
    public function checkAndLevelUp(): ?Level
    {
        $currentLevel = $this->currentLevel;
        if (!$currentLevel) return null;

        $progress = $this->levelProgress($currentLevel);

        // Belum selesai semua exercise di level ini
        if ($progress['percentage'] < 100) return null;

        // Cari level berikutnya
        $nextLevel = Level::where('order_priority', '>', $currentLevel->order_priority)
            ->orderBy('order_priority')
            ->first();

        if (!$nextLevel) return null; // Sudah di level tertinggi

        // Level up!
        $this->update(['current_level_id' => $nextLevel->id]);
        $this->refresh();

        return $nextLevel;
    }
}
