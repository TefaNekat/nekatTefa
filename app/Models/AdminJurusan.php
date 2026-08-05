<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // penting!
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminJurusan extends Authenticatable
{
    use HasFactory, HasRoles;

    // Nama tabel (default 'admin_jurusans' sudah sesuai)
    protected $table = 'admin_jurusans';

    protected $fillable = [
        'jurusan_id',
        'name',
        'email',
        'password',
        'role'
        ];

    protected $hidden = ['password', 'remember_token'];

    // Relasi balik ke Jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}