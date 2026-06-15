<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@medical.com'],
            [
                'prenom'   => 'Admin',
                'nom'      => 'Système',
                'password' => Hash::make('password'),
                'role'     => 'admin',
                'actif'    => true,
            ]
        );
    }
}
