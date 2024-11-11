<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sensors_tb', function (Blueprint $table) {
            $table->bigIncrements('id')->length(11);
            $table->float('temp')->length(11)->default(1);
            $table->float('press')->length(11)->default(1);
            $table->integer('light')->length(11)->default(1);
            $table->float('avgpress')->length(11)->default(1);
            $table->float('avgtemp')->length(11)->default(1);
        });

        DB::table('sensors_tb')->insert([
            'temp' => 1,
            'press' => 1,
            'light' => 0,
            'avgpress' => 1,
            'avgtemp' => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensors_tb');
    }
};
