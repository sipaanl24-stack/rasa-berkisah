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
        Schema::create('data_barang', function (Blueprint $table) {
            $table->increments('barang_id');
            $table->string('kode', 50)->nullable();
            $table->string('nama_bahan', 100)->nullable();
            $table->string('kategori', 100)->nullable();
            $table->integer('stock')->nullable();
            $table->string('satuan', 50)->nullable();
            $table->integer('harga')->nullable();
            $table->date('masuk')->nullable();
            $table->date('expired')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_barang');
    }
};