<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin HikersHub',
            'email' => 'admin@hikershub.com',
            'password' => Hash::make('password123'),
            'phone' => '081234567890',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
            'role' => 'admin',
        ]);

        // Create Test User
        User::create([
            'name' => 'John Doe',
            'email' => 'user@test.com',
            'password' => Hash::make('password123'),
            'phone' => '082345678901',
            'date_of_birth' => '1995-05-15',
            'gender' => 'male',
            'emergency_contact_name' => 'Jane Doe',
            'emergency_contact_phone' => '083456789012',
            'role' => 'user',
        ]);

        $this->command->info('Admin and test users created successfully!');
    }
}