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
        Schema::create('tracer_study', function (Blueprint $table) {
            $table->unsignedBigInteger('id_tracer_study')->autoIncrement();
            $table->unsignedBigInteger('id_pertanyaan')->unique();
            $table->text('jawaban');
            $table->timestamps();
            // $table->foreign('id_pertanyaan')->references('id_pertanyaan')->on('pertanyaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracer_study');
    }
};