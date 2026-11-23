<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    private function detectColumn(string $table, array $candidates): ?string
    {
        foreach ($candidates as $column) {
            if (Schema::hasColumn($table, $column)) {
                return $column;
            }
        }

        return null;
    }

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
            $totalPesanan = DB::table('transaksi_penjualan')->count();

            $colTanggal = $this->detectColumn('transaksi_penjualan', [
                'tanggal_penjualan', 'tanggal', 'tgl_transaksi', 'created_at'
            ]);

            $colTotal = $this->detectColumn('transaksi_penjualan', [
                'total_harga', 'total_bayar', 'total', 'grand_total', 'subtotal'
            ]);

            $colFaktur = $this->detectColumn('transaksi_penjualan', [
                'no_faktur', 'no_invoice', 'invoice', 'kode_transaksi', 'id_transaksi'
            ]);

            $colStatus = $this->detectColumn('transaksi_penjualan', [
                'status_pembayaran', 'status'
            ]);

            $colCustomerNama = Schema::hasTable('customer')
                ? $this->detectColumn('customer', ['nama', 'nama_customer', 'nama_lengkap'])
                : null;

            if ($colTotal) {
                $queryBulanIni = DB::table('transaksi_penjualan');

                if ($colTanggal) {
                    $queryBulanIni->whereYear($colTanggal, now()->year)
                                   ->whereMonth($colTanggal, now()->month);
                }

                if ($colStatus) {
                    $queryBulanIni->where($colStatus, '!=', 'Batal');
                }

                $pendapatanBulanIni = $queryBulanIni->sum($colTotal);
            }

            $queryTerbaru = DB::table('transaksi_penjualan as tp');

            if (Schema::hasTable('customer') && Schema::hasColumn('transaksi_penjualan', 'id_customer') && $colCustomerNama) {
                $queryTerbaru->leftJoin('customer as c', 'tp.id_customer', '=', 'c.id_customer');
            }

            $selects = [];
            $selects[] = $colTanggal
                ? DB::raw("tp.`{$colTanggal}` as tanggal_penjualan")
                : DB::raw('NULL as tanggal_penjualan');

            $selects[] = $colFaktur
                ? DB::raw("tp.`{$colFaktur}` as no_faktur")
                : DB::raw('"-" as no_faktur');

            if (Schema::hasTable('customer') && Schema::hasColumn('transaksi_penjualan', 'id_customer') && $colCustomerNama) {
                $selects[] = DB::raw("COALESCE(c.`{$colCustomerNama}`, '-') as nama_customer");
            } else {
                $selects[] = DB::raw('"-" as nama_customer');
            }

            $selects[] = $colTotal
                ? DB::raw("tp.`{$colTotal}` as total_harga")
                : DB::raw('0 as total_harga');

            $selects[] = $colStatus
                ? DB::raw("COALESCE(tp.`{$colStatus}`, '-') as status_pembayaran")
                : DB::raw('"-" as status_pembayaran');

            $queryTerbaru->select($selects);

            if ($colTanggal) {
                $queryTerbaru->orderByDesc("tp.{$colTanggal}");
            }

            $transaksiTerbaru = $queryTerbaru->limit(5)->get();
        }

        return view('admin.dashboard', compact(
            'totalProduk',
            'totalPesanan',
            'pendapatanBulanIni',
            'totalCustomer',
            'transaksiTerbaru'
        ));
    }
}