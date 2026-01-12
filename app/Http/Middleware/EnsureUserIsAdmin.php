<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- Tambahkan ini

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN rolenya 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            // Jika iya, loloskan
            return $next($request);
        }

        // Jika tidak, tolak
        return response()->json(['message' => 'Akses ditolak. Hanya untuk Admin.'], 403);
    }
}