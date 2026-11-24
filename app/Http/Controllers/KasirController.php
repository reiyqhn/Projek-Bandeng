<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Produk;
use App\Models\Dikirim;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function konfirmasiPesanan(Request $request, $no_faktur)
    {
        $trx = Transaction::with('customer')->where('no_faktur', $no_faktur)->first();

        if (!$trx) {
            return back()->with('error', 'Data transaksi tidak ditemukan.');
        }

        if ($trx->status_pembayaran === 'Batal') {
            return back()->with('error', 'Pesanan yang sudah dibatalkan tidak dapat dikonfirmasi.');
        }

        DB::transaction(function () use ($request, $trx) {
            $kasirId = Auth::guard('kasir')->user()->id_kasir ?? $trx->id_kasir;

            $trx->update([
                'status_pembayaran' => 'Lunas',
                'id_kasir'          => $kasirId,
            ]);

            if ($trx->metode_pemesanan === 'Delivery') {
                $sudahAda = Dikirim::where('no_faktur', $trx->no_faktur)->exists();

                if (!$sudahAda) {
                    $idKaryawan = session('id_karyawan')
                        ?? DB::table('karyawan')->value('id_karyawan')
                        ?? Dikirim::whereNotNull('id_karyawan')->value('id_karyawan')
                        ?? 'KR002';

                    $alamatTujuan = $request->input('alamat_pengiriman')
                        ?? ($trx->customer->alamat ?? null)
                        ?? '-';

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

        return back()->with('success', 'Pesanan ' . $no_faktur . ' berhasil dikonfirmasi dan diteruskan ke pengiriman.');
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
        // Filter dropdown: semua | online | offline
        $jenisTransaksi = $request->get('jenis', 'semua');

        // Filter dropdown: semua | Tunai | QRIS | Transfer
        $metodePembayaran = $request->get('metode', 'semua');

        // No faktur yang diklik tombol "Lihat"
        $selectedNoFaktur = $request->get('lihat');

        // Hanya transaksi yang sudah Lunas
        $query = Transaction::with('customer')
            ->where('status_pembayaran', 'Lunas');

        if ($jenisTransaksi === 'online') {
            $query->where('metode_pemesanan', 'Delivery');
        } elseif ($jenisTransaksi === 'offline') {
            $query->where('metode_pemesanan', '!=', 'Delivery');
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

        $namaKasir = Auth::guard('kasir')->user()->nama ?? 'Kasir';

        return view('dashboard.kasir.riwayat_pesanan', compact(
            'transaksis',
            'jenisTransaksi',
            'metodePembayaran',
            'detailTransaksi',
            'namaKasir'
        ));
    }
}