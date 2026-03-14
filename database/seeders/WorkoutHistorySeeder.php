<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\User;
use App\Models\WorkoutHistory;
use Illuminate\Database\Seeder;

class WorkoutHistorySeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $exercises = Exercise::all();
        $statuses = ['completed', 'completed', 'completed', 'partial', 'skipped'];

        if ($users->isEmpty() || $exercises->isEmpty()) {
            return;
        }

        // Generate 40 random workout histories spread across users
        foreach ($users as $user) {
            // Setiap user mendapat 6-10 workout histories
            $count = rand(6, 10);

            for ($i = 0; $i < $count; $i++) {
                $exercise = $exercises->random();
                $status = $statuses[array_rand($statuses)];

                // Completed sets berdasarkan status
                $completedSets = match ($status) {
                    'completed' => $exercise->target_sets,
                    'partial'   => rand(1, max(1, $exercise->target_sets - 1)),
                    'skipped'   => 0,
                };

                // Random tanggal dalam 30 hari terakhir
                $completedAt = now()
                    ->subDays(rand(0, 30))
                    ->subHours(rand(0, 23))
                    ->subMinutes(rand(0, 59));

                WorkoutHistory::create([
                    'user_id'        => $user->id,
                    'exercise_id'    => $exercise->id,
                    'completed_sets' => $completedSets,
                    'status'         => $status,
                    'completed_at'   => $completedAt,
                ]);
            }
        }
    }
}
