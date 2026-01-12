<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ManajemenKasirController extends Controller
{
    public function index()
    {
        // Ambil semua user dengan role kasir
        $kasir = User::where('role', 'kasir')->get();
        return response()->json($kasir);
    }

    // UPDATE KASIR
    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if (!$user || $user->role !== 'kasir') return response()->json(['message' => 'User tidak valid'], 404);

            $rules = [
                'username' => 'required|string|unique:users,username,'.$id,
            ];
            // Password hanya divalidasi jika diisi (opsional saat edit)
            if ($request->filled('password')) {
                $rules['password'] = 'min:4';
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

            $user->username = $request->username;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            return response()->json(['message' => 'Berhasil update kasir']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal update', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:4',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role'     => 'kasir',
                'id_toko'  => null,
            ]);

            return response()->json(['message' => 'Berhasil', 'data' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user || $user->role !== 'kasir') {
            return response()->json(['message' => 'User tidak valid'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'Berhasil dihapus']);
    }
}