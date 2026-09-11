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
        Schema::create('meja', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_meja', 20)->unique();
            $table->string('nama_meja', 100);
            $table->integer('kapasitas')->default(4);
            $table->string('area', 50)->default('Indoor');
            $table->enum('bentuk', ['bulat', 'kotak', 'persegi', 'vip'])->default('bulat');
            $table->integer('posisi_x')->default(50);
            $table->integer('posisi_y')->default(50);
            $table->enum('status', ['kosong', 'pending', 'proses', 'selesai', 'nonaktif'])->default('kosong');
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meja');
    }
};