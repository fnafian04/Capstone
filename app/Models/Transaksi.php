<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $primaryKey = 'id_transaksi';
    protected $table = 'transaksi';

    // Tambahkan id_toko agar bisa disimpan
    protected $fillable = [
        'no_meja',
        'total_pembayaran',
        'status_pesanan',
        'id_kasir',
        'nama_pelanggan',
        'no_telepon_pelanggan',
        'id_toko', // <--- wajib masuk fillable
    ];

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'id_kasir');
    }

    // Relasi baru ke toko
    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko');
    }
}
