<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\KasirController;
use App\Http\Controllers\Kasir\PembayaranOnlineController;

// ================= Halaman Publik / Landing Page (Dari Katalog Temanmu) =================
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

// ================= Auth (Login & Register) =================
Route::middleware(['guest'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'processRegister'])->name('register.proses');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'processLogin'])->name('login.proses');
});

// ================= Route Customer / Pesanan (Umum & Terautentikasi) =================
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

// ================= Route Dashboard Kasir & Verifikasi Pembayaran Online =================
Route::get('/kasir/dashboard', [KasirController::class, 'index'])->name('kasir.dashboard');
Route::get('/kasir/transaksi-online/pembayaran', [PembayaranOnlineController::class, 'index'])->name('kasir.online.pembayaran');
Route::post('/kasir/transaksi-online/pembayaran/{no_faktur}/terima', [PembayaranOnlineController::class, 'terima'])->name('kasir.online.terima');
Route::post('/kasir/transaksi-online/pembayaran/{no_faktur}/tolak', [PembayaranOnlineController::class, 'tolak'])->name('kasir.online.tolak');

// TAMBAHAN ROUTE UNTUK MELIHAT BUKTI PEMBAYARAN ONLINE (MENGATASI ERROR 403)
Route::get('/kasir/online/bukti/{filename}', [PembayaranOnlineController::class, 'lihatBukti'])->name('kasir.online.bukti');

// Rute Faktur Online (Parameter {no_faktur?} dibuat opsional agar aman saat diklik dari menu)
Route::get('/kasir/transaksi-online/faktur/{no_faktur?}', [KasirController::class, 'faktur'])->name('kasir.transaksi-online.faktur');
Route::post('/kasir/transaksi-online/faktur/{no_faktur}/kirim', [KasirController::class, 'kirimFaktur'])->name('kasir.online.kirimFaktur');