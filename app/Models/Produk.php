<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\JurusanScope; 

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'jurusan_id', 'nama', 'slug', 'deskripsi', 'fungsi',
        'manfaat', 'fitur_keunggulan', 'harga', 'status'
    ];

    // Accessor untuk format harga (misal jadi Rupiah)
    public function getHargaAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }

    // Relasi ke Jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    // Relasi ke gambar (diurutkan berdasarkan urutan)
    public function gambar()
    {
        return $this->hasMany(ProdukGambar::class)->orderBy('urutan');
    }

    // Relasi ke Lead
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    // Nanti kita tambahkan Global Scope di sini
    protected static function booted()
    {
        static::addGlobalScope(new JurusanScope);
    }
}