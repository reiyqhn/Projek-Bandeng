<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\LaporanController;

// Halaman utama bawaan Laravel
Route::get('/', function () {
    return view('welcome');
});

// Route Beranda & Detail Produk
Route::get('/beranda', [PesananController::class, 'index'])->name('pesanan.index');
Route::get('/pesanan/detail/{id}', [PesananController::class, 'show'])->name('pesanan.show');

// Route Keranjang (Cart)
Route::post('/keranjang/tambah', [PesananController::class, 'tambahKeranjang'])->name('keranjang.tambah');
Route::get('/keranjang', [PesananController::class, 'keranjang'])->name('pesanan.keranjang');
Route::get('/keranjang/hapus/{id}', [PesananController::class, 'hapusKeranjang'])->name('keranjang.hapus');

// Route Checkout
Route::get('/checkout', [PesananController::class, 'checkout'])->name('pesanan.checkout');
Route::post('/checkout/proses', [PesananController::class, 'prosesCheckout'])->name('pesanan.prosesCheckout');

// Route Pembayaran (QRIS/Norek + Upload Bukti)
Route::get('/pesanan/pembayaran/{id}', [PesananController::class, 'pembayaran'])->name('pesanan.pembayaran');
Route::post('/pesanan/upload-bukti/{id}', [PesananController::class, 'uploadBukti'])->name('pesanan.uploadBukti');

// Route Konfirmasi / Pop-up Sukses
Route::get('/pesanan/konfirmasi/{id}', [PesananController::class, 'konfirmasi'])->name('pesanan.konfirmasi');

// Route Dashboard Admin
Route::get('/admin/dashboard', [AdminController::class, 'index']) ->name('admin.dashboard');

// Route Kelola Produk Bandeng
Route::get('/admin/bandeng', [ProdukController::class, 'index']) ->name('admin.bandeng.index');

Route::get('/admin/bandeng/tambah', [ProdukController::class, 'create']) ->name('admin.bandeng.create');

Route::post('/admin/bandeng/simpan', [ProdukController::class, 'store']) ->name('admin.bandeng.store');

Route::get('/admin/bandeng/edit/{produk}', [ProdukController::class, 'edit']) ->name('admin.bandeng.edit');

Route::put('/admin/bandeng/update/{produk}', [ProdukController::class, 'update']) ->name('admin.bandeng.update');

Route::delete('/admin/bandeng/hapus/{produk}', [ProdukController::class, 'destroy']) ->name('admin.bandeng.destroy');



// Route Laporan Pesanan
Route::get('/admin/laporan', [LaporanController::class, 'index']) ->name('admin.laporan.index');