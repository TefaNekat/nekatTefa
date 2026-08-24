<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = Role::firstOrCreate([ // mencegah error kalau Seeder ini nggak sengaja dijalankan 2 kali.
            'name' => 'super_admin_web',
            'guard_name' => 'admin',
        ]);

        $adminJurusan = Role::firstOrCreate([
            'name'=> 'admin_jurusan',
            'guard_name' => 'admin',
        ]);

        $permissions = collect([
            'view_any_page',
            'view_page',
            'create_page',
            'update_page',
            'delete_page',
            'delete_any_page',
            'force_delete_page',
            'force_delete_any_page',
            'restore_page',
            'restore_any_page',
            'replicate_page',
            'reorder_page',
            'view_any_admin_jurusan',
            'view_admin_jurusan',
            'create_admin_jurusan',
            'update_admin_jurusan',
            'delete_admin_jurusan',
            'delete_any_admin_jurusan',
        ])->map(fn (string $name) => Permission::firstOrCreate([
            'name' => $name,
            'guard_name' => 'admin',
        ]));

        $superAdmin->syncPermissions($permissions);
        $adminJurusan->syncPermissions([]);
    }
}
