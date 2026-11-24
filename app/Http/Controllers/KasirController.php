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
        $hariIni = now()->toDateString();

        $totalPenjualan = Transaction::whereDate('tanggal_penjualan',$hariIni)
            ->where('status_pembayaran', 'Lunas')
            ->sum('subtotal');

        $transaksiOnline = Transaction::whereDate('tanggal_penjualan',$hariIni)
            ->where('status_pembayaran', '!=', 'Batal')
            ->where('no_faktur', 'not like', 'TRX-OFF-%')
            ->where('metode_pemesanan', 'Delivery')
            ->count();

        $transaksiOffline = Transaction::whereDate('tanggal_penjualan',$hariIni)
            ->where('status_pembayaran', '!=', 'Batal')
            ->where(function ($q) {$q->where('no_faktur', 'like', 'TRX-OFF-%')
                  ->orWhere('metode_pemesanan', '!=', 'Delivery');
            })
            ->count();

        $totalTransaksi = $transaksiOnline +$transaksiOffline;

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
            ->where('no_faktur', 'not like', 'TRX-OFF-%')
            ->whereNull('tgl_cetak_faktur')
            ->orderBy('tanggal_penjualan', 'desc')
            ->get();

        $selectedFaktur =$no_faktur
            ? Transaction::with('customer')->where('no_faktur', $no_faktur)->first()
            : $fakturs->first();

        $selectedDetails = collect();
        if ($selectedFaktur) {$selectedDetails = DB::table('detail_penjualan')
                ->join('bandeng', 'detail_penjualan.id_bandeng', '=', 'bandeng.id_bandeng')
                ->where('detail_penjualan.no_faktur', $selectedFaktur->no_faktur)
                ->select('bandeng.nama_bandeng', 'detail_penjualan.jumlah', 'detail_penjualan.harga_item')
                ->get();
        }

        $namaKasir = Auth::user()->nama ?? session('nama_kasir', 'Kasir');

        return view('dashboard.kasir.faktur_online', compact('fakturs', 'selectedFaktur', 'selectedDetails', 'namaKasir'));
    }

    public function kirimFaktur($no_faktur)
    {
        $trx = Transaction::where('no_faktur',$no_faktur)->firstOrFail();

        $trx->update([
            'tgl_cetak_faktur' => now()
        ]);

        return redirect()->route('kasir.transaksi-online.faktur')
            ->with('success', 'Faktur #' . $no_faktur . ' berhasil dikirim ke customer!');
    }

    public function konfirmasiPesanan(Request $request,$no_faktur)
    {
        $trx = Transaction::with('customer')->where('no_faktur',$no_faktur)->first();

        if (!$trx) {
            return back()->with('error', 'Data transaksi tidak ditemukan.');
        }

        if ($trx->status_pembayaran === 'Batal') {
            return back()->with('error', 'Pesanan yang sudah dibatalkan tidak dapat dikonfirmasi.');
        }

        DB::transaction(function () use ($request,$trx) {
            $kasirId = Auth::guard('kasir')->user()->id_kasir ?? $trx->id_kasir;

            $trx->update([
                'status_pembayaran' => 'Lunas',
                'id_kasir'          => $kasirId,
            ]);

            if ($trx->metode_pemesanan === 'Delivery') {
                $sudahAda = Dikirim::where('no_faktur',$trx->no_faktur)->exists();

                if (!$sudahAda) {$idKaryawan = session('id_karyawan')
                        ?? DB::table('karyawan')->value('id_karyawan')
                        ?? Dikirim::whereNotNull('id_karyawan')->value('id_karyawan')
                        ?? 'KR002';

                    $alamatTujuan =$request->input('alamat_pengiriman')
                        ?? ($trx->customer->alamat ?? null)
                        ?? '-';

                    $noPengiriman = 'KRM' . date('ymdHis') . rand(10, 99);
                    while (Dikirim::where('no_pengiriman', $noPengiriman)->exists()) {$noPengiriman = 'KRM' . date('ymdHis') . rand(100, 999);
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
        $pesanan = Transaction::where('no_faktur',$no_faktur)->first();

        if (!$pesanan) {
            return back()->with('error', 'Data transaksi tidak ditemukan.');
        }

        if ($pesanan->status_pembayaran != 'Batal' &&$pesanan->status_pembayaran != 'Lunas') {
            DB::transaction(function () use ($pesanan) {
                $details = DB::table('detail_penjualan')->where('no_faktur',$pesanan->no_faktur)->get();

                foreach ($details as$detail) {
                    $produk = Produk::where('id_bandeng',$detail->id_bandeng)->lockForUpdate()->first();
                    if ($produk) {
                        $produk->stok +=$detail->jumlah;
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
        $jenisTransaksi =$request->get('jenis', 'semua');
        $metodePembayaran =$request->get('metode', 'semua');
        $selectedNoFaktur =$request->get('lihat');

        $query = Transaction::with('customer')
            ->where('status_pembayaran', 'Lunas');

        if ($jenisTransaksi === 'online') {$query->where('no_faktur', 'not like', 'TRX-OFF-%')
                  ->where('metode_pemesanan', 'Delivery');
        } elseif ($jenisTransaksi === 'offline') {$query->where(function ($q) {$q->where('no_faktur', 'like', 'TRX-OFF-%')
                  ->orWhere('metode_pemesanan', '!=', 'Delivery');
            });
        }

        if ($metodePembayaran !== 'semua' && !empty($metodePembayaran)) {
            $query->where('metode_pembayaran',$metodePembayaran);
        }

        $transaksis =$query->orderBy('tanggal_penjualan', 'desc')->get();

        $detailTransaksi = null;
        if ($selectedNoFaktur) {$detailTransaksi = Transaction::with('customer')
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