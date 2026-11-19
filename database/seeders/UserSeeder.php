<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun PPID secara idempoten agar aman dijalankan saat startup container Docker
        User::firstOrCreate(
            ['email' => 'superadmin@dispora.jatimprov.go.id'],
            [
                'name' => 'Super Administrator PPID',
                'password' => Hash::make('SuperAdmin#2026'),
                'role' => 'superadmin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'operator@dispora.jatimprov.go.id'],
            [
                'name' => 'Operator PPID Dispora',
                'password' => Hash::make('Operator#2026'),
                'role' => 'operator',
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin@dispora.jatim.go.id'],
            [
                'name' => 'Admin PPID Dispora',
                'password' => Hash::make('adminppid123'),
                'role' => 'operator',
            ]
        );
    }
}
