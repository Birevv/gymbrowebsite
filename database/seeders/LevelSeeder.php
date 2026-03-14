<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            [
                'name'           => 'Beginner',
                'descriptions'   => 'Level untuk pemula. Latihan dasar yang aman untuk membangun fondasi kekuatan dan kebiasaan olahraga.',
                'order_priority' => 1,
            ],
            [
                'name'           => 'Intermediate',
                'descriptions'   => 'Level menengah. Latihan yang lebih intens untuk meningkatkan kekuatan dan daya tahan tubuh.',
                'order_priority' => 2,
            ],
            [
                'name'           => 'Advanced',
                'descriptions'   => 'Level lanjutan. Latihan yang menantang untuk atlet yang sudah berpengalaman.',
                'order_priority' => 3,
            ],
            [
                'name'           => 'Elite',
                'descriptions'   => 'Level elite. Latihan paling sulit untuk mereka yang mengejar performa maksimal.',
                'order_priority' => 4,
            ],
        ];

        foreach ($levels as $level) {
            Level::create($level);
        }
    }
}
