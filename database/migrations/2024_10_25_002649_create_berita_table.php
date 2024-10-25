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
        Schema::create('berita', function (Blueprint $table) {
            $table->unsignedBigInteger("id_berita")->autoIncrement();
            $table->string("judul_berita");
            $table->date("tanggal_terbit");
            $table->string("deskripsi_berita");
            $table->string("gambar");
            $table->string("link");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
