<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,           // HARUS jalan duluan 
            JurusanSeeder::class,
            AdminJurusanSeeder::class,   // Observer otomatis jalan di sini
            ProdukSeeder::class,
            UserSeeder::class,
        ]);
    }
}