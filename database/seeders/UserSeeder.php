<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'dni' => '00000000A',
            'name' => 'Administrador',
            'email' => 'admin@demo.com',
            'password' => Hash::make('password'),
            'role_id' => 1, // Admin
        ]);
    }
}
