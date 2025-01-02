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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->unsignedInteger('id_divisi');
            $table->unsignedBigInteger('role_id')->nullable(); // Foreign key to roles.id
            $table->timestamp('email_verified_at')->nullable();
            $table->string('ttd')->default('ttd/dummy.png');
            $table->rememberToken();
            $table->timestamps();
        
            // Set up the foreign key constraints for divisi
            $table->foreign('id_divisi')->references('id_divisi')->on('divisis')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id'); // This should be an unsigned big integer
        });
    }
};
