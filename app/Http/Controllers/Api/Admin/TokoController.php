<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class TokoController extends Controller
{
    /**
     * Fungsi 1: Menampilkan semua toko (GET)
     * Terhubung ke: GET /api/admin/toko
     */
    public function index()
    {
        $tokos = Toko::all();
        return response()->json($tokos);
    }

    /**
     * Fungsi 2: Menyimpan toko baru (POST)
     * Terhubung ke: POST /api/admin/toko
     */
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'nama_toko' => 'required|string|max:100',
        'alamat' => 'nullable|string',
        'no_telepon' => 'nullable|string|max:20',
        'logo_toko' => 'nullable|image|max:2048' // Validasi Gambar
    ]);

    if ($validator->fails()) return response()->json($validator->errors(), 422);

    $data = $validator->validated();

    if ($request->hasFile('logo_toko')) {
        $data['logo_toko'] = $request->file('logo_toko')->store('', 'public');
    }

    $toko = Toko::create($data);
    return response()->json($toko, 201);
}

    /**
     * Fungsi 3: Menampilkan satu toko (GET by ID)
     * Terhubung ke: GET /api/admin/toko/{id}
     */
    public function show($id)
    {
        $toko = Toko::find($id);

        if (!$toko) {
            return response()->json(['message' => 'Toko tidak ditemukan'], 404); // 404 Not Found
        }

        return response()->json($toko);
    }

    /**
     * Fungsi 4: Memperbarui toko (PUT)
     * Terhubung ke: PUT /api/admin/toko/{id}
     */
    public function update(Request $request, $id)
{
    $toko = Toko::find($id);
    if (!$toko) return response()->json(['message' => 'Toko tidak ditemukan'], 404);

    // Gunakan method POST dengan _method=PUT di frontend untuk upload file
    $validator = Validator::make($request->all(), [
        'nama_toko' => 'sometimes|required|string|max:100',
        'alamat' => 'nullable|string',
        'no_telepon' => 'nullable|string|max:20',
        'logo_toko' => 'nullable|image|max:2048'
    ]);

    if ($validator->fails()) return response()->json($validator->errors(), 422);

    $data = $validator->validated();

    if ($request->hasFile('logo_toko')) {
        if ($toko->logo_toko) Storage::disk('public')->delete($toko->logo_toko);
        $data['logo_toko'] = $request->file('logo_toko')->store('', 'public');
    }

    $toko->update($data);
    return response()->json($toko);
}

    /**
     * Fungsi 5: Menghapus toko (DELETE)
     * Terhubung ke: DELETE /api/admin/toko/{id}
     */
    public function destroy($id)
    {
        $toko = Toko::find($id);
        if (!$toko) {
            return response()->json(['message' => 'Toko tidak ditemukan'], 404);
        }

        $toko->delete();
        // 204 No Content (berhasil, tidak ada konten untuk dikembalikan)
        return response()->json(null, 204); 
    }
}