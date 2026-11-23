<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\Produk;

class PembayaranOnlineController extends Controller
{
    public function index(Request $request)
    {
        $pembayarans = Transaction::where(function ($query) {
                $query->where('status_pembayaran', 'LIKE', '%Menunggu%')
                      ->orWhere('status_pembayaran', 'LIKE', '%Belum%');
            })
            ->latest('tanggal_penjualan')
            ->get();

        $selectedFaktur = $request->query('id', $pembayarans->first()->no_faktur ?? null);
        $selectedTransaction = Transaction::where('no_faktur', $selectedFaktur)->first();

        return view('dashboard.kasir.pembayaran-online', compact('pembayarans', 'selectedTransaction'));
    }

    public function terima($no_faktur)
    {
        DB::transaction(function () use ($no_faktur) {
            $trx = Transaction::where('no_faktur', $no_faktur)->lockForUpdate()->firstOrFail();

            if ($trx->status_pembayaran !== 'Lunas') {
                $trx->update([
                    'status_pembayaran' => 'Lunas',
                ]);
            }
        });

        return redirect()->route('kasir.online.pembayaran')
            ->with('success', 'Pembayaran diterima dan status menjadi Lunas.');
    }

    public function tolak($no_faktur)
    {
        $sudahBatal = false;

        DB::transaction(function () use ($no_faktur, &$sudahBatal) {
            $trx = Transaction::where('no_faktur', $no_faktur)->lockForUpdate()->firstOrFail();

            if ($trx->status_pembayaran === 'Batal') {
                $sudahBatal = true;
                return;
            }

            // 1. Ubah status pembayaran menjadi Batal
            $trx->update([
                'status_pembayaran' => 'Batal',
            ]);

            // 2. Ambil detail produk yang dipesan berdasarkan no_faktur
            $details = DB::table('detail_penjualan')->where('no_faktur', $no_faktur)->get();

            // 3. Kembalikan stok produk ke database secara aman
            foreach ($details as $detail) {
                $produk = Produk::where('id_bandeng', $detail->id_bandeng)
                    ->lockForUpdate()
                    ->first();

                if ($produk) {
                    $produk->stok += (int) $detail->jumlah;
                    $produk->save();
                }
            }
        });

        if ($sudahBatal) {
            return redirect()->route('kasir.online.pembayaran')
                ->with('error', 'Transaksi ini sudah dibatalkan sebelumnya.');
        }

        return redirect()->route('kasir.online.pembayaran')
            ->with('error', 'Pembayaran ditolak dan stok bandeng telah dikembalikan.');
    }

    public function lihatBukti($filename)
    {
        $path = public_path('uploads/bukti/' . $filename);

        if (!file_exists($path)) {
            abort(404, 'File bukti pembayaran tidak ditemukan.');
        }

        return response()->file($path);
    }
}