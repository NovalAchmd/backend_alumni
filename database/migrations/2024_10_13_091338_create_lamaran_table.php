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
        Schema::create('lamaran', function (Blueprint $table) {
            $table->unsignedBigInteger('id_lamaran')->autoIncrement();
            $table->unsignedBigInteger('id_alumni');
            $table->unsignedBigInteger('id_lowongan');
            $table->string('nama_pelamar');
            $table->string('CV');
            $table->string('transkrip_nilai');
            $table->string('sertifikat');
            $table->string('portopolio');
            $table->enum("status", ['terima', 'tolak', 'pending']);
            $table->timestamps();
            $table->foreign('id_alumni')->references('id_alumni')->on('alumni');
            $table->foreign('id_lowongan')->references('id_lowongan')->on('lowongan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lamaran');
    }
};
