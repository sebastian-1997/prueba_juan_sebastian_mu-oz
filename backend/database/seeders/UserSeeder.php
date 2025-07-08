<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            [
                'username' => 'sebas123',
                'email' => 'sebas@sebas.com',
                'password' => Hash::make('password')
            ],
            [
                'username' => 'juan123',
                'email' => 'juan@juan.com',
                'password' => Hash::make('password')
            ],
            [
                'username' => 'andres123',
                'email' => 'andres@andres.com',
                'password' => Hash::make('password')
            ],
            [
                'username' => 'alex123',
                'email' => 'alx@alex.com',
                'password' => Hash::make('password')
            ],
            [
                'username' => 'antonio123',
                'email' => 'antonio@antonio.com',
                'password' => Hash::make('password')
            ],
        ];

        foreach ($usuarios as $usuario) {
            User::create($usuario);
        }
    }
}
