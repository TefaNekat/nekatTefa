<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate([
            'name' => 'super_admin_web',
            'guard_name' => 'admin',
        ]);

        Role::firstOrCreate([
            'name'=> 'admin_jurusan',
            'guard_name' => 'admin',
        ]);
    }
}
