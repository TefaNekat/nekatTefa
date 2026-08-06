<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Produk extends Model
{
    protected $fillable = [
        'jurusan_id',
        'nama',
        'slug',
        'deskripsi',
        'fungsi',
        'manfaat',
        'fitur_keunggulan',
        'harga',
        'status',
    ];

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function produkGambars(): HasMany
    {
        return $this->hasMany(ProdukGambar::class)->orderBy('urutan');
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    protected function hargaFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp ' . number_format($this->harga, 0, ',', '.'),
        );
    }
}