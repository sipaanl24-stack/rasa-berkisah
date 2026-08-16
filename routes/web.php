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

Route::get('/', function () {
    return view('welcome');
});

// UNTUK GUDANG

Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::post('/inventory/store', [InventoryController::class, 'store']);
Route::post('/inventory/update/{barang_id}', [InventoryController::class, 'update']);
Route::delete('/inventory/delete/{barang_id}', [InventoryController::class, 'destroy']);

// UNTUK MENU

Route::prefix('menu')->group(function () {
    Route::get('/', [MenuController::class, 'index'])->name('menu.index');
    Route::post('/store', [MenuController::class, 'store']);
    Route::post('/update/{id}', [MenuController::class, 'update']);
    Route::delete('/delete/{id}', [MenuController::class, 'delete']);
});

// UNTUK KARYAWAN

Route::prefix('karyawan')->controller(KaryawanController::class)->group(function () {
    Route::get('/', 'index')->name('karyawan.index');
    Route::post('/store', 'store')->name('karyawan.store');
    Route::put('/update/{id}', 'update')->name('karyawan.update');
    Route::delete('/delete/{id}', 'destroy')->name('karyawan.delete');
});

// REQUEST

Route::get('/request', [RequestController::class, 'index']) ->name('request.index'); 
Route::post('/request/store', [RequestController::class, 'store']) ->name('request.store');


// SUPPLIER

Route::get('/suplai', [SupplierController::class, 'index'])->name('supplier.index');
Route::post('/suplai/update/{id}', [SupplierController::class, 'updateStatus']);


//UNTUK KASIR

Route::prefix('transaction')->group(function () {
    Route::get('/', [TransactionController::class, 'index']) ->name('transaction.index');
    Route::post('/simpan', [TransactionController::class, 'simpan']) ->name('transaction.store');
    Route::get('/onhold', [TransactionController::class, 'onhold']) ->name('transaction.onhold');
    Route::delete('/onhold/{id}', [TransactionController::class, 'destroyOnhold']) ->name('transaction.destroy');
    // SELALU PALING BAWAH
    Route::get('/{id}', [TransactionController::class, 'index']) ->name('transaction.edit');

});


Route::prefix('pos')->group(function () {
    // Halaman POS
    Route::get('/', [PosController::class, 'index']) ->name('pos.index');
    // Manajemen Meja
    Route::get('/meja', [PosController::class, 'manage']) ->name('pos.meja');
    Route::post('/meja', [PosController::class, 'store']) ->name('pos.meja.store');
    Route::put('/meja/{id}', [PosController::class, 'update']) ->name('pos.meja.update');
    Route::delete('/meja/{id}', [PosController::class, 'destroy']) ->name('pos.meja.destroy');
    // Layout Meja
    Route::get('/layout', [PosController::class, 'layout']) ->name('pos.layout');
    Route::post('/layout/save', [PosController::class, 'saveLayout']) ->name('pos.layout.save');
    Route::post('/layout/{id}', [PosController::class, 'updateLayout']) ->name('pos.layout.update');
});

// UNTU KITCHEN
Route::get('/pesanan', [PesananController::class, 'index']) ->name('pesanan.index');
Route::post('/pesanan/selesai/{id}', [PesananController::class, 'selesai']) ->name('pesanan.selesai');


// UNTUK SHIFT KARYAWAN

Route::get('/shift_karyawan', [ShiftController::class, 'index']) ->name('shift_karyawan.index');
Route::post('/shift_karyawan/store', [ShiftController::class, 'store']) ->name('shift_karyawan.store');
Route::get('/shift_karyawan/delete/{id}', [ShiftController::class, 'delete']) ->name('shift_karyawan.delete');

// UNTUK JURNAL

Route::get('/jurnal', [JurnalController::class, 'index']) ->name('jurnal.index');

// LOGIN

Route::get('/login',[AuthController::class,'loginForm']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/logout',[AuthController::class,'logout']) ->name('logout');
Route::get('/welcome', [AuthController::class, 'welcome']);

Route::middleware('ceklogin')->group(function(){ 
    Route::get('/dashboard', [DashboardController::class, 'index']) ->name('dashboard.index');
    Route::get('/kehadiran', [KehadiranController::class,'index'])->name('kehadiran.index');

});