<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\MenuPhoto;

class MigrateMenuPhotosSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua menu
        $menus = Menu::all();

        foreach ($menus as $menu) {
            // Cek apakah menu punya data di kolom lama 'foto_menu'
            // Dan pastikan belum ada data di tabel baru (agar tidak duplikat jika dijalankan 2x)
            if (!empty($menu->foto_menu) && $menu->photos()->count() == 0) {
                
                MenuPhoto::create([
                    'id_menu' => $menu->id_menu,
                    'foto_path' => $menu->foto_menu // Pindahkan path lama ke tabel baru
                ]);
                
                $this->command->info("Migrasi foto untuk menu: {$menu->nama_menu}");
            }
        }
    }
}