<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu; // <-- Tambahkan

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menu untuk Toko 1 (Warung Kopi Senja)
        Menu::create([
            'id_toko' => 1,
            'nama_menu' => 'Kopi Susu Gula Aren',
            'deskripsi' => 'Kopi susu dengan gula aren asli',
            'harga_satuan' => 18000,
            'foto_menu' => 'ga.jpeg'
        ]);
        Menu::create([
            'id_toko' => 1,
            'nama_menu' => 'Americano',
            'deskripsi' => 'Kopi hitam tanpa gula',
            'harga_satuan' => 15000,
            'foto_menu' => 'am.jpeg'
        ]);
        Menu::create([
            'id_toko' => 1,
            'nama_menu' => 'Kentang Goreng',
            'deskripsi' => 'Kentang goreng renyah',
            'harga_satuan' => 12000,
            'foto_menu' => 'kg.jpeg'
        ]);
        Menu::create([
            'id_toko' => 1,
            'nama_menu' => 'Ote Ote Maknyus',
            'deskripsi' => 'Kue goreng isi sayuran',
            'harga_satuan' => 1500,
            'foto_menu' => 'ote.jpeg'
        ]);
        Menu::create([
            'id_toko' => 1,
            'nama_menu' => 'Mie Goreng Spesial',
            'deskripsi' => 'Mie goreng dengan bumbu spesial',
            'harga_satuan' => 7000,
            'foto_menu' => 'mie.jpeg'
        ]);
        // Menu untuk Toko 2 (Salad Pak Nafi)
        Menu::create([
            'id_toko' => 2,
            'nama_menu' => 'Salad Buah',
            'deskripsi' => 'Salad dengan potongan melon dan semangka',
            'harga_satuan' => 25000,
            'foto_menu' => 'sb.jpeg'
        ]);
        Menu::create([
            'id_toko' => 2,
            'nama_menu' => 'Es teler Durian Jawa',
            'deskripsi' => 'Es teler dengan durian khas jawa',
            'harga_satuan' => 22000,
            'foto_menu' => 'etd.jpeg'
        ]);
        Menu::create([
            'id_toko' => 2,
            'nama_menu' => 'Es Teh Manis',
            'deskripsi' => 'Teh manis dingin segar',
            'harga_satuan' => 5000,
            'foto_menu' => 'eth.jpeg'
        ]);
        Menu::create([
            'id_toko' => 2,
            'nama_menu' => 'Es Campur',
            'deskripsi' => 'Campuran berbagai buah segar',
            'harga_satuan' => 5000,
            'foto_menu' => 'ec.jpg'
        ]);
        Menu::create([
            'id_toko' => 2,
            'nama_menu' => 'Es Jeruk Nipis',
            'deskripsi' => 'Es jeruk nipis dengan rasa segar',
            'harga_satuan' => 5000,
            'foto_menu' => 'jn.jpg'
        ]);
        // Menu untuk Toko 3 (Warung Mbok Yem)
        Menu::create([
            'id_toko' => 3,
            'nama_menu' => 'Nasi Goreng Spesial',
            'deskripsi' => 'Nasi goreng dengan telur dan ayam',
            'harga_satuan' => 15000,
            'foto_menu' => 'ngs.jpg'
        ]);
        Menu::create([
            'id_toko' => 3,
            'nama_menu' => 'Nasi Pecel',
            'deskripsi' => 'Nasi dengan sayuran dan sambal pecel',
            'harga_satuan' => 12000,
            'foto_menu' => 'pcl.jpg'
        ]);
        Menu::create([
            'id_toko' => 3,
            'nama_menu' => 'Nasi Uduk',
            'deskripsi' => 'Nasi uduk dengan lauk pauk',
            'harga_satuan' => 15000,
            'foto_menu' => 'ngs.jpg'
        ]);
        Menu::create([
            'id_toko' => 3,
            'nama_menu' => 'Nasi Kuning',
            'deskripsi' => 'Nasi kuning dengan lauk pauk',
            'harga_satuan' => 10000,
            'foto_menu' => 'nkn.jpg'
        ]);
        Menu::create([
            'id_toko' => 3,
            'nama_menu' => 'Nasi Ayam Goreng',
            'deskripsi' => 'Nasi yang disajikan dengan ayam goreng',
            'harga_satuan' => 12000,
            'foto_menu' => 'aym.jpg'
        ]);
    }
}