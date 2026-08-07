<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void{
        User::create([
            'name' => 'Customer Test',
            'email' => 'customer@nekatefa.com',
            'phone' => '081234567899',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'Mang dee',
            'email' => 'mangde@example.com',
            'phone' => '081298765432',
            'password' => bcrypt('password'),
        ]);
    }
}
