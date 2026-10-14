<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesananController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/beranda', [PesananController::class, 'index'])->name('pesanan.index');
Route::get('/pesanan/detail/{id}', [PesananController::class, 'show'])->name('pesanan.show');


Route::post('/keranjang/tambah', [PesananController::class, 'tambahKeranjang'])->name('keranjang.tambah');
Route::get('/keranjang', [PesananController::class, 'keranjang'])->name('pesanan.keranjang');
Route::get('/keranjang/hapus/{id}', [PesananController::class, 'hapusKeranjang'])->name('keranjang.hapus');


Route::get('/checkout', [PesananController::class, 'checkout'])->name('pesanan.checkout');
Route::post('/checkout/proses', [PesananController::class, 'prosesCheckout'])->name('pesanan.prosesCheckout');


Route::get('/pesanan/pembayaran/{id}', [PesananController::class, 'pembayaran'])->name('pesanan.pembayaran');
Route::post('/pesanan/upload-bukti/{id}', [PesananController::class, 'uploadBukti'])->name('pesanan.uploadBukti');


Route::get('/pesanan/konfirmasi/{id}', [PesananController::class, 'konfirmasi'])->name('pesanan.konfirmasi');