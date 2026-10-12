<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin PawPal',
            'email' => 'admin@pawpal.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Pengguna PawPal',
            'email' => 'user@pawpal.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
