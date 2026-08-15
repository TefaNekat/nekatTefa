<?php

namespace App\Observers;

use App\Models\AdminJurusan;

class AdminJurusanObserver
{
    /**
     * Handle the AdminJurusan "created" event.
     */
    public function created(AdminJurusan $adminJurusan): void // created() otomatis jalan
    {
        $this->syncRole($adminJurusan);
    }

    /**
     * Handle the AdminJurusan "updated" event.
     */
    public function updated(AdminJurusan $adminJurusan): void 
    {
        if($adminJurusan->isDirty('role')) { // sinkronisasi ulang KALAU kolom role-nya emang berubah
            $this->syncRole($adminJurusan);
        }
    }

    private function syncRole(adminJurusan $adminJurusan): void
    {
        $roleShield = $adminJurusan->role === 'super_admin' // ini yang isi logic "penerjemahan"
            ? 'super_admin_web'
            : 'admin_jurusan';

        $adminJurusan->syncRoles([$roleShield]); //dia otomatis mengganti role lama kalau ada, bukan numpuk
    }
}
