<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 1,
                'id_divisi' => 1,
                'no_hp' => '081359569879'
            ], [
                'name' => 'Devi',
                'email' => 'user@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 0,
                'id_divisi' => 3,
                'no_hp' => '081234567890'
            ]
        ]);
    }
}
