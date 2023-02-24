<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@laravel.com',
            'password' => Hash::make('admin123'),
        ]);

        User::create([
            'name' => 'User',
            'email' => 'user@laravel.com',
            'password' => Hash::make('user123'),
        ]);
    }
}
