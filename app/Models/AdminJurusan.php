<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class AdminJurusan extends Authenticatable implements FilamentUser
{
    use Notifiable, HasRoles;

    protected $guard_name = 'admin'; // Spatie Permission perlu tau role ini "berlaku" di guard yang mana

    // ... sisanya tetap sama (fillable, hidden, casts, jurusan(), isSuperAdmin(), canAccessPanel())

    protected $fillable = [
        'jurusan_id',
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}