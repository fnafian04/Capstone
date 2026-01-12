<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; 

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Menu::with(['toko', 'photos']);
        if ($request->has('id_toko') && $request->id_toko != "") {
            $query->where('id_toko', $request->id_toko);
        }
        return response()->json($query->get());
    }

    public function show($id)
    {
        // Penting: Load 'photos' agar tombol edit bisa menampilkan foto lama
        $menu = Menu::with(['toko', 'photos'])->find($id);
        if (!$menu) return response()->json(['message' => 'Menu tidak ditemukan'], 404);
        return response()->json($menu);
    }

    public function store(Request $request)
    {
        // Log request untuk debugging
        Log::info('Store Menu:', $request->all());

        $validator = Validator::make($request->all(), [
            'id_toko' => 'required',
            'nama_menu' => 'required|string',
            'harga_satuan' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'foto_menu.*' => 'nullable|image|max:5120' // Max 5MB per foto
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validasi Gagal', 'errors' => $validator->errors()], 422);
        }

        try {
            // 1. Simpan Data Menu
            $menu = Menu::create($request->only(['id_toko', 'nama_menu', 'harga_satuan', 'deskripsi']));

            // 2. Simpan Foto (Looping)
            if ($request->hasFile('foto_menu')) {
                foreach ($request->file('foto_menu') as $file) {
                    $path = $file->store('menu_photos', 'public');
                    MenuPhoto::create([
                        'id_menu' => $menu->id_menu,
                        'foto_path' => $path
                    ]);
                }
            }

            return response()->json($menu->load('photos'), 201);

        } catch (\Exception $e) {
            Log::error('Error Store Menu: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal Server: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $menu = Menu::find($id);
            
            if (!$menu) {
                return response()->json(['message' => 'Menu tidak ditemukan'], 404);
            }

            $validator = Validator::make($request->all(), [
                'id_toko' => 'required',
                'nama_menu' => 'required|string',
                'harga_satuan' => 'required',
                'deskripsi' => 'nullable|string',
                'foto_menu.*' => 'nullable|image|max:5120'
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Validasi Gagal', 'errors' => $validator->errors()], 422);
            }

            // Update Data Teks
            $menu->update($request->only(['id_toko', 'nama_menu', 'harga_satuan', 'deskripsi']));

            // Tambah Foto Baru (jika ada)
            if ($request->hasFile('foto_menu')) {
                foreach ($request->file('foto_menu') as $file) {
                    $path = $file->store('menu_photos', 'public');
                    MenuPhoto::create([
                        'id_menu' => $menu->id_menu,
                        'foto_path' => $path
                    ]);
                }
            }

            // Refresh relasi untuk respon
            return response()->json($menu->fresh(['photos']));

        } catch (\Exception $e) {
            // INI KUNCINYA: Tangkap error server dan kirim sebagai JSON
            return response()->json([
                'message' => 'Server Error saat Update',
                'error_detail' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }
    public function destroy($id)
    {
        $menu = Menu::with('photos')->find($id);
        if (!$menu) return response()->json(['message' => 'Menu tidak ditemukan'], 404);

        // Hapus file fisik foto
        foreach ($menu->photos as $photo) {
            Storage::disk('public')->delete($photo->foto_path);
        }

        $menu->delete();
        return response()->json(null, 204);
    }

    public function deletePhoto($id)
    {
        $photo = MenuPhoto::find($id);
        if(!$photo) return response()->json(['message' => 'Foto tidak ditemukan'], 404);

        // Hapus file dari storage
        Storage::disk('public')->delete($photo->foto_path);
        
        // Hapus record dari DB
        $photo->delete();

        return response()->json(['message' => 'Foto berhasil dihapus']);
    }
}