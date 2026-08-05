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
    Schema::create('admin_jurusans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('jurusan_id')->constrained()->onDelete('restrict');
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->enum('role', ['super_admin', 'admin_jurusan']);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('admin_jurusans');
}
};
