<?php

namespace Tests\Feature;

use App\Http\Controllers\TransactionController;
use App\Models\DetailTransaksi;
use App\Models\Meja;
use App\Models\MenuMakanan;
use App\Models\Transaksi;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ],
        ]);

        Schema::create('meja', function (Blueprint $table) {
            $table->id();
            $table->string('nama_meja');
            $table->timestamps();
        });

        Schema::create('menu_makanan', function (Blueprint $table) {
            $table->id('menu_id');
            $table->string('nama_makanan');
            $table->integer('harga');
            $table->timestamps();
        });

        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi');
            $table->unsignedBigInteger('meja_id');
            $table->string('nama_pelanggan')->nullable();
            $table->integer('total_harga')->default(0);
            $table->integer('bayar')->default(0);
            $table->integer('kembalian')->default(0);
            $table->string('status')->default('pending');
            $table->timestamp('waktu_bayar')->nullable();
            $table->timestamps();
        });

        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaksi_id');
            $table->unsignedBigInteger('menu_id');
            $table->integer('harga');
            $table->integer('qty');
            $table->integer('subtotal');
            $table->timestamps();
        });
    }

    public function test_opening_transaction_from_on_hold_uses_transaction_id_not_meja_id(): void
    {
        $meja = Meja::create([
            'nama_meja' => 'Meja 9',
        ]);

        $menu = MenuMakanan::create([
            'nama_makanan' => 'Nasi Goreng',
            'harga' => 25000,
        ]);

        $transaksi = Transaksi::create([
            'kode_transaksi' => 'TRX-001',
            'meja_id' => $meja->id,
            'nama_pelanggan' => 'Budi',
            'total_harga' => 25000,
            'bayar' => 0,
            'kembalian' => 0,
            'status' => 'pending',
        ]);

        DetailTransaksi::create([
            'transaksi_id' => $transaksi->id,
            'menu_id' => $menu->menu_id,
            'harga' => 25000,
            'qty' => 1,
            'subtotal' => 25000,
        ]);

        $view = app(TransactionController::class)->index(new Request(), $transaksi->id);

        $this->assertSame($transaksi->id, $view->getData()['transaksi']->id);
        $this->assertSame('Budi', $view->getData()['transaksi']->nama_pelanggan);
        $this->assertSame('Nasi Goreng', $view->getData()['transaksi']->detail->first()->menu->nama_makanan);
    }
}
