<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\Transaction;
use App\Models\Produk;
use App\Models\Customer;

class TransaksiOfflineController extends Controller
{
    public function index()
    {
        $bandengs = Produk::orderBy('nama_bandeng')->get();
        $customers = Customer::all();
        $keranjang = session('pos_keranjang_aktif', []);
        $customerData = session('pos_customer', [
            'id_customer' => 'CUS' . rand(10000, 99999),
            'nama_customer' => '',
        ]);

        $totalSemua = 0;
        foreach ($keranjang as $item) {
            $totalSemua += $item['subtotal'];
        }

        return view('dashboard.kasir.transaksi_offline.index', compact(
            'bandengs',
            'customers',
            'keranjang',
            'customerData',
            'totalSemua'
        ));
    }

    public function tambahItem(Request $request)
    {
        $request->validate([
            'id_customer' => 'required',
            'nama_customer' => 'required',
            'id_bandeng' => 'required',
            'jumlah' => 'required|integer|min:1',
        ]);

        session([
            'pos_customer' => [
                'id_customer' => $request->id_customer,
                'nama_customer' => $request->nama_customer,
            ]
        ]);

        $errorMsg = null;

        DB::transaction(function () use ($request, &$errorMsg) {
            $produk = Produk::where('id_bandeng', $request->id_bandeng)->lockForUpdate()->first();

            if (!$produk) {
                $errorMsg = 'Barang tidak ditemukan.';
                return;
            }

            if ($produk->stok < $request->jumlah) {
                $errorMsg = 'Stok tidak cukup! Sisa stok: ' . $produk->stok;
                return;
            }

            $produk->stok -= $request->jumlah;
            $produk->save();

            $keranjang = session('pos_keranjang_aktif', []);
            $ketemu = false;

            foreach ($keranjang as &$item) {
                if ((string) $item['id'] === (string) $produk->id_bandeng) {
                    $item['jumlah'] += (int) $request->jumlah;
                    $item['subtotal'] = $item['jumlah'] * $item['harga'];
                    $ketemu = true;
                    break;
                }
            }
            unset($item);

            if (!$ketemu) {
                $keranjang[] = [
                    'id' => $produk->id_bandeng,
                    'nama' => $produk->nama_bandeng,
                    'harga' => (float) $produk->harga,
                    'jumlah' => (int) $request->jumlah,
                    'subtotal' => (float) $produk->harga * (int) $request->jumlah,
                ];
            }

            session(['pos_keranjang_aktif' => array_values($keranjang)]);
        });

        if ($errorMsg) {
            return redirect()->route('kasir.offline.index')->with('error', $errorMsg);
        }

        return redirect()->route('kasir.offline.index')->with('success', 'Barang ditambahkan & stok berkurang.');
    }

    public function updateQty(Request $request)
    {
        $request->validate([
            'id_bandeng' => 'required',
            'aksi' => 'required|in:plus,minus',
        ]);

        $errorMsg = null;

        DB::transaction(function () use ($request, &$errorMsg) {
            $produk = Produk::where('id_bandeng', $request->id_bandeng)->lockForUpdate()->first();
            $keranjang = session('pos_keranjang_aktif', []);

            if (!$produk) {
                $errorMsg = 'Barang tidak ditemukan.';
                return;
            }

            foreach ($keranjang as $idx => &$item) {
                if ((string) $item['id'] === (string) $produk->id_bandeng) {
                    if ($request->aksi === 'plus') {
                        if ($produk->stok < 1) {
                            $errorMsg = 'Stok sudah habis!';
                            return;
                        }
                        $produk->stok -= 1;
                        $produk->save();

                        $item['jumlah'] += 1;
                        $item['subtotal'] = $item['jumlah'] * $item['harga'];
                    } else {
                        $produk->stok += 1;
                        $produk->save();

                        $item['jumlah'] -= 1;
                        if ($item['jumlah'] <= 0) {
                            unset($keranjang[$idx]);
                        } else {
                            $item['subtotal'] = $item['jumlah'] * $item['harga'];
                        }
                    }
                    break;
                }
            }
            unset($item);

            session(['pos_keranjang_aktif' => array_values($keranjang)]);
        });

        if ($errorMsg) {
            return redirect()->route('kasir.offline.index')->with('error', $errorMsg);
        }

        return redirect()->route('kasir.offline.index');
    }

    public function batalTransaksi()
    {
        DB::transaction(function () {
            $keranjang = session('pos_keranjang_aktif', []);

            foreach ($keranjang as $item) {
                $produk = Produk::where('id_bandeng', $item['id'])->lockForUpdate()->first();
                if ($produk) {
                    $produk->stok += (int) $item['jumlah'];
                    $produk->save();
                }
            }

            session()->forget(['pos_keranjang_aktif', 'pos_customer', 'pos_transaksi']);
        });

        return redirect()->route('kasir.offline.index')->with('success', 'Pesanan dibatalkan & stok kembali seperti semula.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_customer' => 'required',
            'nama_customer' => 'required',
        ]);

        $keranjang = session('pos_keranjang_aktif', []);
        if (empty($keranjang)) {
            return redirect()->route('kasir.offline.index')->with('error', 'Keranjang masih kosong!');
        }

        $items = [];
        foreach ($keranjang as $item) {
            $items[] = [
                'id_bandeng' => $item['id'],
                'jumlah' => $item['jumlah'],
            ];
        }

