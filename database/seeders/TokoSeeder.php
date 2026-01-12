<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Toko; // <-- Tambahkan

class TokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Toko::create([
            'nama_toko' => 'Warung Kopi Senja',
            'alamat' => 'Blok A No. 1, Food Court',
            'no_telepon' => '083833341038'
        ]);

        Toko::create([
            'nama_toko' => 'Salad Pak Nafi',
            'alamat' => 'Blok E No. 15, Food Court',
            'no_telepon' => '085233361858'
        ]);

        Toko::create([
            'nama_toko' => 'Warung Mbok Yem',
            'alamat' => 'Blok E No. 15, Food Court',
            'no_telepon' => '085601855909'
        ]);
    }
}