<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $statusFilter = $request->input('status');

        $hasDikirimTable = Schema::hasTable('dikirim') && Schema::hasColumn('dikirim', 'status_pengiriman');

        $query = DB::table('transaksi_penjualan')
            ->leftJoin('customer', 'transaksi_penjualan.id_customer', '=', 'customer.id_customer')
            ->join('detail_penjualan', 'transaksi_penjualan.no_faktur', '=', 'detail_penjualan.no_faktur')
            ->join('bandeng', 'detail_penjualan.id_bandeng', '=', 'bandeng.id_bandeng');

        if ($hasDikirimTable) {
            $query->leftJoin('dikirim', 'transaksi_penjualan.no_faktur', '=', 'dikirim.no_faktur');
        }

        $selects = [
            'transaksi_penjualan.tanggal_penjualan',
            'transaksi_penjualan.no_faktur',
            DB::raw("COALESCE(customer.nama, '-') as nama_customer"),
            'bandeng.nama_bandeng',
            'detail_penjualan.jumlah as qty',
            'detail_penjualan.harga_item',
            DB::raw('(detail_penjualan.jumlah * detail_penjualan.harga_item) as total_harga'),
            'transaksi_penjualan.status_pembayaran',
            'transaksi_penjualan.metode_pemesanan',
        ];

        if ($hasDikirimTable) {
            $selects[] = DB::raw("COALESCE(dikirim.status_pengiriman, '-') as status_pengiriman");
        } else {
            $selects[] = DB::raw("'-' as status_pengiriman");
        }

        $query->select($selects)
            ->orderByDesc('transaksi_penjualan.tanggal_penjualan');

        if ($tanggalAwal && $tanggalAkhir) {
            $query->whereBetween('transaksi_penjualan.tanggal_penjualan', [
                $tanggalAwal . ' 00:00:00',
                $tanggalAkhir . ' 23:59:59'
            ]);
        }

        if ($statusFilter && in_array($statusFilter, ['Lunas', 'Belum Lunas', 'Batal'])) {
            $query->where('transaksi_penjualan.status_pembayaran', $statusFilter);
        }

        $laporan = $query->get();

        $laporanLunas = $laporan->where('status_pembayaran', 'Lunas');

        $totalPenjualan = $laporanLunas->sum('total_harga');
        $totalTransaksi = $laporanLunas->unique('no_faktur')->count();
        $bandengTerjual = $laporanLunas->sum('qty');
        $totalCustomer  = $laporanLunas->unique('nama_customer')->count();

        return view('admin.laporan.index', compact(
            'laporan',
            'totalPenjualan',
            'totalTransaksi',
            'bandengTerjual',
            'totalCustomer',
            'tanggalAwal',
            'tanggalAkhir',
            'statusFilter'
        ));
    }
}