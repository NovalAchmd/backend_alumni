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
            $table->unsignedBigInteger("user_id")->unique();
            $table->string('nama_perusahaan');
            $table->string('nib');
            $table->string('alamat');
            $table->string('email_perusahaan');
            $table->string('sektor_bisnis');
            $table->string('deskripsi_perusahaan');
            $table->string('no_tlp');
            $table->string('email');
            $table->string('foto');
            $table->string('website_perusahaan');
            $table->enum('status', ['mengunggu', 'diterima', 'ditolak']);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
