<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate([ // mencegah error kalau Seeder ini nggak sengaja dijalankan 2 kali.
            'name' => 'super_admin_web',
            'guard_name' => 'admin',
        ]);

        Role::firstOrCreate([
            'name'=> 'admin_jurusan',
            'guard_name' => 'admin',
        ]);
    }
}
