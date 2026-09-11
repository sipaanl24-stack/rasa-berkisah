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
        Schema::create('karyawan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_karyawan', 20);
            $table->string('nama_karyawan', 100);
            $table->string('email', 100);
            $table->string('password', 255)->nullable();
            $table->enum('role', ['admin', 'kitchen', 'kasir']);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->string('kontak', 20);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};