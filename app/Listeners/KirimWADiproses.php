<?php

namespace App\Listeners;

use App\Events\TransaksiDibayar;
use App\Services\FonnteService;
use Illuminate\Support\Facades\Log;

class KirimWADiproses
{
    public function handle(TransaksiDibayar $event)
    {
        $t = $event->transaksi->load('detailTransaksi.menu.toko');

        // Kelompokkan menu berdasarkan toko
        $pesananPerToko = [];

        foreach ($t->detailTransaksi as $detail) {
            if (!$detail->menu || !$detail->menu->toko) continue;

            $idToko = $detail->menu->toko->id_toko;
            $hp = $detail->menu->toko->no_telepon;

            if (!isset($pesananPerToko[$idToko])) {
                $pesananPerToko[$idToko] = [
                    'hp' => $hp,
                    'items' => []
                ];
            }

            $pesananPerToko[$idToko]['items'][] =
                "{$detail->jumlah}x {$detail->nama_menu_snapshot}";
        }

        $fonnte = new FonnteService();

        foreach ($pesananPerToko as $data) {
            $menuText = implode("\n", $data['items']);

            $pesan =
                "🍽️ Hai! Ada pesanan masuk 👇\n\n" .
                "🆔 ID: {$t->id_transaksi}\n" .
                "🧑‍🦱 Nama: {$t->nama_pelanggan}\n" .        
                "🪑 Meja: {$t->no_meja}\n\n" .
                "📦 *Daftar Pesanan:*\n" .
                "{$menuText}\n\n" .
                "💰 Sudah dibayar & divalidasi kasir.\n" .
                "Mohon segera disiapkan 🙏";

            Log::info("📩 WA DIKIRIM KE {$data['hp']}");

            $fonnte->send($data['hp'], $pesan);
        }
    }
}
