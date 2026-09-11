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
    Schema::create('requests', function (Blueprint $table) {
        $table->id();

        $table->string('kode_request');
        $table->string('nama_bahan');
        $table->string('kategori');
        $table->integer('sisa_stock');
        $table->text('keterangan')->nullable();

        $table->enum('status', ['pending','diterima','ditolak'])
              ->default('pending');

        $table->dateTime('tanggal_kirim');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_barangs');
    }
};
