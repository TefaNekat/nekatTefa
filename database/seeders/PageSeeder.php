<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        Page::create([
            'slug' => 'home',
            'judul' => 'Selamat Datang di TEFA Katapang',
            'konten' => 'Teaching Factory (TEFA) Katapang adalah program pembelajaran berbasis industri yang menghadirkan pengalaman kerja nyata bagi siswa SMK. Kami menaungi 7 jurusan yang menghasilkan produk berkualitas industri.',
        ]);

        Page::create([
            'slug' => 'contact',
            'judul' => 'Hubungi Kami',
            'konten' => 'Untuk pertanyaan umum seputar TEFA Katapang, silakan hubungi kami melalui email: info@tefakatapang.sch.id',
        ]);
    }
}