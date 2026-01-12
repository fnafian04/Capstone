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
        // 1. Tambah Logo di tabel Toko
        Schema::table('toko', function (Blueprint $table) {
            if (!Schema::hasColumn('toko', 'logo_toko')) {
                $table->string('logo_toko')->nullable()->after('nama_toko');
            }
        });

        // ❌ Jangan tambah no_telepon_pelanggan lagi
        // Kolom itu SUDAH dibuat di create_transaksi
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('toko', function (Blueprint $table) {
            if (Schema::hasColumn('toko', 'logo_toko')) {
                $table->dropColumn('logo_toko');
            }
        });

        // ❌ Jangan drop no_telepon_pelanggan di sini
    }
};
