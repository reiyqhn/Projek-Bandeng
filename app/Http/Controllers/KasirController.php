<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth; // <-- Pastikan facade Auth sudah di-import

class KasirController extends Controller
{
    public function index()
    {
        $totalPenjualan = Transaction::where('status_pembayaran', 'Lunas')->sum('subtotal');
        $transaksiOnline = Transaction::where('metode_pemesanan', 'Delivery')->count();
        $transaksiOffline = Transaction::where('metode_pemesanan', '!=', 'Delivery')->count();
        $totalTransaksi = Transaction::count();

        $transaksiTerbaru = Transaction::with('customer')
                                    ->orderBy('tanggal_penjualan', 'desc')
                                    ->take(5)
                                    ->get();

        // Ambil nama kasir yang sedang login
        $namaKasir = Auth::guard('kasir')->user()->nama ?? 'Kasir';

        return view('dashboard.kasir', compact(
            'totalPenjualan', 
            'transaksiOnline', 
            'transaksiOffline', 
            'totalTransaksi', 
            'transaksiTerbaru',
            'namaKasir' // <-- DIKIRIM KE VIEW
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

        $namaKasir = Auth::guard('kasir')->user()->nama ?? 'Kasir';

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
}