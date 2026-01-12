<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Untuk autentikasi
use Illuminate\Support\Facades\Hash; // <-- Untuk cek password
use App\Models\User; // <-- Untuk cari user
use Illuminate\Support\Facades\Validator; // <-- Untuk validasi

class AuthController extends Controller
{
    /**
     * Fungsi 1: Login
     * Terhubung ke: POST /api/login
     */
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // 1. Cari user berdasarkan username
        $user = User::where('username', $request->username)->first();

        // 2. Cek user & password
        // Kita tidak pakai Auth::attempt() karena password sudah di-hash
        // jadi kita cek manual
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Username atau Password salah.'
            ], 401); // 401 Unauthorized
        }

        // 3. Jika berhasil, buat token
        // Hapus token lama jika ada, untuk memastikan 1 device = 1 token
        $user->tokens()->delete(); 
        
        // Buat token baru
        $token = $user->createToken('auth_token_for_' . $user->username)->plainTextToken;

        // 4. Kirim respon
        return response()->json([
            'message' => 'Login berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'role' => $user->role,
            ]
        ]);
    }

    /**
     * Fungsi 2: Logout
     * Terhubung ke: POST /api/logout
     */
    public function logout(Request $request)
    {
        // Hapus token yang sedang digunakan untuk request ini
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }
}