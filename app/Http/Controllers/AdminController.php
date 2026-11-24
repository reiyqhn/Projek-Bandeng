<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    public function index()
    {
        $totalProduk = Schema::hasTable('bandeng')
            ? DB::table('bandeng')->count()
            : 0;

        $totalCustomer = Schema::hasTable('customer')
            ? DB::table('customer')->count()
            : 0;

        $totalPesanan = 0;
        $pendapatanBulanIni = 0;
        $transaksiTerbaru = collect();

        if (Schema::hasTable('transaksi_penjualan')) {
            $totalPesanan = DB::table('transaksi_penjualan')
                ->where('status_pembayaran', '!=', 'Batal')
                ->count();

            $pendapatanBulanIni = DB::table('transaksi_penjualan')
                ->where('status_pembayaran', 'Lunas')
                ->whereYear('tanggal_penjualan', now()->year)
                ->whereMonth('tanggal_penjualan', now()->month)
                ->sum('subtotal');

            $transaksiTerbaru = DB::table('transaksi_penjualan as tp')
                ->leftJoin('customer as c', 'tp.id_customer', '=', 'c.id_customer')
                ->select(
                    'tp.no_faktur',
                    'tp.tanggal_penjualan',
                    'tp.metode_pembayaran',
                    'tp.metode_pemesanan',
                    'tp.subtotal as total_harga',
                    'tp.status_pembayaran',
                    DB::raw("COALESCE(c.nama, '-') as nama_customer")
                )
                ->orderByDesc('tp.tanggal_penjualan')
                ->limit(5)
                ->get();
        }

        $namaAdmin = Auth::user()->nama ?? 'Admin';

        return view('admin.dashboard', compact(
            'totalProduk',
            'totalPesanan',
            'pendapatanBulanIni',
            'totalCustomer',
            'transaksiTerbaru',
            'namaAdmin'
        ));
    }
}