<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $updates = [
            'tei' => 'Teknik Elektronika',
            'tkr' => 'Otomotif',
            'mm' => 'Broadcasting & Perfilman',
        ];

        foreach ($updates as $slug => $nama) {
            DB::table('jurusans')->where('slug', $slug)->update(['nama' => $nama]);
        }

        $departments = [
            ['nama' => 'Mesin', 'slug' => 'mesin', 'deskripsi' => 'Fokus pada proses manufaktur dan teknologi mesin.', 'nomor_wa' => '081234567897'],
            ['nama' => 'Tekstil', 'slug' => 'tekstil', 'deskripsi' => 'Fokus pada proses produksi dan pengembangan produk tekstil.', 'nomor_wa' => '081234567898'],
            ['nama' => 'Design Gambar Mesin (DGM)', 'slug' => 'dgm', 'deskripsi' => 'Fokus pada gambar teknik dan perancangan mesin.', 'nomor_wa' => '081234567899'],
            ['nama' => 'Mekatronika (Meka)', 'slug' => 'meka', 'deskripsi' => 'Fokus pada integrasi mekanik, elektronika, dan otomasi.', 'nomor_wa' => '081234567800'],
        ];

        foreach ($departments as $department) {
            DB::table('jurusans')->updateOrInsert(['slug' => $department['slug']], $department);
        }
    }

    public function down(): void
    {
        DB::table('jurusans')->whereIn('slug', ['mesin', 'tekstil', 'dgm', 'meka'])->delete();
        DB::table('jurusans')->where('slug', 'tei')->update(['nama' => 'Teknik Elektronika Industri']);
        DB::table('jurusans')->where('slug', 'tkr')->update(['nama' => 'Teknik Kendaraan Ringan']);
        DB::table('jurusans')->where('slug', 'mm')->update(['nama' => 'Multimedia']);
    }
};