<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mountain;

class MountainSeeder extends Seeder
{
    public function run(): void
    {
        $mountains = [
            [
                'name' => 'Gunung Semeru',
                'location' => 'Jawa Timur',
                'altitude' => 3676,
                'difficulty_level' => 'hard',
                'description' => 'Gunung tertinggi di Pulau Jawa dengan pemandangan yang spektakuler.',
                'facilities' => 'Pos pendakian, shelter, sumber air',
            ],
            [
                'name' => 'Gunung Rinjani',
                'location' => 'Lombok, NTB',
                'altitude' => 3726,
                'difficulty_level' => 'hard',
                'description' => 'Gunung berapi yang masih aktif dengan Danau Segara Anak di kawahnya.',
                'facilities' => 'Pos pendakian, camping ground, sumber air',
            ],
            [
                'name' => 'Gunung Bromo',
                'location' => 'Jawa Timur',
                'altitude' => 2329,
                'difficulty_level' => 'easy',
                'description' => 'Gunung dengan pemandangan sunrise terbaik di Indonesia.',
                'facilities' => 'Jeep tour, penginapan, warung makan',
            ],
            [
                'name' => 'Gunung Merbabu',
                'location' => 'Jawa Tengah',
                'altitude' => 3145,
                'difficulty_level' => 'medium',
                'description' => 'Gunung dengan sabana yang luas dan pemandangan yang indah.',
                'facilities' => 'Pos pendakian, shelter, toilet',
            ],
            [
                'name' => 'Gunung Prau',
                'location' => 'Jawa Tengah',
                'altitude' => 2565,
                'difficulty_level' => 'easy',
                'description' => 'Gunung yang cocok untuk pendaki pemula dengan pemandangan telaga yang indah.',
                'facilities' => 'Pos pendakian, camping area, warung',
            ],
        ];

        foreach ($mountains as $mountain) {
            Mountain::create($mountain);
        }

        $this->command->info('Mountains data seeded successfully!');
    }
}