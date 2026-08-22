<?php

namespace App\Providers;

use App\Models\AdminJurusan;
use App\Observers\AdminJurusanObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    // Ditaruh di method boot() karena itu tempat standar buat "menyalakan" hal-hal semacam ini pas aplikasi mulai jalan.
    public function boot(): void
    {
        AdminJurusan::observe(AdminJurusanObserver::class); // pasang Observer ini buat "mendengar" semua kejadian yang terjadi ke Model AdminJurusan

        // KUNCI MASTER: Jika yang login punya role 'super_admin', langsung izinkan SEMUA fitur
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });
    }
}