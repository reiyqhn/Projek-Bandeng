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
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\KasirProfileController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\Kasir\TransaksiOfflineController;

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

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'processRegister'])->name('register.proses');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/beranda', [PesananController::class, 'index'])->name('pesanan.index');
Route::get('/pesanan/detail/{id}', [PesananController::class, 'show'])->name('pesanan.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [CustomerProfileController::class, 'edit'])->name('customer.profil');
    Route::put('/profil', [CustomerProfileController::class, 'update'])->name('customer.profil.update');

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
});

Route::middleware(['auth:kasir'])->group(function () {
    Route::get('/kasir/profil', [KasirProfileController::class, 'edit'])->name('kasir.profil');
    Route::put('/kasir/profil', [KasirProfileController::class, 'update'])->name('kasir.profil.update');
});

Route::get('/kasir/dashboard', [KasirController::class, 'index'])->name('kasir.dashboard');
Route::get('/kasir/transaksi-online/pembayaran', [PembayaranOnlineController::class, 'index'])->name('kasir.online.pembayaran');
Route::post('/kasir/transaksi-online/pembayaran/{no_faktur}/terima', [PembayaranOnlineController::class, 'terima'])->name('kasir.online.terima');
Route::post('/kasir/transaksi-online/pembayaran/{no_faktur}/tolak', [PembayaranOnlineController::class, 'tolak'])->name('kasir.online.tolak');
Route::post('/kasir/pesanan/tolak/{no_faktur}', [KasirController::class, 'tolakPesanan'])->name('kasir.pesanan.tolak');

Route::get('/kasir/online/bukti/{filename}', [PembayaranOnlineController::class, 'lihatBukti'])->name('kasir.online.bukti');

Route::get('/kasir/transaksi-online/faktur/{no_faktur?}', [KasirController::class, 'faktur'])->name('kasir.transaksi-online.faktur');
Route::post('/kasir/transaksi-online/faktur/{no_faktur}/kirim', [KasirController::class, 'kirimFaktur'])->name('kasir.online.kirimFaktur');

Route::prefix('kasir/transaksi-offline')->name('kasir.offline.')->group(function () {
    Route::get('/', [TransaksiOfflineController::class, 'index'])->name('index');
    Route::post('/tambah-item', [TransaksiOfflineController::class, 'tambahItem'])->name('tambahItem');
    Route::post('/update-qty', [TransaksiOfflineController::class, 'updateQty'])->name('updateQty');
    Route::post('/batal', [TransaksiOfflineController::class, 'batalTransaksi'])->name('batal');
    Route::post('/store', [TransaksiOfflineController::class, 'store'])->name('store');

    Route::get('/pembayaran', [TransaksiOfflineController::class, 'pembayaran'])->name('pembayaran');
    Route::post('/pembayaran/store', [TransaksiOfflineController::class, 'pembayaranStore'])->name('pembayaran.store');
    Route::get('/faktur/{no_faktur?}', [TransaksiOfflineController::class, 'faktur'])->name('faktur');
});

Route::get('/kasir/riwayat-pesanan', [KasirController::class, 'riwayatPesanan'])->name('kasir.riwayat');

Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');

Route::prefix('admin/customer')->name('admin.customer.')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('index');
});

Route::prefix('admin/pegawai')->name('admin.pegawai.')->group(function () {
    Route::get('/', [PegawaiController::class, 'index'])->name('index');
    Route::get('/create', [PegawaiController::class, 'create'])->name('create');
    Route::post('/', [PegawaiController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [PegawaiController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PegawaiController::class, 'update'])->name('update');
    Route::patch('/{id}/status', [PegawaiController::class, 'updateStatus'])->name('updateStatus');
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