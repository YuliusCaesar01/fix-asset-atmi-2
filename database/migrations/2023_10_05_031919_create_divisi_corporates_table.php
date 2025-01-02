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
        // ada 3 divisi corporate
        Schema::create('divisi_corporates', function (Blueprint $table) {
            $table->increments('id_divisicorp');
            $table->string('nama_divisicorp');
            $table->string('kode_divisicorp')->comment('kode untuk permintaan FA');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('divisi_corporates');
    }
};
