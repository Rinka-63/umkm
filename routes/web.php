<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\OwnerController;
use App\Exports\RiwayatPenjualanExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/admin/beranda', [AdminController::class, 'index'])
        ->name('admin.beranda');

    Route::get('/kasir/beranda', [KasirController::class, 'index'])
        ->name('kasir.beranda');

    Route::get('/owner/beranda', [OwnerController::class, 'index'])
        ->name('owner.beranda');

});
// Group Route khusus Admin (Harus Login)
Route::middleware(['auth'])->group(function () {
    // Navigasi (Hanya butuh satu method index karena kita pakai @if di blade)
    Route::get('/admin/beranda', [AdminController::class, 'index'])->name('admin.beranda');
    Route::get('/admin/barang', [AdminController::class, 'index'])->name('admin.barang');
    Route::get('/admin/supplier', [AdminController::class, 'index'])->name('admin.supplier');
    Route::get('/admin/riwayat', [AdminController::class, 'index'])->name('admin.riwayat');
    Route::get('/admin/laporan', [AdminController::class, 'index'])->name('admin.laporan');

    // Aksi Barang
    Route::post('/admin/barang/simpan', [AdminController::class, 'storeBarang']);
    Route::put('/admin/barang/update/{id}', [AdminController::class, 'updateBarang']);
    Route::delete('/admin/barang/hapus/{id}', [AdminController::class, 'destroyBarang']);

    // Aksi Supplier
    Route::post('/admin/supplier/simpan', [AdminController::class, 'storeSupplier']);
    Route::put('/admin/supplier/update/{id}', [AdminController::class, 'updateSupplier']);
    Route::delete('/admin/supplier/hapus/{id}', [AdminController::class, 'destroySupplier']);

    // Aksi Transaksi
    Route::get('/admin/penjualan', [AdminController::class, 'laporanPenjualan'])->name('admin.laporan.penjualan');
    
    // Aksi Laporan
    Route::post('/admin/barang/simpan', [AdminController::class, 'storeBarang'])->name('barang.store');
    Route::put('/admin/barang/update/{id}', [AdminController::class, 'updateBarang'])->name('barang.update');
    Route::delete('/admin/barang/hapus/{id}', [AdminController::class, 'destroyBarang'])->name('barang.destroy');
});

// Group Route khusus Kasir
Route::middleware(['auth'])->group(function () {
    Route::get('/kasir/beranda', [KasirController::class, 'index'])->name('kasir.beranda');
    Route::get('/kasir/barang', [KasirController::class, 'index'])->name('kasir.barang');
    Route::get('/kasir/penjualan', [KasirController::class, 'index'])->name('kasir.penjualan');
    Route::get('/kasir/riwayat', [KasirController::class, 'index'])->name('kasir.riwayat');
    Route::get('/kasir/laporan', [KasirController::class, 'laporan'])->name('kasir.laporan');

    // Aksi Transaksi
    Route::get('/penjualan/create', [KasirController::class, 'create'])->name('penjualan.create');
    Route::post('/penjualan/store', [KasirController::class, 'storePenjualan'])->name('penjualan.store');
    Route::get('/admin/penjualan', [KasirController::class, 'index'])
    ->name('admin.penjualan');
    Route::get('/kasir/export-excel', function (Request $request) {
        $from = $request->get('from');
        $to = $request->get('to');
        
        $nama_file = 'riwayat-penjualan';
        if($from && $to) $nama_file .= '-' . $from . '-to-' . $to;
        
        return Excel::download(new RiwayatPenjualanExport($from, $to), $nama_file . '.xlsx');
    })->name('kasir.export');

    // Aksi Laporan
    Route::get('/kasir/laporan', [KasirController::class, 'laporan'])->name('kasir.laporan');

});

// Group Route khusus Owner
Route::middleware(['auth'])->group(function () {
    Route::get('/owner/beranda', [OwnerController::class, 'index'])->name('owner.beranda');
    Route::get('/owner/barang', [OwnerController::class, 'index'])->name('owner.barang');
    Route::get('/owner/riwayat', [OwnerController::class, 'index'])->name('owner.riwayat');

});

