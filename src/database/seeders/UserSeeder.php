<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'テストユーザー1',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'サンプルユーザー',
            'email' => 'sample@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);
    }
}