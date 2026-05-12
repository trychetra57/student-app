<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@student.com'],
            [
                'name' => 'System Admin',
                'password' => 'password123',
                'role' => 'admin',
                'is_active' => true,
            ]
        );
    }
}
