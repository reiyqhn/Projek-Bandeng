<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class PembayaranOnlineController extends Controller
{
    public function index(Request $request){

        $pembayarans = Transaction::where(function($query) {
                        $query->where('status_pembayaran', 'LIKE', '%Menunggu%')
                              ->orWhere('status_pembayaran', 'LIKE', '%Belum%');
                    })
                    ->latest('tanggal_penjualan')
                    ->get();

        $selectedFaktur = $request->query('id', $pembayarans->first()->no_faktur ?? null);
        $selectedTransaction = Transaction::where('no_faktur', $selectedFaktur)->first();

        return view('dashboard.kasir.pembayaran-online', compact('pembayarans', 'selectedTransaction'));
    }

    public function terima($no_faktur){
        $trx = Transaction::where('no_faktur', $no_faktur)->firstOrFail();
        $trx->update([
            'status_pembayaran' => 'Lunas'
        ]);

        return redirect()->route('kasir.online.pembayaran')->with('success', 'Pembayaran diterima dan status menjadi Lunas.');
    }

    public function tolak($no_faktur){
        $trx = Transaction::where('no_faktur', $no_faktur)->firstOrFail();
        $trx->update([
            'status_pembayaran' => 'Batal'
        ]);

        return redirect()->route('kasir.online.pembayaran')->with('error', 'Pembayaran ditolak.');
    }

  
    public function lihatBukti($filename){
        $path = public_path('uploads/bukti/' . $filename);

        if (!file_exists($path)) {
            abort(404, 'File bukti pembayaran tidak ditemukan.');
        }

        return response()->file($path);
    }
}