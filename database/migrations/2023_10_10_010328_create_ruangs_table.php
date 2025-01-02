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
        Schema::create('ruangs', function (Blueprint $table) {
            $table->increments('id_ruang');
            $table->unsignedInteger('id_lokasi')->nullable();
            $table->string('nama_ruang_yayasan')->nullable();
            $table->string('nama_ruang_mikael')->nullable();
            $table->string('nama_ruang_politeknik')->nullable();
            $table->string('foto_ruang')->nullable();  
            $table->string('kode_ruang')->nullable(); // Make it nullable
            $table->timestamps();
            $table->foreign('id_lokasi')->references('id_lokasi')->on('lokasis')->onDelete('cascade');

        });
        
    }
    /** 
     * Reverse the migrations deadline on proyek need to be clear but not to great
     */
    public function down(): void
    {
        Schema::dropIfExists('ruangs');
    }
};
