<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\KasirController;
use App\Http\Controllers\Kasir\PembayaranOnlineController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KaryawanController;

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

// laporan
Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');



// Rute Karyawan / Kurir
Route::get('/karyawan/beranda', function () {
    return view('karyawan.beranda'); // Sesuaikan jika nama file view berandanya berbeda
})->name('karyawan.beranda');

Route::get('/karyawan/data', function () {
    return view('karyawan.data');
})->name('karyawan.data');

Route::get('/karyawan/riwayat', function () {
    return view('karyawan.riwayat');
})->name('karyawan.riwayat');

Route::prefix('karyawan')->group(function () {
    Route::get('/konfirmasi', [KaryawanController::class, 'konfirmasi'])->name('karyawan.konfirmasi');

    // Rute POST untuk ubah status semua paket ke Selesai
    Route::post('/konfirmasi/semua-selesai', [KaryawanController::class, 'semuaSelesai'])->name('karyawan.semuaSelesai');

    // Rute POST untuk ubah status 1 paket ke Selesai
    Route::post('/konfirmasi/{id}/selesai', [KaryawanController::class, 'prosesSelesai'])->name('karyawan.prosesSelesai');
});





// Rute Karyawan / Kurir
Route::prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/beranda', [KaryawanController::class, 'beranda'])->name('beranda');
    Route::get('/konfirmasi', [KaryawanController::class, 'konfirmasi'])->name('konfirmasi');
    Route::post('/konfirmasi/semua-selesai', [KaryawanController::class, 'semuaSelesai'])->name('semuaSelesai');
    Route::post('/konfirmasi/{id}/selesai', [KaryawanController::class, 'prosesSelesai'])->name('prosesSelesai');

    Route::get('/data', [KaryawanController::class, 'dataPengiriman'])->name('data');
    Route::post('/data/tambah', [KaryawanController::class, 'storePengiriman'])->name('data.store');
    Route::get('/data/export', [KaryawanController::class, 'exportExcel'])->name('data.export');

    Route::get('/riwayat', [KaryawanController::class, 'riwayat'])->name('riwayat');
});

// Logout
Route::match(['get', 'post'], '/logout', [KaryawanController::class, 'logout'])->name('logout');