<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
            'edu_level_id' => 1
        ]);

        User::create([
            'name' => 'User One',
            'email' => 'user1@example.com',
            'phone' => '08123456789',
            'profile_picture' => 'user1.jpg',
            'dob' => '1995-06-15',
            'role' => 'user',
            'password' => Hash::make('password'),
            'edu_level_id' => 2
        ]);
    }
}
