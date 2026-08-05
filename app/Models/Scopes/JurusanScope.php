<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class JurusanScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // Jika admin jurusan sedang login (guard 'admin')
        if (auth()->guard('admin')->check()) {
            $admin = auth()->guard('admin')->user();
            // Hanya filter jika role-nya admin_jurusan (bukan super admin)
            if ($admin->role === 'admin_jurusan') {
                $builder->where('jurusan_id', $admin->jurusan_id);
            }
        }
    }
}