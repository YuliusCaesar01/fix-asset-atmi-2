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
        Schema::create('tipes', function (Blueprint $table) {
            $table->increments('id_tipe');
            $table->string('nama_tipe_yayasan')->nullable();
            $table->string('kode_tipe')->comment('untuk kode FA')->nullable(); 
            $table->string('foto_tipe')->nullable();  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipes');
    }
};
