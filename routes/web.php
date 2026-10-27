<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\AuthController; 

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'processRegister'])->name('register.proses');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'processLogin'])->name('login.proses');
});

Route::get('/beranda', [PesananController::class, 'index'])->name('pesanan.index');
Route::get('/pesanan/detail/{id}', [PesananController::class, 'show'])->name('pesanan.show');

Route::middleware(['auth'])->group(function () {
    
    Route::post('/keranjang/tambah', [PesananController::class, 'tambahKeranjang'])->name('keranjang.tambah');
    Route::get('/keranjang', [PesananController::class, 'keranjang'])->name('pesanan.keranjang');
    Route::get('/keranjang/hapus/{id}', [PesananController::class, 'hapusKeranjang'])->name('keranjang.hapus');

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