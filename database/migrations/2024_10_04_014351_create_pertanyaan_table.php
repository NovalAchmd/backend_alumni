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
        Schema::create('pertanyaan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_pertanyaan')->autoIncrement();
            $table->unsignedBigInteger('id_alumni');
            $table->text('pertanyaan');
            $table->timestamps();
            $table->foreign('id_alumni')->references('id_alumni')->on('alumni');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan');
    }
};
