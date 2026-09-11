<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PosController;


// =====================================================
// HALAMAN AWAL
// =====================================================

Route::get('/', function () {
    return view('welcome');
});


// =====================================================
// LOGIN & LOGOUT
// =====================================================

// Halaman login
Route::get('/login', [AuthController::class, 'loginForm'])
    ->name('login');

// Proses login
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

// Proses logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// Halaman welcome
Route::get('/welcome', [AuthController::class, 'welcome'])
    ->name('welcome');


// =====================================================
// ROUTE KHUSUS ADMIN
// =====================================================

Route::middleware('cekrole:admin')->group(function () {

    // -------------------------------------------------
    // DASHBOARD
    // -------------------------------------------------

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard.index');


    // -------------------------------------------------
    // KELOLA PERSEDIAAN BAHAN
    // -------------------------------------------------

    Route::get('/inventory', [InventoryController::class, 'index'])
        ->name('inventory.index');

    Route::post('/inventory/store', [InventoryController::class, 'store'])
        ->name('inventory.store');

    Route::post('/inventory/update/{barang_id}', [InventoryController::class, 'update'])
        ->name('inventory.update');

    Route::delete('/inventory/delete/{barang_id}', [InventoryController::class, 'destroy'])
        ->name('inventory.delete');


    // -------------------------------------------------
    // KELOLA RESEP DAN HARGA JUAL MENU
    // -------------------------------------------------

    Route::prefix('menu')->group(function () {

        Route::get('/', [MenuController::class, 'index'])
            ->name('menu.index');

        Route::post('/store', [MenuController::class, 'store'])
            ->name('menu.store');

        Route::post('/update/{id}', [MenuController::class, 'update'])
            ->name('menu.update');

        Route::delete('/delete/{id}', [MenuController::class, 'delete'])
            ->name('menu.delete');
    });


    // -------------------------------------------------
    // KELOLA DATA KARYAWAN
    // -------------------------------------------------

    Route::prefix('karyawan')
        ->controller(KaryawanController::class)
        ->group(function () {

            Route::get('/', 'index') ->name('karyawan.index');
            Route::post('/store', 'store') ->name('karyawan.store');
            Route::put('/update/{id}', 'update') ->name('karyawan.update');
            Route::delete('/delete/{id}', 'destroy') ->name('karyawan.delete');
        });


    // -------------------------------------------------
    // MENYETUJUI PENGAJUAN BAHAN
    // -------------------------------------------------

    Route::get('/request', [RequestController::class, 'index'])
        ->name('request.index');

    Route::post('/request/store', [RequestController::class, 'store'])
        ->name('request.store');


    // -------------------------------------------------
    // SUPPLIER
    // -------------------------------------------------

    Route::get('/suplai', [SupplierController::class, 'index']) ->name('supplier.index');
    Route::post('/suplai/update/{id}', [SupplierController::class, 'updateStatus']) ->name('supplier.update');

    // -------------------------------------------------
    // JADWAL KERJA KARYAWAN
    // -------------------------------------------------

    Route::get('/shift_karyawan', [ShiftController::class, 'index']) ->name('shift_karyawan.index');
    Route::post('/shift_karyawan/store', [ShiftController::class, 'store']) ->name('shift_karyawan.store');
    Route::put('/shift_karyawan/update', [ShiftController::class, 'update']) ->name('shift_karyawan.update');
    Route::get('/shift_karyawan/delete/{id}', [ShiftController::class, 'delete']) ->name('shift_karyawan.delete');
    Route::get('/shift_karyawan/download', [ShiftController::class, 'download']) ->name('shift_karyawan.download');

    // -------------------------------------------------
    // KELOLA KEUANGAN / JURNAL
    // -------------------------------------------------

    Route::get('/jurnal', [JurnalController::class, 'index']) ->name('jurnal.index'); 

    // -------------------------------------------------
    // MELIHAT KEHADIRAN KARYAWAN
    // -------------------------------------------------

    Route::get('/kehadiran', [KehadiranController::class, 'index']) ->name('kehadiran.index');
    Route::get('/kehadiran/rekap', [KehadiranController::class, 'rekap']) ->name('kehadiran.rekap');
});


// =============================
// KASIR
// =============================
Route::middleware('cekrole:kasir')->group(function () {

    // TRANSAKSI
Route::prefix('transaction')->group(function () {

    Route::get('/', [TransactionController::class, 'index'])
        ->name('transaction.index');

    Route::post('/simpan', [TransactionController::class, 'simpan'])
        ->name('transaction.store');

    Route::get('/onhold', [TransactionController::class, 'onhold'])
        ->name('transaction.onhold');

    Route::delete('/onhold/{id}', [TransactionController::class, 'destroyOnhold'])
        ->name('transaction.destroy');

    Route::get('/print/{id}', [TransactionController::class, 'print'])
        ->name('transaction.print');

    Route::get('/{id}', [TransactionController::class, 'index'])
        ->name('transaction.edit');
});

    

    // MEJA
    Route::prefix('pos')->group(function () {
        Route::get('/', [PosController::class, 'index'])
            ->name('pos.index');

        Route::get('/meja', [PosController::class, 'manage'])
            ->name('pos.meja');

        Route::post('/meja', [PosController::class, 'store'])
            ->name('pos.meja.store');

        Route::put('/meja/{id}', [PosController::class, 'update'])
            ->name('pos.meja.update');

        Route::delete('/meja/{id}', [PosController::class, 'destroy'])
            ->name('pos.meja.destroy');

        Route::get('/layout', [PosController::class, 'layout'])
            ->name('pos.layout');

        Route::post('/layout/save', [PosController::class, 'saveLayout'])
            ->name('pos.layout.save');

        Route::post('/layout/{id}', [PosController::class, 'updateLayout'])
            ->name('pos.layout.update');
    });

});


// =============================
// KITCHEN
// =============================
Route::middleware('cekrole:kitchen')->group(function () {

    // PENGAJUAN BAHAN
    Route::get('/request', [RequestController::class, 'index']) ->name('request.index');
    Route::post('/request/store', [RequestController::class, 'store'])  ->name('request.store');

    // PESANAN
    Route::get('/pesanan', [PesananController::class, 'index']) ->name('pesanan.index'); 
    Route::post('/pesanan/selesai/{id}', [PesananController::class, 'selesai']) ->name('pesanan.selesai');

});