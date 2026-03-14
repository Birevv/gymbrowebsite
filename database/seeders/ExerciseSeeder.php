<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\Level;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
    public function run(): void
    {
        $exercises = [
            // ─── Beginner ────────────────────────────────────
            'Beginner' => [
                [
                    'name'        => 'Wall Push-ups',
                    'target_sets' => 3,
                    'target_reps' => 15,
                    'description' => 'Push-up dengan tangan di dinding. Posisi badan miring, turunkan dada ke dinding lalu dorong kembali. Latihan ini membangun kekuatan dasar untuk push-up.',
                ],
                [
                    'name'        => 'Knee Push-ups',
                    'target_sets' => 3,
                    'target_reps' => 10,
                    'description' => 'Push-up dengan lutut sebagai tumpuan. Jaga badan lurus dari kepala ke lutut. Transisi sempurna sebelum full push-up.',
                ],
                [
                    'name'        => 'Bodyweight Squats',
                    'target_sets' => 3,
                    'target_reps' => 15,
                    'description' => 'Squat tanpa beban. Turunkan pinggul seperti duduk di kursi, jaga lutut tidak melewati ujung jari kaki.',
                ],
                [
                    'name'        => 'Dead Hang',
                    'target_sets' => 3,
                    'target_reps' => null,
                    'description' => 'Bergantung di pull-up bar selama 20-30 detik. Tahan dengan grip overhand, bahu aktif. Membangun kekuatan grip dan bahu.',
                ],
            ],

            // ─── Intermediate ────────────────────────────────
            'Intermediate' => [
                [
                    'name'        => 'Push-ups',
                    'target_sets' => 4,
                    'target_reps' => 15,
                    'description' => 'Push-up standar. Posisi plank, turunkan dada hingga hampir menyentuh lantai, lalu dorong ke atas. Jaga core tetap tight.',
                ],
                [
                    'name'        => 'Bench Dips',
                    'target_sets' => 3,
                    'target_reps' => 12,
                    'description' => 'Dip menggunakan bangku atau kursi. Tangan di belakang, turunkan badan dengan menekuk siku, lalu dorong kembali ke atas.',
                ],
                [
                    'name'        => 'Walking Lunges',
                    'target_sets' => 3,
                    'target_reps' => 12,
                    'description' => 'Lunge sambil berjalan. Langkah maju, tekuk kedua lutut 90 derajat, lalu langkah kaki belakang ke depan. Alternating legs.',
                ],
                [
                    'name'        => 'Pull-up Negatives',
                    'target_sets' => 3,
                    'target_reps' => 5,
                    'description' => 'Lompat ke posisi atas pull-up, lalu turun perlahan selama 5 detik. Membangun kekuatan untuk full pull-up.',
                ],
            ],

            // ─── Advanced ────────────────────────────────────
            'Advanced' => [
                [
                    'name'        => 'Diamond Push-ups',
                    'target_sets' => 4,
                    'target_reps' => 12,
                    'description' => 'Push-up dengan tangan membentuk diamond di bawah dada. Fokus pada trisep dan inner chest. Jaga siku dekat badan.',
                ],
                [
                    'name'        => 'Pistol Squats',
                    'target_sets' => 3,
                    'target_reps' => 8,
                    'description' => 'Squat satu kaki. Kaki lainnya lurus ke depan. Membutuhkan keseimbangan, fleksibilitas, dan kekuatan kaki yang luar biasa.',
                ],
                [
                    'name'        => 'Pull-ups',
                    'target_sets' => 4,
                    'target_reps' => 8,
                    'description' => 'Pull-up standar dengan overhand grip. Tarik badan ke atas hingga dagu melewati bar. Kontrol saat turun.',
                ],
                [
                    'name'        => 'Muscle-up Progressions',
                    'target_sets' => 3,
                    'target_reps' => 5,
                    'description' => 'Latihan progresif menuju muscle-up. Kombinasi explosive pull-up dan transition di atas bar.',
                ],
            ],

            // ─── Elite ───────────────────────────────────────
            'Elite' => [
                [
                    'name'        => 'One-arm Push-ups',
                    'target_sets' => 4,
                    'target_reps' => 5,
                    'description' => 'Push-up satu tangan. Kaki lebih lebar, satu tangan di punggung. Membutuhkan kekuatan dan stabilitas core yang superior.',
                ],
                [
                    'name'        => 'Handstand Push-ups',
                    'target_sets' => 3,
                    'target_reps' => 5,
                    'description' => 'Push-up dalam posisi handstand (bisa dengan bantuan dinding). Target utama: bahu dan trisep.',
                ],
                [
                    'name'        => 'Muscle-ups',
                    'target_sets' => 3,
                    'target_reps' => 5,
                    'description' => 'Gerakan eksplosif dari bawah bar ke atas bar dalam satu gerakan fluid. Butuh kekuatan pulling dan pushing.',
                ],
                [
                    'name'        => 'Planche Progressions',
                    'target_sets' => 4,
                    'target_reps' => null,
                    'description' => 'Latihan progresif menuju planche hold. Mulai dari tuck planche, tahan 10-20 detik. Membangun kekuatan bahu dan core yang ekstrem.',
                ],
            ],
        ];

        foreach ($exercises as $levelName => $exerciseList) {
            $level = Level::where('name', $levelName)->first();

            if (!$level) {
                continue;
            }

            foreach ($exerciseList as $exercise) {
                Exercise::create(array_merge($exercise, [
                    'level_id' => $level->id,
                ]));
            }
        }
    }
}
