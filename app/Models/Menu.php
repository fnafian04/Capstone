<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Menu extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'id_menu';
    protected $table = 'menu';

    protected $fillable = [
        'id_toko', 'nama_menu', 'deskripsi', 'harga_satuan', 'foto_menu'
    ];

    protected $appends = ['foto_url', 'all_photos'];

    public function toko() {
        return $this->belongsTo(Toko::class, 'id_toko');
    }

    public function photos() {
        return $this->hasMany(MenuPhoto::class, 'id_menu');
    }

    // Accessor: Array URL Semua Foto (Versi Aman)
    protected function allPhotos(): Attribute
    {
        return Attribute::make(
            get: function () {
                try {
                    // Cek apakah relasi sudah dimuat dan tidak kosong
                    if ($this->relationLoaded('photos') && $this->photos->count() > 0) {
                        return $this->photos->map(function ($p) {
                            // Pastikan properti url ada dan valid
                            return $p->url ?? null;
                        })->filter(); // Hapus yang null
                    }
                } catch (\Exception $e) {
                    // Diamkan error, kembalikan array kosong
                }
                return collect([]);
            },
        );
    }

    // Accessor: URL Foto Utama/Thumbnail (Versi Aman)
    protected function fotoUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                try {
                    // 1. Cek tabel relasi menu_photos
                    if ($this->relationLoaded('photos')) {
                        $firstPhoto = $this->photos->first();
                        if ($firstPhoto) {
                            return $firstPhoto->url;
                        }
                    }

                    // 2. Fallback: Cek kolom lama (jika ada)
                    // Gunakan array_key_exists untuk menghindari error "Undefined array key"
                    if (is_array($attributes) && array_key_exists('foto_menu', $attributes) && !empty($attributes['foto_menu'])) {
                        return Storage::url($attributes['foto_menu']);
                    }
                } catch (\Exception $e) {
                    // Jika error, kembalikan null (gambar default)
                }

                return null; 
            },
        );
    }
}