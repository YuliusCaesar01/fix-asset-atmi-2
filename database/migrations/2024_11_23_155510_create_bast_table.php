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
        Schema::create('bast', function (Blueprint $table) {
            $table->id('id_bast'); // Primary key
            $table->unsignedBigInteger('id_permintaan_fa'); // Foreign key for Permintaan Fix Asset
            $table->unsignedBigInteger('id_user'); // Foreign key for User
            $table->string('BAST')->default('FA-BAST'); // Default value for BAST
            $table->string('bulan'); // For storing month
            $table->year('tahun'); // For storing year
            $table->timestamps();

            // Correct foreign key constraint
            $table->foreign('id_permintaan_fa')->references('id_permintaan_fa')->on('permintaan_fixed_assets');
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bast');
    }
};
