<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID utama tabel, tipe BigInteger auto-increment

            // Kolom foreign key ke tabel users
            $table->unsignedBigInteger('id_user_pengirim'); // ID pengguna pengirim
            $table->unsignedBigInteger('id_user_penerima'); // ID pengguna penerima
            
            // Foreign key untuk pengajuan permintaan fixed asset
            $table->unsignedBigInteger('id_pengajuan')->nullable(); // ID pengajuan dari tabel permintaan_fixed_assets

            // Jenis notifikasi, misal: system, user
            $table->string('jenis_notif', 50)->default('user'); 
            
            // Keterangan notifikasi yang bisa berisi teks panjang
            $table->text('keterangan_notif'); 
            
            // Tipe notifikasi: apakah dikirim lewat email, sistem, atau keduanya
            $table->enum('tipe_notif', ['email', 'system', 'keduanya'])->default('system');
            
            // Kolom opsional untuk periode aktif notifikasi dan tanggal kadaluarsa
            $table->dateTime('read_at')->nullable(); 
    

            // Timestamps otomatis untuk mencatat waktu pembuatan dan pembaruan
            $table->timestamps(); 

            // Indeks untuk mempercepat pencarian berdasarkan pengguna penerima dan pengirim
            $table->index('id_user_penerima');
            $table->index('id_user_pengirim');
            $table->index('id_pengajuan'); // Index untuk id_pengajuan

            // Foreign key constraints untuk menjaga referensialitas data
            $table->foreign('id_user_pengirim')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_user_penerima')->references('id')->on('users')->onDelete('cascade');

            // Foreign key untuk menghubungkan dengan tabel permintaan_fixed_assets
            $table->foreign('id_pengajuan')->references('id_permintaan_fa')->on('permintaan_fixed_assets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Jika ingin rollback, tabel notifications akan dihapus
        Schema::dropIfExists('notifications');
    }
}
