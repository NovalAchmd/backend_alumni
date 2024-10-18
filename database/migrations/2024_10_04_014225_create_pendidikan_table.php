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
        Schema::create('pendidikan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_pdd')->autoIncrement();
            $table->unsignedBigInteger('id_alumni');
            $table->string('perguruan_tinggi');
            $table->string('jurusan');
            $table->string('tahun_lulus');
            $table->string('ipk');
            $table->timestamps();
            $table->foreign('id_alumni')->references('id_alumni')->on('alumni');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendidikan');
    }
};
