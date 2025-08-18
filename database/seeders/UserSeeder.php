<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    
        User::create([
            'name' => 'Manager',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
    ]);



    User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
    ]);

        User::create([
            'name' => 'Manager',
            'email' => 'manager1@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'manager',
    ]);



    User::create([
            'name' => 'User',
            'email' => 'user1@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'user',
    ]);
}
}