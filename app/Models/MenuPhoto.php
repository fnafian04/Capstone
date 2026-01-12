<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;


class MenuPhoto extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id_menu', 'foto_path'];
    protected $appends = ['url'];

    protected function url(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                // Cek apakah key 'foto_path' ada dan tidak kosong
                if (isset($attributes['foto_path']) && !empty($attributes['foto_path'])) {
                    return Storage::url($attributes['foto_path']);
                }
                return null; // Kembalikan null jika tidak ada path
            },
        );
    }
}