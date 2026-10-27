<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesananController;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Halaman Tentang Kami
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
// Halaman Beranda dan Detail Produk
Route::get('/beranda', [PesananController::class, 'index'])
    ->name('pesanan.index');

Route::get('/pesanan/detail/{id}', [PesananController::class, 'show'])
    ->name('pesanan.show');

// Keranjang
Route::post('/keranjang/tambah', [PesananController::class, 'tambahKeranjang'])
    ->name('keranjang.tambah');

Route::get('/keranjang', [PesananController::class, 'keranjang'])
    ->name('pesanan.keranjang');

Route::get('/keranjang/hapus/{id}', [PesananController::class, 'hapusKeranjang'])
    ->name('keranjang.hapus');

// Checkout
Route::get('/checkout', [PesananController::class, 'checkout'])
    ->name('pesanan.checkout');

Route::post('/checkout/proses', [PesananController::class, 'prosesCheckout'])
    ->name('pesanan.prosesCheckout');

// Pembayaran
Route::get('/pesanan/pembayaran/{id}', [PesananController::class, 'pembayaran'])
    ->name('pesanan.pembayaran');

Route::post('/pesanan/upload-bukti/{id}', [PesananController::class, 'uploadBukti'])
    ->name('pesanan.uploadBukti');

// Konfirmasi
Route::get('/pesanan/konfirmasi/{id}', [PesananController::class, 'konfirmasi'])
    ->name('pesanan.konfirmasi');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/login', function () {
    return view('login');
})->name('login');