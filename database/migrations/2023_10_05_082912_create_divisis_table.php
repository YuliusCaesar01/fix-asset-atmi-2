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
        Schema::create('divisis', function (Blueprint $table) {
            $table->increments('id_divisi');
            $table->integer('id_institusi')->unsigned();
            $table->string('nama_divisi');
            $table->string('kode_divisi')->comment('kode untuk FA')->nullable();
            $table->timestamps();
            $table->foreign('id_institusi')->references('id_institusi')->on('institusis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('divisis');
    }
};
