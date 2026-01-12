<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\KasirController;
use App\Http\Controllers\Api\Admin\TokoController;
use App\Http\Controllers\Api\Admin\MenuController;
use App\Http\Controllers\Api\Admin\LaporanController;
use App\Http\Controllers\Api\Admin\ManajemenKasirController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// === 1. PUBLIC ===
Route::get('/menu', [OrderController::class, 'index']);
Route::post('/order', [OrderController::class, 'store']);

// === 2. AUTH ===
Route::post('/login', [AuthController::class, 'login']);

// === 3. PROTECTED ROUTES ===
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // === KASIR ===
    Route::prefix('kasir')->middleware('kasir')->group(function () {
        Route::get('/pesanan-pending', [KasirController::class, 'getPending']);
        Route::get('/riwayat', [KasirController::class, 'getRiwayat']);
        Route::post('/validasi/{id_transaksi}', [KasirController::class, 'validasi']);
        Route::post('/selesai/{id_transaksi}', [KasirController::class, 'selesaikan']);
        Route::delete('/transaksi/{id_transaksi}', [KasirController::class, 'hapus']);
    });

    // === ADMIN ===
    Route::prefix('admin')->middleware('admin')->group(function () {

        // Dashboard & Laporan
        Route::get('/pending', [LaporanController::class, 'getPending']);
        Route::get('/riwayat', [LaporanController::class, 'getRiwayat']);

        // === TOKO ===
        Route::get('/toko', [TokoController::class, 'index']);
        Route::post('/toko', [TokoController::class, 'store']);
        Route::get('/toko/{id}', [TokoController::class, 'show']);
        Route::put('/toko/{id}', [TokoController::class, 'update']);
        Route::delete('/toko/{id}', [TokoController::class, 'destroy']);

        // === MENU ===
        Route::get('/menu', [MenuController::class, 'index']);
        Route::post('/menu', [MenuController::class, 'store']);
        Route::get('/menu/{id}', [MenuController::class, 'show']);
        Route::put('/menu/{id}', [MenuController::class, 'update']);
        Route::delete('/menu/{id}', [MenuController::class, 'destroy']);
        Route::delete('/menu/photo/{id}', [MenuController::class, 'deletePhoto']);

        // === MANAJEMEN KASIR ===
        Route::get('/manajemen-kasir', [ManajemenKasirController::class, 'index']);
        Route::post('/manajemen-kasir', [ManajemenKasirController::class, 'store']);
        Route::put('/manajemen-kasir/{id}', [ManajemenKasirController::class, 'update']);
        Route::delete('/manajemen-kasir/{id}', [ManajemenKasirController::class, 'destroy']);
    });
});
