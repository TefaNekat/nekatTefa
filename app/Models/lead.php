<?php

namespace App\Models;

use App\Models\Scopes\JurusanScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    protected static function booted(): void
    {
    static::addGlobalScope(new JurusanScope);
    }
    protected $fillable = [
        'user_id',
        'produk_id',
        'jurusan_id',
        'status',
        'catatan_admin',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }
}