<?php

use Illuminate\Support\Facades\Route;

// 1. Halaman Utama (ROOT) sekarang adalah LOGIN
Route::get('/', function () {
    return view('login');
});
Route::get('/login', function () {
    return view('login');
})->name('login');

// Halaman Generator QR Code
Route::get('/qr', function () {
    return view('qr');
});

// 2. Halaman Menu dipindahkan ke /menu
Route::get('/menu', function () {
    return view('menu');
});

// --- Rute Lainnya Tetap Sama ---

Route::get('/kasir', function () {
    return view('kasir');
});

Route::get('/admin', function () {
    return view('admin');
});

Route::get('/konfirmasi', function () {
    return view('konfirmasi');
});

Route::get('/struk', function () {
    return view('struk');
});