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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');

            // ➕ WAJIB ADA agar FK berhasil
            $table->unsignedBigInteger('id_toko'); 

            $table->string('nama_pelanggan', 100)->nullable();
            $table->string('no_telepon_pelanggan', 20)->nullable();

            $table->string('no_meja', 10)->nullable();
            $table->timestamp('waktu_pemesanan')->useCurrent();
            $table->decimal('total_pembayaran', 12, 2)->default(0);
            $table->enum('status_pesanan', ['pending', 'diproses', 'selesai'])->default('pending');

            $table->foreignId('id_kasir')
                ->nullable()
                ->constrained('users', 'id')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
