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
        Schema::create('permintaan_fixed_assets', function (Blueprint $table) {
            $table->bigIncrements('id_permintaan_fa');
            $table->unsignedBigInteger('id_user')->nullable(); // This is the foreign key
            $table->string('no_permintaan')->nullable()->comment('kode unik permintaan');
          
            $table->unsignedInteger('id_institusi')->nullable();
            $table->unsignedInteger('id_tipe')->nullable();
            $table->unsignedInteger('id_kelompok')->nullable();
            $table->unsignedInteger('id_jenis')->nullable();
            $table->unsignedInteger('id_lokasi')->nullable();
            $table->unsignedInteger('id_ruang')->nullable();
            $table->dateTime('tgl_permintaan')->default(now()->toDateTimeString());
            $table->string('no_pembelian')->nullable()->comment('nomor dari Accurate');
            $table->string('nama_barang')->nullable();
            $table->string('merk_barang')->nullable();
            $table->text('deskripsi_permintaan')->nullable()->comment('Berupa, spesifikasi');
            $table->enum('status_permohonan', ['Pengadaan Baru', 'Penjualan', 'Perbaikan', 'Pemindahan'])->nullable()->default('Pengadaan Baru');
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak','delayed'])->default('menunggu')->nullable();
            $table->string('alasan_permintaan', 100)->nullable();
            $table->string('unit_pemohon')->nullable();
            $table->string('unit_tujuan')->nullable();
            $table->string('unit_asal')->nullable();
            $table->string('foto_barang', 2048)->nullable();
            $table->string('tindak_lanjut')->nullable();
            $table->string('perkiraan_harga')->nullable();
            $table->string('perolehan_harga')->nullable();
            $table->string('jumlah_unit')->nullable();
            $table->bigInteger('no_pengesahan_bast')->nullable();
            $table->string('file_pdf', 2048)->nullable(); // New column for PDF files
            $table->string('pdf_bukti_1' , 2048)->nullable();
            $table->string('file_pengesahan_bast' , 2048)->nullable(); // New column for PDF files
            $table->string('file_pengajuan_fa' , 2048)->nullable(); // New column for PDF files
            $table->double('harga_permintaan')->nullable();
            $table->enum('valid_fixaset', ['setuju', 'revisi', 'tolak', 'menunggu'])->default('menunggu');
            $table->timestamp('valid_fixaset_timestamp')->nullable();
            $table->enum('valid_karyausaha', ['setuju', 'revisi', 'tolak', 'menunggu'])->default('menunggu');
            $table->timestamp('valid_karyausaha_timestamp')->nullable();
            $table->enum('valid_ketuayayasan', ['setuju', 'revisi', 'tolak', 'menunggu'])->default('menunggu');
            $table->timestamp('valid_ketuayayasan_timestamp')->nullable();
            $table->enum('valid_dirkeuangan', ['setuju', 'revisi', 'tolak', 'menunggu'])->default('menunggu');
            $table->timestamp('valid_dirkeuangan_timestamp')->nullable();
            $table->enum('valid_dirmanageraset', ['setuju', 'revisi', 'tolak', 'menunggu'])->default('menunggu');
            $table->timestamp('valid_dirmanageraset_timestamp')->nullable();
            $table->enum('valid_manageraset', ['setuju', 'revisi', 'tolak', 'menunggu'])->default('menunggu');
            $table->timestamp('valid_manageraset_timestamp')->nullable();
            $table->unsignedBigInteger('delay_id')->nullable(); // This is the foreign key
            $table->timestamp('delay_timestamp')->nullable();
            $table->enum('status_barang', ['baik(100%)', 'cukup(50%)', 'rusak'])
            ->nullable()
            ->default('baik(100%)');
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_user')->references('id')->on('users')->onDelete('set null');
            $table->foreign('id_jenis')->references('id_jenis')->on('jenis')->onDelete('set null');
            $table->foreign('id_tipe')->references('id_tipe')->on('tipes')->onDelete('cascade');
            $table->foreign('id_kelompok')->references('id_kelompok')->on('kelompoks')->onDelete('cascade');
            $table->foreign('id_institusi')->references('id_institusi')->on('institusis')->onDelete('cascade');
            $table->foreign('id_ruang')->references('id_ruang')->on('ruangs')->onDelete('cascade');
            $table->foreign('id_lokasi')->references('id_lokasi')->on('lokasis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan_fixed_assets');
    }
};
