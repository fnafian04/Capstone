<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi; // <-- Panggil Model Transaksi
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- Panggil DB facade

class LaporanController extends Controller
{
    /**
     * Fungsi 1: Menampilkan laporan penjualan (GET)
     * GET /api/admin/laporan
     * GET /api/admin/laporan?status=diproses
     */
    public function getLaporan(Request $request){
        // Mulai query
        $query = Transaksi::query();

        // Filter berdasarkan status jika ada
        if ($request->has('status')) {
            $query->where('status_pesanan', $request->status);
        } else {
            // Defaultnya, hanya tampilkan yg sudah dibayar
            $query->whereIn('status_pesanan', ['diproses', 'selesai']);
        }

        // Ambil data
        $transaksi = $query->with('detailTransaksi.menu.toko', 'kasir') // Ambil relasi
                           ->orderBy('waktu_pemesanan', 'desc')
                           ->get();
        
        // Hitung total omset
        $totalOmset = $transaksi->sum('total_pembayaran');
        
        // Hitung omset per toko
        $omsetPerToko = Transaksi::whereIn('status_pesanan', ['diproses', 'selesai'])
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
        // Tambahkan method baru di LaporanController
    public function getRiwayatTransaksi()
    {
        $riwayat = \App\Models\Transaksi::with(['detailTransaksi.menu.toko', 'kasir'])
                    ->whereIn('status_pesanan', ['diproses', 'selesai'])
                    ->orderBy('waktu_pemesanan', 'desc')
                    ->get();
        return response()->json($riwayat);
    }

    /**
     * Ambil semua pesanan pending (untuk monitoring admin)
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
     * Ambil semua riwayat transaksi
     */
    public function getRiwayat()
    {
        $data = Transaksi::whereIn('status_pesanan', ['diproses', 'selesai'])
                         ->with('detailTransaksi.menu.toko', 'kasir')
                         ->orderBy('waktu_pemesanan', 'desc')
                         ->get();
        return response()->json($data);
    }
}