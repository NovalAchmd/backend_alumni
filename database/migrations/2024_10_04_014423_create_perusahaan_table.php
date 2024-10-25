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
        Schema::create('perusahaan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_perusahaan')->autoIncrement();
            $table->unsignedBigInteger("id_user")->unique();
            $table->string('nama_perusahaan');
            $table->string('nib');
            $table->string('alamat')->nullable();
            $table->string('email')->unique();
            $table->string('sektor_bisnis');
            $table->string('deskripsi_perusahaan')->nullable();
            $table->string('jumlah_karyawan')->nullable();
            $table->string('no_tlp')->nullable();
            $table->string('foto')->nullable();
            $table->string('website_perusahaan');
            $table->enum('status', ['mengunggu', 'diterima', 'ditolak']);
            $table->timestamps();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.  
     */
    public function down(): void
    {
        Schema::dropIfExists('perusahaan');
    }
};
