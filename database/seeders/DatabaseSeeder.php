<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer l'administrateur du système
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'System',
            'email' => 'admin@schoolmanager.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active'
        ]);


        $this->call([
            UserSeeder::class,
        ]);
    }
}
