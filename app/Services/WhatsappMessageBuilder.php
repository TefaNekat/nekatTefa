<?php

namespace App\Services;

use App\Models\Produk;
use App\Models\User;

class WhatsappMessageBuilder
{
    public function build(User $user, Produk $produk): string
    {
        return "Halo Admin {$produk->jurusan->nama}, saya {$user->name} tertarik dengan produk \"{$produk->nama}\". "
            . "Mohon informasi lebih lanjut. Terima kasih.\n\n"
            . "Kontak saya:\n"
            . "Email: {$user->email}\n"
            . "No. HP: {$user->phone}";
    }

    public function generateLink(User $user, Produk $produk): string
    {
        $nomorWa = $produk->jurusan->nomor_wa;
        $pesan = $this->build($user, $produk);

        return 'https://wa.me/' . $this->formatNomor($nomorWa) . '?text=' . urlencode($pesan);
    }

    private function formatNomor(string $nomor): string
    {
        $nomor = preg_replace('/[^0-9]/', '', $nomor);

        if (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        }

        return $nomor;
    }
}