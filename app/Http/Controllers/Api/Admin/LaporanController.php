<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * LAPORAN PENJUALAN
     * Hanya transaksi SELESAI yang dihitung
     * GET /api/admin/laporan
     * GET /api/admin/laporan?status=selesai
     */
    public function getLaporan(Request $request)
    {
        $query = Transaksi::query();

        // Jika filter status dikirim
        if ($request->has('status')) {
            if (!in_array($request->status, ['pending', 'selesai'])) {
                return response()->json([
                    'message' => 'Status tidak valid'
                ], 400);
            }

            $query->where('status_pesanan', $request->status);
        } else {
            // Default laporan: hanya transaksi selesai
            $query->where('status_pesanan', 'selesai');
        }

        $transaksi = $query
            ->with('detailTransaksi.menu.toko', 'kasir')
            ->orderBy('waktu_pemesanan', 'desc')
            ->get();

        // Total omset hanya dari transaksi selesai
        $totalOmset = $transaksi->sum('total_pembayaran');

        // Omset per toko (HANYA SELESAI)
        $omsetPerToko = Transaksi::where('status_pesanan', 'selesai')
            ->join('detail_transaksi', 'transaksi.id_transaksi', '=', 'detail_transaksi.id_transaksi')
            ->join('menu', 'detail_transaksi.id_menu', '=', 'menu.id_menu')
            ->join('toko', 'menu.id_toko', '=', 'toko.id_toko')
            ->select('toko.nama_toko', DB::raw('SUM(detail_transaksi.subtotal) as omset'))
            ->groupBy('toko.nama_toko')
            ->get();

        return response()->json([
            'total_omset' => $totalOmset,
            'jumlah_transaksi' => $transaksi->count(),
            'omset_per_toko' => $omsetPerToko,
            'detail_transaksi' => $transaksi,
        ]);
    }

    /**
     * PESANAN PENDING (UNTUK MONITORING ADMIN)
     */
    public function getPending()
    {
        $data = Transaksi::where('status_pesanan', 'pending')
            ->with('detailTransaksi.menu.toko')
            ->orderBy('waktu_pemesanan', 'desc')
            ->get();

        return response()->json($data);
    }

    /**
     * RIWAYAT TRANSAKSI
     * Hanya transaksi SELESAI
     */
    public function getRiwayat()
    {
        $data = Transaksi::where('status_pesanan', 'selesai')
            ->with('detailTransaksi.menu.toko', 'kasir')
            ->orderBy('waktu_pemesanan', 'desc')
            ->get();

        return response()->json($data);
    }
}
