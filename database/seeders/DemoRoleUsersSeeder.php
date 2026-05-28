<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoRoleUsersSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');

        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@syncora.test',
                'role' => 'admin',
            ],
            [
                'name' => 'Student User',
                'email' => 'student@syncora.test',
                'role' => 'student',
                'matricule' => 'STU-000001',
            ],
            [
                'name' => 'Supervisor User',
                'email' => 'supervisor@syncora.test',
                'role' => 'supervisor',
            ],
            [
                'name' => 'Company User',
                'email' => 'company@syncora.test',
                'role' => 'company',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => $password,
                    'role' => $user['role'],
                    'matricule' => $user['matricule'] ?? null,
                    'email_verified_at' => now(),
                ],
            );
        }
    }
}
