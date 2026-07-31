<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('produks', function (Blueprint $table) {
        $table->id();
        $table->foreignId('jurusan_id')->constrained()->onDelete('restrict');
        $table->string('nama');
        $table->string('slug')->unique();
        $table->text('deskripsi');
        $table->text('fungsi');
        $table->text('manfaat');
        $table->text('fitur_keunggulan');
        $table->decimal('harga', 12, 2);
        $table->enum('status', ['draft', 'published'])->default('published');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('produks');
}
};
