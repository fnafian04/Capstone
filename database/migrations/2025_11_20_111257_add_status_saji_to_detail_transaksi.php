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
        Schema::table('detail_transaksi', function (Blueprint $table) {
            // TEMPEL KODENYA DI SINI:
            // Saya tambahkan 'after' agar posisinya rapi di database
            $table->enum('status_saji', ['masak', 'siap'])
                  ->default('masak')
                  ->after('subtotal'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_transaksi', function (Blueprint $table) {
            // Ini untuk menghapus kolom jika migrasi dibatalkan (rollback)
            $table->dropColumn('status_saji');
        });
    }
};