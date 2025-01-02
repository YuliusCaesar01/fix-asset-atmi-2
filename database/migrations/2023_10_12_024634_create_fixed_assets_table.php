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
        Schema::create('fixed_assets', function (Blueprint $table) {
            $table->string('id_fa')->unique();
            $table->unsignedInteger('id_institusi');
            $table->unsignedInteger('id_divisi');
            $table->unsignedInteger('id_tipe');
            $table->unsignedInteger('id_kelompok');
            $table->unsignedInteger('id_jenis');
            $table->unsignedInteger('id_lokasi');
            $table->unsignedInteger('id_ruang');
            $table->string('no_permintaan')->nullable();
            $table->year('tahun_diterima')->nullable();
            $table->string('foto_barang')->nullable();
            $table->string('jumlah_unit')->nullable();
            $table->string('unit_asal')->nullable();
            $table->string('kode_fa')->nullable();
            $table->string('nama_barang')->nullable();
            $table->text('des_barang')->nullable();
            
            // Perbaiki nilai default
            $table->enum('status_transaksi', ['Pengadaan Baru', 'Perbaikan', 'Penjualan', 'Pemindahan'])
                  ->nullable()
                  ->default('Pengadaan Baru');
            $table->enum('status_barang', ['baik(100%)', 'cukup(50%)', 'rusak'])
                  ->nullable()
                  ->default('baik(100%)');

            $table->unsignedInteger('id_user');
            $table->unsignedInteger('status_fa');
            $table->string('file_pdf')->nullable(); // New column for PDF files
            $table->timestamps();
             
            $table->foreign('id_institusi')->references('id_institusi')->on('institusis')->onDelete('cascade');
            $table->foreign('id_divisi')->references('id_divisi')->on('divisis')->onDelete('cascade');
            $table->foreign('id_tipe')->references('id_tipe')->on('tipes')->onDelete('cascade');
            $table->foreign('id_kelompok')->references('id_kelompok')->on('kelompoks')->onDelete('cascade');
            $table->foreign('id_jenis')->references('id_jenis')->on('jenis')->onDelete('cascade');
            $table->foreign('id_lokasi')->references('id_lokasi')->on('lokasis')->onDelete('cascade');
            $table->foreign('id_ruang')->references('id_ruang')->on('ruangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixed_assets');
    }
};
