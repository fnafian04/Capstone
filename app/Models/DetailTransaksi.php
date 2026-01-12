<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// ...
class DetailTransaksi extends Model
{
    use HasFactory;
    public $timestamps = false; // <-- DITAMBA
    protected $primaryKey = 'id_detail';
    protected $table = 'detail_transaksi'; // Eksplisit
    protected $fillable = ['id_transaksi',
     'id_menu',
      'nama_menu_snapshot', 
      'harga_snapshot',
       'jumlah',
        'subtotal',
        'status_saji'
    ];

    public function menu() {
        return $this->belongsTo(Menu::class, 'id_menu');
    }

    public function transaksi() {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }
}