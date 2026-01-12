<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Toko extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'id_toko';
    protected $table = 'toko';
    protected $fillable = ['nama_toko', 'alamat', 'no_telepon','logo_toko'];
    protected $appends = ['logo_url'];
   protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                // Cek apakah key 'logo_toko' ada dan tidak null
                if (isset($attributes['logo_toko']) && $attributes['logo_toko']) {
                    return Storage::url($attributes['logo_toko']);
                }
                return null;
            },
        );
    }

    public function menu() {
        return $this->hasMany(Menu::class, 'id_toko');
    }
}
