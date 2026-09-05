<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama' => 'Rekayasa Perangkat Lunak', 'slug' => 'rpl', 'deskripsi' => 'Fokus pada pengembangan aplikasi web dan mobile.', 'nomor_wa' => '081234567890'],
            ['nama' => 'Teknik Elektronika', 'slug' => 'tei', 'deskripsi' => 'Fokus pada sistem kontrol dan elektronika daya.', 'nomor_wa' => '081234567891'],
            ['nama' => 'Otomotif', 'slug' => 'tkr', 'deskripsi' => 'Fokus pada perawatan dan perbaikan kendaraan ringan.', 'nomor_wa' => '081234567892'],
            ['nama' => 'Teknik Komputer dan Jaringan', 'slug' => 'tkj', 'deskripsi' => 'Fokus pada infrastruktur jaringan dan keamanan siber.', 'nomor_wa' => '081234567893'],
            ['nama' => 'Broadcasting & Perfilman', 'slug' => 'mm', 'deskripsi' => 'Fokus pada desain grafis, animasi, dan produksi video.', 'nomor_wa' => '081234567894'],
            ['nama' => 'Mesin', 'slug' => 'mesin', 'deskripsi' => 'Fokus pada proses manufaktur dan teknologi mesin.', 'nomor_wa' => '081234567897'],
            ['nama' => 'Tekstil', 'slug' => 'tekstil', 'deskripsi' => 'Fokus pada proses produksi dan pengembangan produk tekstil.', 'nomor_wa' => '081234567898'],
            ['nama' => 'Design Gambar Mesin (DGM)', 'slug' => 'dgm', 'deskripsi' => 'Fokus pada gambar teknik dan perancangan mesin.', 'nomor_wa' => '081234567899'],
            ['nama' => 'Mekatronika (Meka)', 'slug' => 'meka', 'deskripsi' => 'Fokus pada integrasi mekanik, elektronika, dan otomasi.', 'nomor_wa' => '081234567800'],
        ];

        foreach ($data as $item) {
            Jurusan::create($item);
        }
    }
}