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
        Schema::create('menu', function (Blueprint $table) {
            $table->id('id_menu');
            $table->foreignId('id_toko')->constrained('toko', 'id_toko')->onDelete('cascade');
            $table->string('nama_menu', 100)->nullable();
            $table->text('deskripsi')->nullable();
            $table->decimal('harga_satuan', 10, 2)->default(0);
            $table->string('foto_menu')->nullable();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu', function (Blueprint $table) {
            $table->dropColumn('foto_menu');
        });
    }
};
