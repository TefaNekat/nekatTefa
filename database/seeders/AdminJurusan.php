<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminJurusan;
use App\Models\Jurusan;

class AdminJurusanSeeder extends Seeder
{
    public function run()
    {
        // 1. Super Admin Web (tidak terikat jurusan)
        AdminJurusan::create([
            'jurusan_id' => null,
            'name' => 'Super Admin Web',
            'email' => 'super@nekatefa.com',
            'password' => bcrypt('password'),
            'role' => 'super_admin',
        ]);

        // 2. Admin untuk setiap jurusan
        $jurusans = Jurusan::all();
        foreach ($jurusans as $jurusan) {
            AdminJurusan::create([
                'jurusan_id' => $jurusan->id,
                'name' => 'Admin ' . $jurusan->nama,
                'email' => 'admin.' . $jurusan->slug . '@nekatefa.com',
                'password' => bcrypt('password'),
                'role' => 'admin_jurusan',
            ]);
        }
    }
}