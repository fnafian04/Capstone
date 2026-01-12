<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaksi;
use Carbon\Carbon;

class CleanupPendingOrders extends Command
{
    // Nama perintah yang akan dipanggil
    protected $signature = 'orders:cleanup';

    // Deskripsi perintah
    protected $description = 'Hapus pesanan pending yang lebih tua dari 24 jam';

    public function handle()
    {
        // Cari pesanan 'pending' yang dibuat sebelum 24 jam yang lalu
        $batasWaktu = Carbon::now()->subHours(24);
        
        $deleted = Transaksi::where('status_pesanan', 'pending')
                            ->where('waktu_pemesanan', '<', $batasWaktu)
                            ->delete();

        $this->info("Berhasil menghapus {$deleted} pesanan pending yang kadaluarsa.");
    }
}