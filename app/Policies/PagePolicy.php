<?php

namespace App\Policies;

use App\Models\AdminJurusan;
use App\Models\Page;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(AdminJurusan $user): bool
    {
        return $user->can('view_any_page');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(AdminJurusan $user, Page $page): bool
    {
        return $user->can('view_page');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(AdminJurusan $user): bool
    {
        return $user->can('create_page');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(AdminJurusan $user, Page $page): bool
    {
        return $user->can('update_page');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(AdminJurusan $user, Page $page): bool
    {
        return $user->can('delete_page');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(AdminJurusan $user): bool
    {
        return $user->can('delete_any_page');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(AdminJurusan $user, Page $page): bool
    {
        return $user->can('force_delete_page');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(AdminJurusan $user): bool
    {
        return $user->can('force_delete_any_page');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(AdminJurusan $user, Page $page): bool
    {
        return $user->can('restore_page');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(AdminJurusan $user): bool
    {
        return $user->can('restore_any_page');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(AdminJurusan $user, Page $page): bool
    {
        return $user->can('replicate_page');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(AdminJurusan $user): bool
    {
        return $user->can('reorder_page');
    }
}