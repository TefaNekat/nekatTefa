<?php

namespace App\Policies;

use App\Models\Produk;
use App\Models\AdminJurusan;

class ProdukPolicy
{
    public function update(AdminJurusan $admin, Produk $produk)
    {
        return $admin->jurusan_id === $produk->jurusan_id;
    }

    public function delete(AdminJurusan $admin, Produk $produk)
    {
        return $admin->jurusan_id === $produk->jurusan_id;
    }
}