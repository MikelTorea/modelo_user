<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'juan123',
            'name' => 'Juan',
            'email' => 'juan@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'username' => 'maria123',
            'name' => 'Maria',
            'email' => 'maria@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'username' => 'pedro123',
            'name' => 'Pedro',
            'email' => 'pedro@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'username' => 'lucia123',
            'name' => 'Lucia',
            'email' => 'lucia@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'username' => 'carlos123',
            'name' => 'Carlos',
            'email' => 'carlos@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'username' => 'ana123',
            'name' => 'Ana',
            'email' => 'ana@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'username' => 'david123',
            'name' => 'David',
            'email' => 'david@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'username' => 'laura123',
            'name' => 'Laura',
            'email' => 'laura@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'username' => 'miguel123',
            'name' => 'Miguel',
            'email' => 'miguel@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'username' => 'sofia123',
            'name' => 'Sofia',
            'email' => 'sofia@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}