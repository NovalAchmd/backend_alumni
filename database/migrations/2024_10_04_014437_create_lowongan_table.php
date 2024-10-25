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
            $table->unsignedBigInteger('nib')->unique();
            $table->string('judul_lowongan');
            $table->string('posisi_pekerjaan');
            $table->string('deskripsi_pekerjaan');
            $table->string("gambar");
            $table->enum('tipe_pekerjaan', ['Full_time', 'Part_time', "Contract"]);
            $table->string('jumlah_kandidat');
            $table->string('lokasi');
            $table->string('rentang_gaji');
            $table->string('pengalaman_kerja');
            $table->string('kontak');
            $table->enum("status", ['terima', 'tolak', 'pending']);
            $table->date('tanggal_aktif');
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
