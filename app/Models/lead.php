<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\JurusanScope;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'produk_id', 'jurusan_id', 'status', 'catatan_admin'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    // Terapkan global scope juga
    protected static function booted()
    {
        static::addGlobalScope(new JurusanScope);
    }
}