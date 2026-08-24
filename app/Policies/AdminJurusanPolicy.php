<?php

namespace App\Policies;

use App\Models\AdminJurusan;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminJurusanPolicy
{
    use HandlesAuthorization;

    public function viewAny(AdminJurusan $user): bool
    {
        return $user->can('view_any_admin_jurusan');
    }

    public function view(AdminJurusan $user, AdminJurusan $adminJurusan): bool
    {
        return $user->can('view_admin_jurusan');
    }

    public function create(AdminJurusan $user): bool
    {
        return $user->can('create_admin_jurusan');
    }

    public function update(AdminJurusan $user, AdminJurusan $adminJurusan): bool
    {
        return $user->can('update_admin_jurusan');
    }

    public function delete(AdminJurusan $user, AdminJurusan $adminJurusan): bool
    {
        return $user->can('delete_admin_jurusan');
    }

    public function deleteAny(AdminJurusan $user): bool
    {
        return $user->can('delete_any_admin_jurusan');
    }
}
