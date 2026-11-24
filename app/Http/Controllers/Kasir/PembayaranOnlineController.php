<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\Produk;
use App\Models\Dikirim;

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
            $trx = Transaction::with('customer')
                ->where('no_faktur', $no_faktur)
                ->lockForUpdate()
                ->firstOrFail();

            if ($trx->status_pembayaran !== 'Lunas') {
                $trx->update([
                    'status_pembayaran' => 'Lunas',
                ]);
            }

            // Jika pesanan Delivery, otomatis masukkan ke tabel 'dikirim' agar tampil di halaman kurir
            if ($trx->metode_pemesanan === 'Delivery') {
                $sudahAda = Dikirim::where('no_faktur', $trx->no_faktur)->exists();

                if (!$sudahAda) {
                    $idKaryawan = session('id_karyawan')
                        ?? DB::table('karyawan')->value('id_karyawan')
                        ?? Dikirim::whereNotNull('id_karyawan')->value('id_karyawan')
                        ?? 'KR002';

                    $alamatTujuan = $trx->customer->alamat ?? '-';

                    $noPengiriman = 'KRM' . date('ymdHis') . rand(10, 99);
                    while (Dikirim::where('no_pengiriman', $noPengiriman)->exists()) {
                        $noPengiriman = 'KRM' . date('ymdHis') . rand(100, 999);
                    }

                    Dikirim::create([
                        'no_pengiriman'     => $noPengiriman,
                        'no_faktur'         => $trx->no_faktur,
                        'id_karyawan'       => $idKaryawan,
                        'alamat_pengiriman' => $alamatTujuan,
                        'status_pengiriman' => 'Diproses',
                    ]);
                }
            }
        });

        return redirect()->route('kasir.online.pembayaran')
            ->with('success', 'Pembayaran diterima, status menjadi Lunas, dan pesanan masuk ke pengiriman.');
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