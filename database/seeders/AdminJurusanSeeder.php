<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminJurusan;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Hash;

class AdminJurusanSeeder extends Seeder
{
    public function run()
    {
        // 1. Super Admin Web (tidak terikat jurusan)
        AdminJurusan::updateOrCreate(
            ['email' => 'super@nekatefa.com'],
            [
                'jurusan_id' => null,
                'name' => 'Super Admin Web',
                'password' => Hash::make('admin'),
                'role' => 'super_admin',
            ],
        );

        // 2. Admin untuk setiap jurusan
        $jurusans = Jurusan::all();
        foreach ($jurusans as $jurusan) {
            AdminJurusan::updateOrCreate(
                ['email' => 'admin.' . $jurusan->slug . '@nekatefa.com'],
                [
                    'jurusan_id' => $jurusan->id,
                    'name' => 'Admin ' . $jurusan->nama,
                    'password' => Hash::make($jurusan->nama),
                    'role' => 'admin_jurusan',
                ],
            );

            AdminJurusan::where('jurusan_id', $jurusan->id)
                ->where('role', 'admin_jurusan')
                ->update(['password' => Hash::make($jurusan->nama)]);
        }
    }
}