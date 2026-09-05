<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\Produk;
use App\Models\ProdukGambar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $jurusans = Jurusan::all();

        $namaProdukContoh = [
            'Produk Unggulan A',
            'Produk Unggulan B',
            'Produk Unggulan C',
        ];

        foreach ($jurusans as $jurusan) {
            foreach ($namaProdukContoh as $index => $namaProduk) {
                $namaLengkap = $namaProduk . ' - ' . $jurusan->nama;

                $produk = Produk::updateOrCreate(
                    [
                        'jurusan_id' => $jurusan->id,
                        'nama' => $namaLengkap,
                    ],
                    [
                        'slug' => Str::slug($namaLengkap),
                        'deskripsi' => 'Ini adalah deskripsi contoh untuk ' . $namaLengkap . '.',
                        'fungsi' => 'Fungsi utama produk ini adalah sebagai contoh data dummy.',
                        'manfaat' => 'Manfaat produk ini untuk keperluan testing dan development.',
                        'fitur_keunggulan' => 'Fitur unggulan: kualitas terjamin, harga terjangkau.',
                        'harga' => (50 + ($index * 100)) * 1000,
                        'status' => 'published',
                    ],
                );

                for ($i = 1; $i <= 3; $i++) {
                    ProdukGambar::updateOrCreate(
                        [
                            'produk_id' => $produk->id,
                            'urutan' => $i,
                        ],
                        [
                            'path_gambar' => 'produk/dummy-' . $i . '.jpg',
                        ],
                    );
                }
            }
        }
    }
}