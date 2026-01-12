<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- Tambahkan ini

class EnsureUserIsKasir
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek dulu apakah user sudah login
        if (!Auth::check()) {
            return response()->json(['message' => 'Akses ditolak. Anda harus login.'], 401);
        }

        $user = Auth::user();

        // Cek apakah rolenya 'kasir' ATAU 'admin'
        if ($user->role === 'kasir' || $user->role === 'admin') {
            // Jika iya, loloskan
            return $next($request);
        }

        // Jika tidak, tolak
        return response()->json(['message' => 'Akses ditolak. Hanya untuk Kasir atau Admin.'], 403);
    }
}