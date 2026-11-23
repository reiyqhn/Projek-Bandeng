<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth; 

class KasirController extends Controller{
    public function index(){
        $totalPenjualan = Transaction::where('status_pembayaran', 'Lunas')->sum('subtotal');
        $transaksiOnline = Transaction::where('metode_pemesanan', 'Delivery')->count();
        $transaksiOffline = Transaction::where('metode_pemesanan', '!=', 'Delivery')->count();
        $totalTransaksi = Transaction::count();

        $transaksiTerbaru = Transaction::with('customer')
                                    ->orderBy('tanggal_penjualan', 'desc')
                                    ->take(5)
                                    ->get();

        $namaKasir = Auth::guard('kasir')->user()->nama ?? 'Kasir';

        return view('dashboard.kasir', compact(
            'totalPenjualan', 
            'transaksiOnline', 
            'transaksiOffline', 
            'totalTransaksi', 
            'transaksiTerbaru',
            'namaKasir' 
        ));
    }

    public function faktur($no_faktur = null){
        $fakturs = Transaction::with('customer')
                            ->where('status_pembayaran', 'Lunas') 
                            ->orderBy('no_faktur', 'desc')
                            ->get();

        $selectedFaktur = $no_faktur 
            ? Transaction::with('customer')->where('no_faktur', $no_faktur)->first() 
            : $fakturs->first();

        $namaKasir = Auth::guard('kasir')->user()->nama ?? 'Kasir';

        return view('dashboard.kasir.faktur_online', compact('fakturs', 'selectedFaktur', 'namaKasir'));
    }

    public function kirimFaktur($no_faktur){
        $trx = Transaction::where('no_faktur', $no_faktur)->firstOrFail();
        
        $trx->update([
            'tgl_cetak_faktur' => now()
        ]);

        return redirect()->route('kasir.transaksi-online.faktur', $no_faktur)->with('success', 'Faktur berhasil dikirim dan dapat diakses oleh customer!');
    }

    public function tolakPesanan($no_faktur){
        $pesanan = Transaction::where('no_faktur', $no_faktur)->first();

        if (!$pesanan) {
            return back()->with('error', 'Data transaksi tidak ditemukan.');
        }

        if ($pesanan->status_pembayaran != 'Batal' && $pesanan->status_pembayaran != 'Lunas') {
            DB::transaction(function () use ($pesanan) {
                $details = DB::table('detail_penjualan')->where('no_faktur', $pesanan->no_faktur)->get();

                foreach ($details as $detail) {
                    $produk = Produk::where('id_bandeng', $detail->id_bandeng)->first();
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
}