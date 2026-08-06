<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class JurusanScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (!auth('admin')->check()) {
            return;
        }

        $admin = auth('admin')->user();

        if ($admin->isSuperAdmin()) {
            return;
        }

        $builder->where('jurusan_id', $admin->jurusan_id);
    }
}