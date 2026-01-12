<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('menu_photos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_menu')->constrained('menu', 'id_menu')->onDelete('cascade');
        $table->string('foto_path'); // Lokasi file foto
        // Tidak perlu timestamps agar ringan
    });

    // Opsional: Kita bisa menghapus kolom 'foto_menu' lama di tabel menu nanti,
    // tapi untuk keamanan data saat ini, biarkan dulu atau buat nullable.
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_photos');
    }
};
