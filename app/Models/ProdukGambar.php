<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukGambar extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'path_gambar',
        'urutan'
        ];

    protected static function booted(): void
    {
        static::addGlobalScope('urutan', function ($query) {
            $query->orderBy('urutan');
    });
}

    public function produk(){
        return $this->belongsTo(Produk::class);
    }
}