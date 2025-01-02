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
        Schema::create('permintaan_non_fixed_assets', function (Blueprint $table) {
            $table->increments('id_permintaan_nfa');
            $table->unsignedBigInteger('id_user'); // Use unsignedBigInteger
            $table->unsignedInteger('id_institusi'); // New foreign key column
            
            $table->string('deskripsi_pengajuan');
            $table->string('email_karyawan');
            $table->enum('validasi_kabeng', ['setuju', 'revisi', 'ditolak', 'menunggu'])->default('menunggu');
            $table->enum('validasi_kaprodi', ['setuju', 'revisi', 'ditolak', 'menunggu'])->default('menunggu');
            $table->enum('validasi_corp', ['setuju', 'revisi', 'ditolak', 'menunggu'])->default('menunggu');
            $table->enum('status', ['menunggu', 'proses', 'selesai', 'ditolak', 'vendor'])->default('menunggu');
            $table->enum('jenis_pelayanan', ['barang', 'jasa'])->nullable();
            $table->enum('kebutuhan', ['non_subcon', 'subcon', 'tidak_ada'])->default('tidak_ada');
            $table->string('vendor')->default('tidak_ada_vendor');
            $table->enum('validasi_finance', ['setuju', 'revisi', 'ditolak', 'menunggu'])->default('menunggu');
            $table->string('catatan')->default('tidak_ada_catatan');
            $table->string('purchase_order')->default('belum_ada');
            $table->enum('validasi_procecurement', ['setuju', 'revisi', 'ditolak', 'menunggu'])->default('menunggu');

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_institusi')->references('id_institusi')->on('institusis')->onDelete('cascade'); // Define the foreign key constraint
            // Add timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the foreign key constraints first
        Schema::table('permintaan_non_fixed_assets', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
            $table->dropForeign(['id_institusi']); // Drop the foreign key constraint for the new column
        });
    
        // Now, drop the 'permintaan_non_fixed_assets' table
        Schema::dropIfExists('permintaan_non_fixed_assets');
    }
};
