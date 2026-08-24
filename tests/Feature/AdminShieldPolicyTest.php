<?php

use App\Models\AdminJurusan;
use App\Models\Jurusan;
use App\Models\Page;
use Database\Seeders\RoleSeeder;
use Illuminate\Support\Facades\Gate;

it('blocks admin jurusan from page and admin account resources', function () {
    $this->seed(RoleSeeder::class);

    $jurusan = Jurusan::create([
        'nama' => 'Rekayasa Perangkat Lunak',
        'slug' => 'rpl',
        'deskripsi' => 'Jurusan RPL',
        'nomor_wa' => '6281234567890',
    ]);

    $adminJurusan = AdminJurusan::create([
        'jurusan_id' => $jurusan->id,
        'name' => 'Admin RPL',
        'email' => 'admin.rpl@example.com',
        'password' => 'password',
        'role' => 'admin_jurusan',
    ]);

    $targetAdmin = AdminJurusan::create([
        'jurusan_id' => $jurusan->id,
        'name' => 'Admin Lain',
        'email' => 'admin.lain@example.com',
        'password' => 'password',
        'role' => 'admin_jurusan',
    ]);

    $page = Page::create([
        'slug' => 'home',
        'judul' => 'Home',
        'konten' => 'Konten home',
    ]);

    expect(Gate::forUser($adminJurusan)->allows('viewAny', Page::class))->toBeFalse()
        ->and(Gate::forUser($adminJurusan)->allows('update', $page))->toBeFalse()
        ->and(Gate::forUser($adminJurusan)->allows('viewAny', AdminJurusan::class))->toBeFalse()
        ->and(Gate::forUser($adminJurusan)->allows('update', $targetAdmin))->toBeFalse();
});

it('allows super admin web to manage page and admin account resources', function () {
    $this->seed(RoleSeeder::class);

    $superAdmin = AdminJurusan::create([
        'jurusan_id' => null,
        'name' => 'Super Admin Web',
        'email' => 'super@example.com',
        'password' => 'password',
        'role' => 'super_admin',
    ]);

    expect(Gate::forUser($superAdmin)->allows('viewAny', Page::class))->toBeTrue()
        ->and(Gate::forUser($superAdmin)->allows('viewAny', AdminJurusan::class))->toBeTrue();
});
