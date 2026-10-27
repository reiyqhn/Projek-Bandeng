<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
<<<<<<< HEAD
    // 1. Menampilkan katalog produk bandeng presto
=======
    
>>>>>>> 72a5356a1cb3aeaec63a3b86817a58597f17b22a
    public function index()
    {
        $produks = Produk::all();
        return view('pesanan.katalog', compact('produks'));
    }

<<<<<<< HEAD
    // 2. Menampilkan detail produk yang dipilih customer
=======
    
>>>>>>> 72a5356a1cb3aeaec63a3b86817a58597f17b22a
    public function show($id)
    {
        $produk = Produk::where('id_bandeng', $id)->firstOrFail();
        return view('pesanan.detail', compact('produk'));
    }

<<<<<<< HEAD
    // 3. Masukkan produk ke Session Keranjang
=======
   
>>>>>>> 72a5356a1cb3aeaec63a3b86817a58597f17b22a
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

<<<<<<< HEAD
    // 4. Tampilkan Halaman Keranjang
=======
   
>>>>>>> 72a5356a1cb3aeaec63a3b86817a58597f17b22a
    public function keranjang()
    {
        $cart = session()->get('cart', []);
        return view('pesanan.keranjang', compact('cart'));
    }

<<<<<<< HEAD
    // 5. Hapus item dari Keranjang
=======

>>>>>>> 72a5356a1cb3aeaec63a3b86817a58597f17b22a
    public function hapusKeranjang($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('pesanan.keranjang')->with('success', 'Produk dihapus dari keranjang.');
    }

<<<<<<< HEAD
    // 6. Tampilkan Halaman Checkout
=======
    
>>>>>>> 72a5356a1cb3aeaec63a3b86817a58597f17b22a
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

<<<<<<< HEAD
    // 7. Proses Checkout: Simpan ke Database & Bawa ke Halaman Pembayaran
=======

>>>>>>> 72a5356a1cb3aeaec63a3b86817a58597f17b22a
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

        $customer = DB::table('customer')->first();
        $kasir = DB::table('kasir')->first();

        if (!$customer || !$kasir) {
            return back()->with('error', 'Data Customer atau Kasir belum tersedia di database.');
        }

        $totalBelanja = 0;
        foreach ($cart as $item) {
            $totalBelanja += $item['harga'] * $item['jumlah'];
        }

        DB::transaction(function () use ($noFaktur, $request, $cart, $totalBelanja, $customer, $kasir) {
            
            DB::table('transaksi_penjualan')->insert([
                'no_faktur' => $noFaktur,
                'id_customer' => $customer->id_customer,
                'id_kasir' => $kasir->id_kasir,
                'tanggal_penjualan' => now(),
                'tgl_cetak_faktur' => now(),
                'metode_pembayaran' => $request->metode_pembayaran,
<<<<<<< HEAD
                'status_pembayaran' => 'Belum Lunas', // Disesuaikan dengan ENUM database
=======
                'status_pembayaran' => 'Belum Lunas', 
>>>>>>> 72a5356a1cb3aeaec63a3b86817a58597f17b22a
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

<<<<<<< HEAD
        // Kosongkan keranjang
        session()->forget('cart');

        // Arahkan ke halaman instruksi pembayaran
        return redirect()->route('pesanan.pembayaran', $noFaktur);
    }

    // 8. Tampilkan Halaman Instruksi Pembayaran (QRIS / Transfer Bank + Timer + Upload Bukti)
=======
   
        session()->forget('cart');

      
        return redirect()->route('pesanan.pembayaran', $noFaktur);
    }


>>>>>>> 72a5356a1cb3aeaec63a3b86817a58597f17b22a
    public function pembayaran($noFaktur)
    {
        $pesanan = DB::table('transaksi_penjualan')
            ->where('no_faktur', $noFaktur)
            ->first();

        if (!$pesanan) {
            return redirect()->route('pesanan.index')->with('error', 'Data transaksi tidak ditemukan.');
        }

        return view('pesanan.pembayaran', compact('pesanan'));
    }

<<<<<<< HEAD
    // 9. Proses Upload Bukti Bayar oleh Customer
=======
>>>>>>> 72a5356a1cb3aeaec63a3b86817a58597f17b22a
    public function uploadBukti(Request $request, $noFaktur)
    {
        $request->validate([
            'bukti_bayar' => 'required|image|max:2048'
        ]);

        $file = $request->file('bukti_bayar');
        $namaFile = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/bukti'), $namaFile);

<<<<<<< HEAD
        // Update status transaksi tetap 'Belum Lunas' (menunggu acc penjual menjadi 'Lunas')
        DB::table('transaksi_penjualan')
            ->where('no_faktur', $noFaktur)
            ->update([
=======

        DB::table('transaksi_penjualan')
            ->where('no_faktur', $noFaktur)
            ->update([
                'bukti_pembayaran' => $namaFile, 
>>>>>>> 72a5356a1cb3aeaec63a3b86817a58597f17b22a
                'status_pembayaran' => 'Belum Lunas' 
            ]);

        return redirect()->route('pesanan.konfirmasi', $noFaktur)->with('success', 'Bukti pembayaran berhasil dikirim!');
    }

<<<<<<< HEAD
    // 10. Menampilkan halaman konfirmasi / sukses pesanan diproses
=======
>>>>>>> 72a5356a1cb3aeaec63a3b86817a58597f17b22a
    public function konfirmasi($id)
    {
        $pesanan = DB::table('transaksi_penjualan')
            ->join('detail_penjualan', 'transaksi_penjualan.no_faktur', '=', 'detail_penjualan.no_faktur')
            ->join('bandeng', 'detail_penjualan.id_bandeng', '=', 'bandeng.id_bandeng')
            ->where('transaksi_penjualan.no_faktur', $id)
            ->first();

        return view('pesanan.konfirmasi', compact('pesanan'));
    }
}