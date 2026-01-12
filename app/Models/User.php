<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false; // <-- DITAMBAHKAN

    protected $fillable = ['username', 'password', 'role'];
    protected $hidden = ['password', 'remember_token'];
    
    // Hash password otomatis saat membuat/update user
    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => bcrypt($value),
        );
    }

    public function transaksiValidasi() {
        return $this->hasMany(Transaksi::class, 'id_kasir');
    }
}