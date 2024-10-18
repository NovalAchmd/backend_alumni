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
        Schema::create('lowongan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_lowongan')->autoIncrement();
            $table->unsignedBigInteger('id_perusahaan');
            $table->string('judul_lowongan');
            $table->string('posisi_pekerjaan');
            $table->string('deskripsi_pekerjaan');
            $table->enum('tipe_pekerjaan', ['Full_time', 'Part_time', "internship"]);
            $table->enum('sistem_kerja', ['WFH', 'WFO']);
            $table->string('jumlah_kandidat');
            $table->string('lokasi');
            $table->date('tanggal_aktif');
            $table->string('rentang_gaji');
            $table->string('pengalaman_kerja');
            $table->string('kontak');
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongan');
    }
};
