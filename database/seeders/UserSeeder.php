<?php

namespace Database\Seeders;

use App\Models\Classroom;
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
        // Créer 5 enseignants
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'first_name' => "Teacher",
                'last_name' => "Number $i",
                'email' => "teacher$i@schoolmanager.com",
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'status' => 'active',
                'phone_number' => "0123456" . sprintf("%02d", $i),
                'address' => "$i Teacher Avenue"
            ]);
        }

        // Créer 20 étudiants
        for ($i = 1; $i <= 20; $i++) {
            User::create([
                'first_name' => "babacar",
                'last_name' => "ba $i",
                'email' => "student$i@schoolmanager.com",
                'password' => Hash::make('Passer123'),
                'role' => 'student',
                'status' => 'active',
                'phone_number' => "0123457" . sprintf("%02d", $i),
                'address' => "$i Rio"
            ]);
        }

        // Créer 10 parents
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'first_name' => "Mbathio",
                'last_name' => "Hane $i",
                'email' => "parent$i@schoolmanager.com",
                'password' => Hash::make('Passer123'),
                'role' => 'parent',
                'status' => 'active',
                'phone_number' => "0123458" . sprintf("%02d", $i),
                'address' => "$i Fass"
            ]);
        }

        $inactiveRoles = ['teacher', 'student', 'parent'];
        foreach ($inactiveRoles as $role) {
            User::create([
                'first_name' => "Inactive",
                'last_name' => ucfirst($role),
                'email' => "inactive.$role@schoolmanager.com",
                'password' => Hash::make('Passer123'),
                'role' => $role,
                'status' => 'inactive',
                'phone_number' => "0123459" . rand(10, 99),
                'address' => "Inactive $role Address"
            ]);
        }

        // Créer 5 Classroom
        for ($i = 1; $i <= 5; $i++) {
            Classroom::create([
                'name' => "Classroom",
                'section' => "Number $i",
                'level' => "1",
                'capacity' => "30",
                'academic_year' => "2021-2022",
                'status' => 'active',
            ]);
        }


    }
}
