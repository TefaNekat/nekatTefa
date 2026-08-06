<?php

namespace App\Policies;

use App\Models\AdminJurusan;
use App\Models\Produk;

class ProdukPolicy
{
    public function update(AdminJurusan $admin, Produk $produk): bool
    {
        return $admin->isSuperAdmin() || $admin->jurusan_id === $produk->jurusan_id;
    }

    public function delete(AdminJurusan $admin, Produk $produk): bool
    {
        return $admin->isSuperAdmin() || $admin->jurusan_id === $produk->jurusan_id;
    }
}