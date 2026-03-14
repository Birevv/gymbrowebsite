<?php

namespace Database\Seeders;

use App\Models\Level;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ─── 1. Levels & Exercises ───────────────────────────
        $this->call([
            LevelSeeder::class,
            ExerciseSeeder::class,
        ]);

        // ─── 2. Admin user ──────────────────────────────────
        User::create([
            'name'             => 'Admin GymBro',
            'email'            => 'admin@gymbro.com',
            'password'         => Hash::make('password'),
            'role'             => 'admin',
            'current_level_id' => null,
            'email_verified_at'=> now(),
        ]);

        // ─── 3. Regular users ───────────────────────────────
        $beginner = Level::where('name', 'Beginner')->first();

        User::factory(5)->create([
            'role'             => 'user',
            'current_level_id' => $beginner?->id,
        ]);

        // ─── 4. Workout histories ───────────────────────────
        $this->call([
            WorkoutHistorySeeder::class,
        ]);
    }
}
