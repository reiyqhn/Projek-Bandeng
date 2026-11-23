<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\KasirController;
use App\Http\Controllers\Kasir\PembayaranOnlineController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PegawaiController;

// halaman public
Route::get('/', function () {
    return view('welcome');
});

Route::get('/tentang-kami', function () {
    return view('Tentang-kami');
});

Route::get('/bandeng', function () {
    return view('bandeng');
});

Route::get('/kontak', function () {
    return view('kontak');
});

Route::get('/cara-pesan', function () {
    return view('cara-pesan');
});

// login dan register
Route::middleware(['guest'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'processRegister'])->name('register.proses');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'processLogin'])->name('login.proses');
});

// pesnana kustomer
Route::get('/beranda', [PesananController::class, 'index'])->name('pesanan.index');
Route::get('/pesanan/detail/{id}', [PesananController::class, 'show'])->name('pesanan.show');

Route::middleware(['auth'])->group(function () {
    Route::post('/keranjang/tambah', [PesananController::class, 'tambahKeranjang'])->name('keranjang.tambah');
    Route::get('/keranjang', [PesananController::class, 'keranjang'])->name('pesanan.keranjang');
    Route::get('/keranjang/hapus/{id}', [PesananController::class, 'hapusKeranjang'])->name('pesanan.keranjang.hapus');

    Route::get('/checkout', [PesananController::class, 'checkout'])->name('pesanan.checkout');
    Route::post('/checkout/proses', [PesananController::class, 'prosesCheckout'])->name('pesanan.prosesCheckout');
    Route::get('/pesanan/pembayaran/{id}', [PesananController::class, 'pembayaran'])->name('pesanan.pembayaran');
    Route::post('/pesanan/upload-bukti/{id}', [PesananController::class, 'uploadBukti'])->name('pesanan.uploadBukti');
    Route::get('/pesanan/konfirmasi/{id}', [PesananController::class, 'konfirmasi'])->name('pesanan.konfirmasi');
    Route::post('/pesanan/expired/{no_faktur}', [PesananController::class, 'setExpired'])->name('pesanan.expired');

    Route::get('/pesanan/riwayat', [PesananController::class, 'riwayatPesanan'])->name('pesanan.riwayat');
    Route::get('/pesanan/notifikasi', [PesananController::class, 'notifikasi'])->name('pesanan.notifikasi');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// kasir
Route::get('/kasir/dashboard', [KasirController::class, 'index'])->name('kasir.dashboard');
Route::get('/kasir/transaksi-online/pembayaran', [PembayaranOnlineController::class, 'index'])->name('kasir.online.pembayaran');
Route::post('/kasir/transaksi-online/pembayaran/{no_faktur}/terima', [PembayaranOnlineController::class, 'terima'])->name('kasir.online.terima');
Route::post('/kasir/transaksi-online/pembayaran/{no_faktur}/tolak', [PembayaranOnlineController::class, 'tolak'])->name('kasir.online.tolak');

// pembayarn online
Route::get('/kasir/online/bukti/{filename}', [PembayaranOnlineController::class, 'lihatBukti'])->name('kasir.online.bukti');

// faktur online
Route::get('/kasir/transaksi-online/faktur/{no_faktur?}', [KasirController::class, 'faktur'])->name('kasir.transaksi-online.faktur');
Route::post('/kasir/transaksi-online/faktur/{no_faktur}/kirim', [KasirController::class, 'kirimFaktur'])->name('kasir.online.kirimFaktur');

// admin
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

// kelola bandeng
Route::get('/admin/bandeng', [ProdukController::class, 'index'])->name('admin.bandeng.index');
Route::get('/admin/bandeng/tambah', [ProdukController::class, 'create'])->name('admin.bandeng.create');
Route::post('/admin/bandeng/simpan', [ProdukController::class, 'store'])->name('admin.bandeng.store');
Route::get('/admin/bandeng/edit/{produk}', [ProdukController::class, 'edit'])->name('admin.bandeng.edit');
Route::put('/admin/bandeng/update/{produk}', [ProdukController::class, 'update'])->name('admin.bandeng.update');
Route::delete('/admin/bandeng/hapus/{produk}', [ProdukController::class, 'destroy'])->name('admin.bandeng.destroy');

// ==========================================
// LAPORAN PENJUALAN
// ==========================================
Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');

Route::prefix('admin/customer')->name('admin.customer.')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::get('/create', [CustomerController::class, 'create'])->name('create');
    Route::post('/', [CustomerController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [CustomerController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CustomerController::class, 'update'])->name('update');
    Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('destroy');
});

Route::prefix('admin/pegawai')->name('admin.pegawai.')->group(function () {
    Route::get('/', [PegawaiController::class, 'index'])->name('index');
    Route::get('/create', [PegawaiController::class, 'create'])->name('create');
    Route::post('/', [PegawaiController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [PegawaiController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PegawaiController::class, 'update'])->name('update');
    Route::delete('/{id}', [PegawaiController::class, 'destroy'])->name('destroy');
});

Route::prefix('admin/bandeng')->name('admin.bandeng.')->group(function () {
    Route::get('/', [ProdukController::class, 'index'])->name('index');
    Route::get('/create', [ProdukController::class, 'create'])->name('create');
    Route::post('/', [ProdukController::class, 'store'])->name('store');
    Route::get('/edit', [ProdukController::class, 'editDirect'])->name('edit.direct');
    Route::get('/{id}/edit', [ProdukController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ProdukController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProdukController::class, 'destroy'])->name('destroy');
});
// ==========================================
// DATA CUSTOMER (CRUD LENGKAP)
// ==========================================
Route::get('/admin/customer', [CustomerController::class, 'index'])
    ->name('admin.customer.index');

Route::get('/admin/customer/create', [CustomerController::class, 'create'])
    ->name('admin.customer.create');

Route::post('/admin/customer', [CustomerController::class, 'store'])
    ->name('admin.customer.store');

Route::get('/admin/customer/{id}/edit', [CustomerController::class, 'edit'])
    ->name('admin.customer.edit');

Route::put('/admin/customer/{id}', [CustomerController::class, 'update'])
    ->name('admin.customer.update');

Route::delete('/admin/customer/{id}', [CustomerController::class, 'destroy'])
    ->name('admin.customer.destroy');

// Pastikan rute ini ada di routes/web.php
Route::get('/admin/bandeng/edit-direct', [ProdukController::class, 'editDirect'])->name('admin.bandeng.edit.direct');