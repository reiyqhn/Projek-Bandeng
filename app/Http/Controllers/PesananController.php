<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class PesananController extends Controller
{
    // 1. Menampilkan katalog produk bandeng presto
    public function index(Request $request)
    {
        $cari = $request->input('cari');
        $query = Produk::query();

        if ($cari) {
            $kataKuncis = explode(' ', $cari);

            $query->where(function($q) use ($kataKuncis) {
                foreach ($kataKuncis as $kata) {
                    if (!empty($kata)) {
                        $q->orWhere('nama_bandeng', 'LIKE', '%' . $kata . '%')
                          ->orWhere('deskripsi', 'LIKE', '%' . $kata . '%');
                    }
                }
            });
        }

        $produks = $query->get();

        return view('pesanan.katalog', compact('produks'));
    }

    // 2. Menampilkan detail produk yang dipilih customer
    public function show($id)
    {
        $produk = Produk::where('id_bandeng', $id)->firstOrFail();
        return view('pesanan.detail', compact('produk'));
    }

    // 3. Masukkan produk ke Session Keranjang
    public function tambahKeranjang(Request $request)
    {
        $request->validate([
            'produk_id' => 'required',
            'jumlah' => 'required|integer|min:1'
        ]);

        $produk = Produk::where('id_bandeng', $request->produk_id)->firstOrFail();

        if ($produk->stok < $request->jumlah) {
            return back()->with('error', 'Maaf, stok bandeng tidak mencukupi!');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$request->produk_id])) {
            $cart[$request->produk_id]['jumlah'] += $request->jumlah;
        } else {
            $cart[$request->produk_id] = [
                '_id' => $produk->id_bandeng,
                'nama' => $produk->nama_bandeng,
                'harga' => $produk->harga,
                'jumlah' => $request->jumlah,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('pesanan.index')->with('success', 'Produk berhasil dimasukkan ke keranjang!');
    }

    // 4. Tampilkan Halaman Keranjang
    public function keranjang()
    {
        $cart = session()->get('cart', []);
        return view('pesanan.keranjang', compact('cart'));
    }

    // 5. Hapus item dari Keranjang
    public function hapusKeranjang($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('pesanan.keranjang')->with('success', 'Produk dihapus dari keranjang.');
    }

    // 6. Tampilkan Halaman Checkout
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('pesanan.keranjang')->with('error', 'Keranjang belanja masih kosong.');
        }

        $totalHarga = 0;
        foreach ($cart as $item) {
            $totalHarga += $item['harga'] * $item['jumlah'];
        }

        return view('pesanan.checkout', compact('cart', 'totalHarga'));
    }

    // 7. Proses Checkout: Simpan ke Database & Bawa ke Halaman Pembayaran
    public function prosesCheckout(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string',
            'metode_pembayaran' => 'required|string',
            'metode_pesanan' => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('pesanan.keranjang')->with('error', 'Keranjang kosong.');
        }

        $noFaktur = 'TRX-' . date('YmdHis');

        $customerId = Auth::user()->id_customer ?? null;
        $kasir = DB::table('kasir')->first();
        
        if (!$customerId || !$kasir) {
            return back()->with('error', 'Data Customer yang login atau Kasir belum valid.');
        }

        $totalBelanja = 0;
        foreach ($cart as $item) {
            $totalBelanja += $item['harga'] * $item['jumlah'];
        }

        DB::transaction(function () use ($noFaktur, $request, $cart, $totalBelanja, $customerId, $kasir) {
            
            DB::table('transaksi_penjualan')->insert([
                'no_faktur' => $noFaktur,
                'id_customer' => $customerId,
                'id_kasir' => $kasir->id_kasir,
                'tanggal_penjualan' => now(),
                'tgl_cetak_faktur' => now(),
                'metode_pembayaran' => $request->metode_pembayaran,
                'status_pembayaran' => 'Belum Lunas',
                'metode_pemesanan' => $request->metode_pesanan,
                'subtotal' => $totalBelanja,
                'kembalian' => 0
            ]);

            foreach ($cart as $item) {
                DB::table('detail_penjualan')->insert([
                    'no_faktur' => $noFaktur,
                    'id_bandeng' => $item['_id'],
                    'jumlah' => $item['jumlah'],
                    'harga_item' => $item['harga'],
                ]);

                $produkModel = Produk::where('id_bandeng', $item['_id'])->first();
                if ($produkModel) {
                    $produkModel->stok -= $item['jumlah'];
                    $produkModel->save();
                }
            }
        });

        // Kosongkan keranjang
        session()->forget('cart');

        // Arahkan ke halaman instruksi pembayaran
        return redirect()->route('pesanan.pembayaran', $noFaktur);
    }

    // 8. Tampilkan Halaman Instruksi Pembayaran
    public function pembayaran($noFaktur)
    {
        $pesanan = DB::table('transaksi_penjualan')
            ->where('no_faktur', $noFaktur)
            ->first();

        if (!$pesanan) {
            return redirect()->route('pesanan.index')->with('error', 'Data transaksi tidak ditemukan.');
        }

        if ($pesanan->status_pembayaran == 'Belum Lunas' && empty($pesanan->bukti_pembayaran)) {
            $waktuPesan = \Carbon\Carbon::parse($pesanan->tanggal_penjualan);
            if ($waktuPesan->addMinutes(10)->isPast()) {
                $this->jalankanExpiredInternal($noFaktur);
                return redirect()->route('pesanan.notifikasi')->with('error', 'Waktu pembayaran telah habis. Pesanan otomatis dibatalkan.');
            }
        }

        return view('pesanan.pembayaran', compact('pesanan'));
    }

    public function setExpired($no_faktur)
    {
        $this->jalankanExpiredInternal($no_faktur);
        return response()->json(['success' => true]);
    }

    // 9. Proses Upload Bukti Bayar oleh Customer
    public function uploadBukti(Request $request, $noFaktur)
    {
        $request->validate([
            'bukti_bayar' => 'required|image|max:2048'
        ]);

        $file = $request->file('bukti_bayar');
        $namaFile = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/bukti'), $namaFile);

        DB::table('transaksi_penjualan')
            ->where('no_faktur', $noFaktur)
            ->update([
                'bukti_pembayaran' => $namaFile, 
                'status_pembayaran' => 'Belum Lunas' 
            ]);

        return redirect()->route('pesanan.konfirmasi', $noFaktur)->with('success', 'Bukti pembayaran berhasil dikirim!');
    }

    // 10. Menampilkan halaman konfirmasi / sukses pesanan diproses
    public function konfirmasi($id)
    {
        $pesanan = DB::table('transaksi_penjualan')
            ->join('detail_penjualan', 'transaksi_penjualan.no_faktur', '=', 'detail_penjualan.no_faktur')
            ->join('bandeng', 'detail_penjualan.id_bandeng', '=', 'bandeng.id_bandeng')
            ->where('transaksi_penjualan.no_faktur', $id)
            ->first();

        return view('pesanan.konfirmasi', compact('pesanan'));
    }

    public function riwayatPesanan() 
    {
        $customerId = Auth::user()->id_customer ?? null;

        $riwayatPesanan = DB::table('transaksi_penjualan')
                        ->where('id_customer', $customerId)
                        ->orderBy('tanggal_penjualan', 'desc')
                        ->get();

        foreach ($riwayatPesanan as $trx) {
            $trx->details = DB::table('detail_penjualan')
                            ->join('bandeng', 'detail_penjualan.id_bandeng', '=', 'bandeng.id_bandeng')
                            ->where('detail_penjualan.no_faktur', $trx->no_faktur)
                            ->get();
        }

        return view('pesanan.riwayat', compact('riwayatPesanan'));
    }

    public function notifikasi()
    {
        $customerId = Auth::user()->id_customer ?? null;

        if (!$customerId) {
            return view('pesanan.notifikasi', ['notifikasi' => []]);
        }

        $transaksis = DB::table('transaksi_penjualan')
            ->where('id_customer', $customerId)
            ->where('status_pembayaran', 'Belum Lunas')
            ->get();

        foreach ($transaksis as $trx) {
            if (empty($trx->bukti_pembayaran)) {
                $waktuPesan = \Carbon\Carbon::parse($trx->tanggal_penjualan);
                if ($waktuPesan->addMinutes(10)->isPast()) {
                    $this->jalankanExpiredInternal($trx->no_faktur);
                }
            }
        }

        $notifikasi = DB::table('transaksi_penjualan')
            ->where('id_customer', $customerId)
            ->orderBy('tanggal_penjualan', 'desc')
            ->get();

        return view('pesanan.notifikasi', compact('notifikasi'));
    }

    private function jalankanExpiredInternal($no_faktur)
    {
        $pesanan = DB::table('transaksi_penjualan')->where('no_faktur', $no_faktur)->first();
    
        if ($pesanan && $pesanan->status_pembayaran == 'Belum Lunas') {
            DB::transaction(function () use ($pesanan) {
                $details = DB::table('detail_penjualan')->where('no_faktur', $pesanan->no_faktur)->get();
                $cart = session()->get('cart', []);

                foreach ($details as $detail) {
                    $produk = Produk::where('id_bandeng', $detail->id_bandeng)->first();
                    if ($produk) {
                        $produk->stok += $detail->jumlah;
                        $produk->save();
                    }

                    if (isset($cart[$detail->id_bandeng])) {
                        $cart[$detail->id_bandeng]['jumlah'] += $detail->jumlah;
                    } else {
                        $infoBandeng = Produk::where('id_bandeng', $detail->id_bandeng)->first();
                        if ($infoBandeng) {
                            $cart[$detail->id_bandeng] = [
                                '_id' => $infoBandeng->id_bandeng,
                                'nama' => $infoBandeng->nama_bandeng,
                                'harga' => $infoBandeng->harga,
                                'jumlah' => $detail->jumlah,
                            ];
                        }
                    }
                }

                session()->put('cart', $cart);

                DB::table('transaksi_penjualan')
                    ->where('no_faktur', $pesanan->no_faktur)
                    ->update(['status_pembayaran' => 'Batal']);
            });
        }
    }
}