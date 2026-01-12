<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder sesuai urutan
        // Toko harus ada sebelum Menu
        $this->call([
            UserSeeder::class,
            TokoSeeder::class,
            MenuSeeder::class,
        ]);
    }
}