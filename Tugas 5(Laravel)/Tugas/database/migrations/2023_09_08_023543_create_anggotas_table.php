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
        Schema::create('anggotas', function (Blueprint $table) {
            $table->id();
            $table->char('kode_anggota', 9);
            $table->string('nama_anggota', 100);
            $table->char('jk_anggota', 1);
            $table->char('jurusan_anggota', 2);
            $table->char('no_telp_anggota', 13);
            $table->string('alamat_anggota', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggotas');
    }
};
