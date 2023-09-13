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
        Schema::create('petugass', function (Blueprint $table) {
            $table->id();
            $table->string('nama_petugas', 50);
            $table->string('jabatan_petugas', 50);
            $table->char('no_telp_petugas', 13);
            $table->string('alamat_petugas', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petugass');
    }
};
