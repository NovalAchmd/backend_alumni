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
        Schema::create('data_jawaban', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_alumni")->unique();
            $table->unsignedBigInteger('id_pertanyaan')->unique();
            $table->string('jawaban_terbuka')->nullable();
            $table->string('jawaban_skala');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_jawaban');
    }
};
