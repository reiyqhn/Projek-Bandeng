<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

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

        return view('dashboard.kasir', compact(
            'totalPenjualan', 
            'transaksiOnline', 
            'transaksiOffline', 
            'totalTransaksi', 
            'transaksiTerbaru'
        ));
    }

    // TAMBAHKAN METHOD FAKTUR INI DI DALAM KELAS KASIRCONTROLLER
    public function faktur($no_faktur = null)
    {
        $fakturs = Transaction::with('customer')
                              ->where('status_pembayaran', 'Lunas') 
                              ->orderBy('no_faktur', 'desc')
                              ->get();

        $selectedFaktur = $no_faktur 
            ? Transaction::with('customer')->where('no_faktur', $no_faktur)->first() 
            : $fakturs->first();

        return view('dashboard.kasir.faktur_online', compact('fakturs', 'selectedFaktur'));
    }
}