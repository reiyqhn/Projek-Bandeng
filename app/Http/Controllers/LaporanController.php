<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $query = DB::table('transaksi_penjualan')
            ->join('customer', 'transaksi_penjualan.id_customer', '=', 'customer.id_customer')
            ->join('detail_penjualan', 'transaksi_penjualan.no_faktur', '=', 'detail_penjualan.no_faktur')
            ->join('bandeng', 'detail_penjualan.id_bandeng', '=', 'bandeng.id_bandeng')
            ->select(
                'transaksi_penjualan.tanggal_penjualan',
                'transaksi_penjualan.no_faktur',
                'customer.nama as nama_customer',
                'bandeng.nama_bandeng',
                'detail_penjualan.jumlah as qty',
                'detail_penjualan.harga_item',
                DB::Raw('(detail_penjualan.jumlah * detail_penjualan.harga_item) as total_harga'),
                'transaksi_penjualan.status_pembayaran'
            );

        if ($tanggalAwal && $tanggalAkhir) {
            $query->whereBetween('transaksi_penjualan.tanggal_penjualan', [
                $tanggalAwal . ' 00:00:00', 
                $tanggalAkhir . ' 23:59:59'
            ]);
        }

        $laporan = $query->get();

        $totalPenjualan = $laporan->sum('total_harga');
        $totalTransaksi = $laporan->unique('no_faktur')->count();
        $bandengTerjual = $laporan->sum('qty');
        $totalCustomer  = $laporan->unique('nama_customer')->count();

        return view('admin.laporan.index', compact(
            'laporan', 
            'totalPenjualan', 
            'totalTransaksi', 
            'bandengTerjual', 
            'totalCustomer', 
            'tanggalAwal', 
            'tanggalAkhir'
        ));
    }
}