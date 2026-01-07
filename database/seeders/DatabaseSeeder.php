<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            MountainSeeder::class,
            TripSeeder::class,
            FaqSeeder::class,
        ]);

        $this->command->info('All seeders completed successfully! ✓');
        $this->command->info('');
        $this->command->info('Login Credentials:');
        $this->command->info('Admin: admin@hikershub.com / password123');
        $this->command->info('User: user@test.com / password123');
    }
}