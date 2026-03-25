<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun Admin PPID Default
        User::create([
            'name' => 'Admin PPID Dispora',
            'email' => 'admin@dispora.jatim.go.id',
            'password' => Hash::make('adminppid123'), // Password default
        ]);
    }
}
