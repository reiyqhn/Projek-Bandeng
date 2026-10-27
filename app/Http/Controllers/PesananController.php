
<?php

//namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    // 1. Menampilkan katalog produk bandeng presto + pencarian
    public function index()
    {
        $cari = request('cari');

        $query = Produk::query();

        if (!empty($cari)) {
            $query->where('nama_bandeng', 'LIKE', '%' . $cari . '%');
        }

        $produks = $query->get();

        return view('pesanan.katalog', compact('produks', 'cari'));
    }

    // 2. Menampilkan detail produk
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

        return redirect()->route('pesanan.index')
            ->with('success', 'Produk berhasil dimasukkan ke keranjang!');
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

        return redirect()->route('pesanan.keranjang')
            ->with('success', 'Produk dihapus dari keranjang.');
    }

    // 6. Tampilkan Halaman Checkout
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('pesanan.keranjang')
                ->with('error', 'Keranjang belanja masih kosong.');
        }

        $totalHarga = 0;

        foreach ($cart as $item) {
            $totalHarga += $item['harga'] * $item['jumlah'];
        }

        return view('pesanan.checkout', compact('cart', 'totalHarga'));
    }

    // 7. Proses Checkout
    public function prosesCheckout(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string',
            'metode_pembayaran' => 'required|string',
            'metode_pesanan' => 'required|string',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('pesanan.keranjang')
                ->with('error', 'Keranjang kosong.');
        }

        $noFaktur = 'TRX-' . date('YmdHis');

        $customer = DB::table('customer')->first();
        $kasir = DB::table('kasir')->first();

        if (!$customer || !$kasir) {
            return back()->with(
                'error',
                'Data Customer atau Kasir belum tersedia di database.'
            );
        }

        $totalBelanja = 0;

        foreach ($cart as $item) {
            $totalBelanja += $item['harga'] * $item['jumlah'];
        }

        DB::transaction(function () use (
            $noFaktur,
            $request,
            $cart,
            $totalBelanja,
            $customer,
            $kasir
        ) {
            DB::table('transaksi_penjualan')->insert([
                'no_faktur' => $noFaktur,
                'id_customer' => $customer->id_customer,
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

                $produkModel = Produk::where(
                    'id_bandeng',
                    $item['_id']
                )->first();

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
            return redirect()->route('pesanan.index')
                ->with('error', 'Data transaksi tidak ditemukan.');
        }

        return view('pesanan.pembayaran', compact('pesanan'));
    }

    // 9. Proses Upload Bukti Bayar
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
                'status_pembayaran' => 'Belum Lunas'
            ]);

        return redirect()->route('pesanan.konfirmasi', $noFaktur)
            ->with('success', 'Bukti pembayaran berhasil dikirim!');
    }

    // 10. Menampilkan Halaman Konfirmasi Pesanan
    public function konfirmasi($id)
    {
        $pesanan = DB::table('transaksi_penjualan')
            ->join(
                'detail_penjualan',
                'transaksi_penjualan.no_faktur',
                '=',
                'detail_penjualan.no_faktur'
            )
            ->join(
                'bandeng',
                'detail_penjualan.id_bandeng',
                '=',
                'bandeng.id_bandeng'
            )
            ->where('transaksi_penjualan.no_faktur', $id)
            ->first();

        return view('pesanan.konfirmasi', compact('pesanan'));
    }
}
