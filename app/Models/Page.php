<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    // Mengizinkan 3 kolom ini untuk diisi data (mass assignment)
    protected $fillable = [
        'slug',
        'judul',
        'konten',
    ];
}