        session([
            'pos_transaksi' => [
                'id_customer' => $request->id_customer,
                'nama_customer' => $request->nama_customer,
                'items' => $items,
            ]
        ]);

        return redirect()->route('kasir.offline.pembayaran');
    }

    public function pembayaran()
    {
        $transaksiData = session('pos_transaksi');
        if (!$transaksiData) {
            return redirect()->route('kasir.offline.index')->with('error', 'Belum ada transaksi yang dipilih!');
        }

        $itemsDetail = [];
        $totalSemua = 0;
        foreach ($transaksiData['items'] as $item) {
            $produk = Produk::where('id_bandeng', $item['id_bandeng'])->first();
            if ($produk) {
                $subtotal = $produk->harga * $item['jumlah'];
                $totalSemua += $subtotal;
                $itemsDetail[] = [
                    'nama' => $produk->nama_bandeng,
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $subtotal
                ];
            }
        }

        return view('dashboard.kasir.transaksi_offline.pembayaran', compact('transaksiData', 'itemsDetail', 'totalSemua'));
    }

    public function pembayaranStore(Request $request)
    {
        $transaksiData = session('pos_transaksi');
        if (!$transaksiData) {
            return redirect()->route('kasir.offline.index');
        }

        $request->validate([
            'metode_pembayaran' => 'required',
        ]);

        $no_faktur = 'TRX-OFF-' . date('YmdHis');

        DB::transaction(function () use ($request, $transaksiData, $no_faktur) {
            $totalSemua = 0;
            foreach ($transaksiData['items'] as $item) {
                $produk = Produk::where('id_bandeng', $item['id_bandeng'])->first();
                if ($produk) {
                    $totalSemua += $produk->harga * $item['jumlah'];
                }
            }

            $existingCustomer = DB::table('customer')->where('id_customer', $transaksiData['id_customer'])->first();
            if (!$existingCustomer) {
                $customerPayload = [
                    'id_customer' => $transaksiData['id_customer'],
                    'nama' => $transaksiData['nama_customer'],
                    'username' => strtolower($transaksiData['id_customer']),
                    'password' => Hash::make('offline123'),
                ];

                if (Schema::hasColumn('customer', 'no_telp')) {
                    $customerPayload['no_telp'] = '-';
                }
                if (Schema::hasColumn('customer', 'alamat')) {
                    $customerPayload['alamat'] = 'Pembelian Offline di Toko';
                }

                DB::table('customer')->insert($customerPayload);
            }

            $metodeBayar = $request->metode_pembayaran === 'Tunai' ? 'Cash' : $request->metode_pembayaran;
            $idKasir = Auth::guard('kasir')->user()->id_kasir ?? 'KSR001';

            DB::table('transaksi_penjualan')->insert([
                'no_faktur' => $no_faktur,
                'id_customer' => $transaksiData['id_customer'],
                'id_kasir' => $idKasir,
                'tanggal_penjualan' => now(),
                'tgl_cetak_faktur' => now(),
                'metode_pembayaran' => $metodeBayar,
                'status_pembayaran' => 'Lunas',
                'metode_pemesanan' => 'Takeaway',
                'subtotal' => $totalSemua,
                'kembalian' => $request->kembalian ?? 0,
                'ongkir' => 0,
            ]);

            foreach ($transaksiData['items'] as $item) {
                $produk = Produk::where('id_bandeng', $item['id_bandeng'])->first();
                if ($produk) {
                    DB::table('detail_penjualan')->insert([
                        'no_faktur' => $no_faktur,
                        'id_bandeng' => $item['id_bandeng'],
                        'jumlah' => $item['jumlah'],
                        'harga_item' => $produk->harga,
                    ]);
                }
            }
        });

        session()->forget(['pos_transaksi', 'pos_keranjang_aktif', 'pos_customer']);

        return redirect()->route('kasir.offline.faktur', ['no_faktur' => $no_faktur])
            ->with('success', 'Pembayaran berhasil dan transaksi disimpan!');
    }

    public function faktur($no_faktur = null)
    {
        $fakturs = Transaction::with('customer')
            ->where('metode_pemesanan', 'Takeaway')
            ->orderBy('no_faktur', 'desc')
            ->get();

        if ($no_faktur) {
            $selectedFaktur = Transaction::with('customer')
                ->where('no_faktur', $no_faktur)
                ->first();
        } else {
            $selectedFaktur = Transaction::with('customer')
                ->where('metode_pemesanan', 'Takeaway')
                ->orderBy('no_faktur', 'desc')
                ->first();
        }

        if ($selectedFaktur) {
            $details = DB::table('detail_penjualan')
                ->leftJoin('bandeng', 'detail_penjualan.id_bandeng', '=', 'bandeng.id_bandeng')
                ->where('detail_penjualan.no_faktur', $selectedFaktur->no_faktur)
                ->select(
                    'detail_penjualan.id_bandeng',
                    'detail_penjualan.jumlah',
                    'detail_penjualan.harga_item',
                    'bandeng.nama_bandeng'
                )
                ->get()
                ->map(function ($row) {
                    $row->subtotal = (float) $row->jumlah * (float) $row->harga_item;
                    $row->produk = (object) [
                        'nama_bandeng' => $row->nama_bandeng ?? $row->id_bandeng,
                    ];
                    return $row;
                });

            $selectedFaktur->setAttribute('detailPenjualans', $details);
        }

        return view('dashboard.kasir.transaksi_offline.faktur', compact('fakturs', 'selectedFaktur'));
    }
}