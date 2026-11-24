<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function index()
    {
        $hariIni = now()->toDateString();

        $totalPenjualan = Transaction::whereDate('tanggal_penjualan', $hariIni)
            ->where('status_pembayaran', 'Lunas')
            ->sum('subtotal');

        $transaksiOnline = Transaction::whereDate('tanggal_penjualan', $hariIni)
            ->where('status_pembayaran', '!=', 'Batal')
            ->where('no_faktur', 'not like', 'TRX-OFF-%')
            ->where('metode_pemesanan', 'Delivery')
            ->count();

        $transaksiOffline = Transaction::whereDate('tanggal_penjualan', $hariIni)
            ->where('status_pembayaran', '!=', 'Batal')
            ->where(function ($q) {
                $q->where('no_faktur', 'like', 'TRX-OFF-%')
                  ->orWhere('metode_pemesanan', '!=', 'Delivery');
            })
            ->count();

        $totalTransaksi = $transaksiOnline + $transaksiOffline;

        $transaksiTerbaru = Transaction::with('customer')
            ->orderBy('tanggal_penjualan', 'desc')
            ->take(5)
            ->get();

        $namaKasir = Auth::user()->nama ?? session('nama_kasir', 'Kasir');

        return view('dashboard.kasir', compact(
            'totalPenjualan',
            'transaksiOnline',
            'transaksiOffline',
            'totalTransaksi',
            'transaksiTerbaru',
            'namaKasir'
        ));
    }

    public function faktur($no_faktur = null)
    {
        $fakturs = Transaction::with('customer')
            ->where('status_pembayaran', 'Lunas')
            ->orderBy('no_faktur', 'desc')
            ->get();

        $selectedFaktur = $no_faktur
            ? Transaction::with('customer')->where('no_faktur', $no_faktur)->first()
            : $fakturs->first();

        $namaKasir = Auth::user()->nama ?? session('nama_kasir', 'Kasir');

        return view('dashboard.kasir.faktur_online', compact('fakturs', 'selectedFaktur', 'namaKasir'));
    }

    public function kirimFaktur($no_faktur)
    {
        $trx = Transaction::where('no_faktur', $no_faktur)->firstOrFail();

        $trx->update([
            'tgl_cetak_faktur' => now()
        ]);

        return redirect()->route('kasir.transaksi-online.faktur', $no_faktur)->with('success', 'Faktur berhasil dikirim dan dapat diakses oleh customer!');
    }

    public function tolakPesanan($no_faktur)
    {
        $pesanan = Transaction::where('no_faktur', $no_faktur)->first();

        if (!$pesanan) {
            return back()->with('error', 'Data transaksi tidak ditemukan.');
        }

        if ($pesanan->status_pembayaran != 'Batal' && $pesanan->status_pembayaran != 'Lunas') {
            DB::transaction(function () use ($pesanan) {
                $details = DB::table('detail_penjualan')->where('no_faktur', $pesanan->no_faktur)->get();

                foreach ($details as $detail) {
                    $produk = Produk::where('id_bandeng', $detail->id_bandeng)->lockForUpdate()->first();
                    if ($produk) {
                        $produk->stok += $detail->jumlah;
                        $produk->save();
                    }
                }

                $pesanan->update([
                    'status_pembayaran' => 'Batal'
                ]);
            });

            return back()->with('success', 'Pesanan berhasil ditolak dan stok produk telah dikembalikan.');
        }

        return back()->with('error', 'Pesanan tidak dapat ditolak.');
    }

    public function riwayatPesanan(Request $request)
    {
        $jenisTransaksi = $request->get('jenis', 'semua');
        $metodePembayaran = $request->get('metode', 'semua');
        $selectedNoFaktur = $request->get('lihat');

        $query = Transaction::with('customer')
            ->where('status_pembayaran', 'Lunas');

        if ($jenisTransaksi === 'online') {
            $query->where('no_faktur', 'not like', 'TRX-OFF-%')
                  ->where('metode_pemesanan', 'Delivery');
        } elseif ($jenisTransaksi === 'offline') {
            $query->where(function ($q) {
                $q->where('no_faktur', 'like', 'TRX-OFF-%')
                  ->orWhere('metode_pemesanan', '!=', 'Delivery');
            });
        }

        if ($metodePembayaran !== 'semua' && !empty($metodePembayaran)) {
            $query->where('metode_pembayaran', $metodePembayaran);
        }

        $transaksis = $query->orderBy('tanggal_penjualan', 'desc')->get();

        $detailTransaksi = null;
        if ($selectedNoFaktur) {
            $detailTransaksi = Transaction::with('customer')
                ->where('no_faktur', $selectedNoFaktur)
                ->first();
        }

        $namaKasir = Auth::user()->nama ?? session('nama_kasir', 'Kasir');

        return view('dashboard.kasir.riwayat_pesanan', compact(
            'transaksis',
            'jenisTransaksi',
            'metodePembayaran',
            'detailTransaksi',
            'namaKasir'
        ));
    }
}