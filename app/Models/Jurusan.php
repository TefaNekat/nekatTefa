<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi massal
    protected $fillable = ['nama', 'slug', 'deskripsi', 'nomor_wa'];

    // Relasi ke Produk (satu jurusan punya banyak produk)
    public function produk()
    {
        return $this->hasMany(Produk::class);
    }

    // Relasi ke Lead (satu jurusan punya banyak lead)
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    // Relasi ke AdminJurusan (satu jurusan bisa punya banyak admin? Tapi di desain 1:1, kita pakai hasMany dulu)
    public function adminJurusan()
    {
        return $this->hasMany(AdminJurusan::class);
    }
}