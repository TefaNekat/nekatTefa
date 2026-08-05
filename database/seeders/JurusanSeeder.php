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
            ['nama' => 'Teknik Elektronika Industri', 'slug' => 'tei', 'deskripsi' => 'Fokus pada sistem kontrol dan elektronika daya.', 'nomor_wa' => '081234567891'],
            ['nama' => 'Teknik Kendaraan Ringan', 'slug' => 'tkr', 'deskripsi' => 'Fokus pada perawatan dan perbaikan kendaraan ringan.', 'nomor_wa' => '081234567892'],
            ['nama' => 'Teknik Komputer dan Jaringan', 'slug' => 'tkj', 'deskripsi' => 'Fokus pada infrastruktur jaringan dan keamanan siber.', 'nomor_wa' => '081234567893'],
            ['nama' => 'Multimedia', 'slug' => 'mm', 'deskripsi' => 'Fokus pada desain grafis, animasi, dan produksi video.', 'nomor_wa' => '081234567894'],
            ['nama' => 'Akuntansi', 'slug' => 'akuntansi', 'deskripsi' => 'Fokus pada pencatatan dan analisis keuangan.', 'nomor_wa' => '081234567895'],
            ['nama' => 'Tata Boga', 'slug' => 'boga', 'deskripsi' => 'Fokus pada pengolahan makanan dan manajemen usaha kuliner.', 'nomor_wa' => '081234567896'],
        ];

        foreach ($data as $item) {
            Jurusan::create($item);
        }
    }
}