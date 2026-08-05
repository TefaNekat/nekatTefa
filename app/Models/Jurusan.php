<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jurusan extends Model
{
    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'nomor_wa',
    ];

    public function produks(): HasMany
    {
        return $this->hasMany(Produk::class);
    }

    public function adminJurusans(): HasMany
    {
        return $this->hasMany(AdminJurusan::class);
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }
}