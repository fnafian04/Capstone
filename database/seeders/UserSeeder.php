<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // <-- Tambahkan

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Admin
        User::create([
            'username' => 'admin',
            'password' => 'admin123', // Otomatis di-hash oleh Model
            'role' => 'admin'
        ]);

        // 2. Buat Kasir
        User::create([
            'username' => 'kasir',
            'password' => 'kasir123',
            'role' => 'kasir'
        ]);
    }
}