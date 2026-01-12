<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Toko;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $tokoDenganMenu = Toko::with(['menu.photos'])->get();
        return response()->json($tokoDenganMenu);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pelanggan' => 'required|string|max:100',
            'no_telepon_pelanggan' => 'required|string|max:20',
            'no_meja' => 'required|string|max:10',
            'items' => 'required|array|min:1',
            'items.*.id_menu' => 'required|integer|exists:menu,id_menu',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validated();

        try {
            $transaksi = DB::transaction(function () use ($validated) {

                $menuPertama = Menu::find($validated['items'][0]['id_menu']);
                $idToko = $menuPertama->id_toko;

                $transaksi = Transaksi::create([
                    'nama_pelanggan' => $validated['nama_pelanggan'],
                    'no_telepon_pelanggan' => $validated['no_telepon_pelanggan'],
                    'no_meja' => $validated['no_meja'],
                    'status_pesanan' => 'pending',
                    'total_pembayaran' => 0,
                    'id_toko' => $idToko,
                ]);

                $total = 0;

                foreach ($validated['items'] as $item) {
                    $menu = Menu::find($item['id_menu']);
                    $subtotal = $menu->harga_satuan * $item['jumlah'];

                    DetailTransaksi::create([
                        'id_transaksi' => $transaksi->id_transaksi,
                        'id_menu' => $menu->id_menu,
                        'nama_menu_snapshot' => $menu->nama_menu,
                        'harga_snapshot' => $menu->harga_satuan,
                        'jumlah' => $item['jumlah'],
                        'subtotal' => $subtotal,
                    ]);

                    $total += $subtotal;
                }

                $transaksi->total_pembayaran = $total;
                $transaksi->save();

                return $transaksi;
            });

            return response()->json([
                'message' => 'Pesanan berhasil dibuat. Silakan bayar di kasir.',
                'transaksi' => $transaksi->load('detailTransaksi.menu.toko')
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal membuat pesanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
