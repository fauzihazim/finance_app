<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'full_name' => 'User 1',
            'email' => 'example1@mail.net',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'full_name' => 'User 2',
            'email' => 'example2@mail.net',
            'password' => Hash::make('password'),
        ]);
    }
}
