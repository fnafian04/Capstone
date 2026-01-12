<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Events\TransaksiDibayar;

class KasirController extends Controller
{
    public function getPending()
    {
        return response()->json(
            Transaksi::where('status_pesanan', 'pending')
                ->with('detailTransaksi.menu.toko')
                ->orderBy('waktu_pemesanan', 'asc')
                ->get()
        );
    }

    public function getRiwayat()
    {
        return response()->json(
            Transaksi::whereIn('status_pesanan', ['diproses', 'selesai'])
                ->with(['detailTransaksi.menu.toko', 'kasir'])
                ->orderBy('waktu_pemesanan', 'desc')
                ->get()
        );
    }

    public function validasi(Request $request, $id_transaksi)
    {
        $transaksi = Transaksi::with('detailTransaksi.menu.toko')->find($id_transaksi);

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        if ($transaksi->status_pesanan !== 'pending') {
            return response()->json(['message' => 'Transaksi sudah diproses'], 400);
        }

        $transaksi->status_pesanan = 'diproses';
        $transaksi->id_kasir = Auth::id();
        $transaksi->save();

        // 🔔 Kirim WA ke toko / admin
        event(new TransaksiDibayar($transaksi));

        // Log internal
        try {
            $pesananPerToko = [];

            foreach ($transaksi->detailTransaksi as $detail) {
                if ($detail->menu && $detail->menu->toko) {
                    $tokoId = $detail->menu->toko->id_toko;

                    if (!isset($pesananPerToko[$tokoId])) {
                        $pesananPerToko[$tokoId] = [
                            'no_hp' => $detail->menu->toko->no_telepon,
                            'items' => [],
                        ];
                    }

                    $pesananPerToko[$tokoId]['items'][] =
                        "{$detail->jumlah}x {$detail->nama_menu_snapshot}";
                }
            }

            foreach ($pesananPerToko as $data) {
                Log::info("WA toko dikirim ke {$data['no_hp']}");
            }

        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return response()->json([
            'message' => 'Transaksi berhasil divalidasi',
            'transaksi' => $transaksi->load(['detailTransaksi.menu.toko', 'kasir'])
        ]);
    }

    public function hapus($id_transaksi)
    {
        $transaksi = Transaksi::with('detailTransaksi')->find($id_transaksi);

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        // ❌ Hanya boleh hapus jika pending
        if ($transaksi->status_pesanan !== 'pending') {
            return response()->json(['message' => 'Tidak bisa menghapus, transaksi sudah diproses'], 400);
        }

        // Hapus detail dulu
        $transaksi->detailTransaksi()->delete();

        // Hapus transaksi
        $transaksi->delete();

        return response()->json([
            'message' => 'Transaksi berhasil dihapus'
        ]);
    }
}
