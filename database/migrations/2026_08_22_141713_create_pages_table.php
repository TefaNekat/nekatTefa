<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // Contoh isi: 'home', 'contact'
            $table->string('judul'); // Contoh isi: 'Selamat Datang di TEFA', 'Hubungi Kami'
            $table->text('konten'); // Teks panjang penjelasannya
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};