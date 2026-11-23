<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\Dikirim;

class KaryawanController extends Controller
{
    // 1. Tampilan Beranda
    public function beranda()
    {
        $totalTugas  = Dikirim::count();
        $dalamProses = Dikirim::whereIn('status_pengiriman', ['Diproses', 'Di Perjalanan'])->count();
        $selesai     = Dikirim::where('status_pengiriman', 'Terkirim')->count();

        $pengiriman = Dikirim::with(['transaksi.customer'])->take(5)->get();

        return view('karyawan.beranda', compact('totalTugas', 'dalamProses', 'selesai', 'pengiriman'));
    }

    // 2. Tampilan Konfirmasi Pengiriman
    public function konfirmasi(Request $request)
    {
        $query = Dikirim::with(['transaksi.customer'])
            ->whereIn('status_pengiriman', ['Diproses', 'Di Perjalanan']);

        if ($request->filled('nomor')) {
            $query->where('no_pengiriman', 'like', '%' . $request->nomor . '%');
        }

        $pengiriman = $query->get();

        return view('karyawan.konfirmasi', compact('pengiriman'));
    }

    // 3. Aksi Tombol: Ubah status paket jadi 'Terkirim'
    public function prosesSelesai($no_pengiriman)
    {
        $paket = Dikirim::where('no_pengiriman', $no_pengiriman)->firstOrFail();
        $paket->status_pengiriman = 'Terkirim';
        $paket->save();

        return redirect()->back()->with('success', 'Paket ' . $no_pengiriman . ' berhasil dikonfirmasi selesai!');
    }

    // 4. Aksi Tombol: Konfirmasi Semua Paket
    public function semuaSelesai()
    {
        Dikirim::whereIn('status_pengiriman', ['Diproses', 'Di Perjalanan'])
            ->update(['status_pengiriman' => 'Terkirim']);

        return redirect()->back()->with('success', 'Semua paket berhasil dikonfirmasi selesai!');
    }

    // 5. Tampilan Data Master Pengiriman
    public function dataPengiriman(Request $request)
    {
        $query = Dikirim::with(['transaksi.customer']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_pengiriman', 'like', '%' . $search . '%')
                  ->orWhere('alamat_pengiriman', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status') && $request->status != 'Semua Status') {
            $query->where('status_pengiriman', $request->status);
        }

        $kolomTanggal = $this->deteksiKolomTanggalDikirim();
        $tanggalTersedia = collect();

        if ($kolomTanggal) {
            $tanggalTersedia = Dikirim::selectRaw("DATE(`{$kolomTanggal}`) as tgl")
                ->whereNotNull($kolomTanggal)
                ->distinct()
                ->orderBy('tgl', 'desc')
                ->pluck('tgl');

            if ($request->filled('tanggal')) {
                $query->whereDate($kolomTanggal, $request->tanggal);
            }
        }

        $pengiriman = $query->paginate(10);

        $totalManifes  = Dikirim::count();
        $totalDiproses = Dikirim::where('status_pengiriman', 'Diproses')->count();
        $totalDikirim  = Dikirim::where('status_pengiriman', 'Di Perjalanan')->count();
        $totalSelesai  = Dikirim::where('status_pengiriman', 'Terkirim')->count();

        return view('karyawan.data', compact(
            'pengiriman',
            'totalManifes',
            'totalDiproses',
            'totalDikirim',
            'totalSelesai',
            'tanggalTersedia'
        ));
    }

    // 6. Tampilan Riwayat Pengiriman (sinkron dengan data Terkirim)
    public function riwayat(Request $request)
    {
        $query = Dikirim::with(['transaksi.customer'])
            ->where('status_pengiriman', 'Terkirim');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_pengiriman', 'like', '%' . $search . '%')
                  ->orWhere('alamat_pengiriman', 'like', '%' . $search . '%');
            });
        }

        $kolomTanggal = $this->deteksiKolomTanggalDikirim();
        $bulanDipilih = $request->input('bulan');

        if ($kolomTanggal && $request->filled('bulan')) {
            $parts = explode('-', $bulanDipilih);
            if (count($parts) === 2) {
                $query->whereYear($kolomTanggal, $parts[0])
                      ->whereMonth($kolomTanggal, $parts[1]);
            }
        }

        $riwayat = $query->orderByDesc('no_pengiriman')->paginate(10);

        $totalSelesai = Dikirim::where('status_pengiriman', 'Terkirim')->count();

        $queryBulan = Dikirim::where('status_pengiriman', 'Terkirim');
        if ($kolomTanggal) {
            if ($request->filled('bulan')) {
                $parts = explode('-', $bulanDipilih);
                if (count($parts) === 2) {
                    $queryBulan->whereYear($kolomTanggal, $parts[0])
                               ->whereMonth($kolomTanggal, $parts[1]);
                }
            } else {
                $queryBulan->whereYear($kolomTanggal, now()->year)
                           ->whereMonth($kolomTanggal, now()->month);
            }
        }
        $penyelesaianBulanIni = $queryBulan->count();

        return view('karyawan.riwayat', compact(
            'riwayat',
            'totalSelesai',
            'penyelesaianBulanIni',
            'bulanDipilih'
        ));
    }

    // 7. Simpan Data Pengiriman Baru (+ Tambah Data)
    public function storePengiriman(Request $request)
    {
        $validated = $request->validate([
            'no_pengiriman'     => 'required|string|max:50|unique:dikirim,no_pengiriman',
            'alamat_pengiriman' => 'required|string|max:255',
            'status_pengiriman' => 'required|string|max:50',
            'no_faktur'         => 'nullable|string|max:50',
            'id_karyawan'       => 'nullable|string|max:50',
        ]);

        $idKaryawan = $validated['id_karyawan']
            ?? session('id_karyawan')
            ?? (auth()->user()->id_karyawan ?? null)
            ?? Dikirim::whereNotNull('id_karyawan')->value('id_karyawan')
            ?? 'KR002';

        $fakturTerpakai = Dikirim::whereNotNull('no_faktur')->pluck('no_faktur');

        $noFaktur = (!empty($validated['no_faktur']) && $validated['no_faktur'] !== '-')
            ? $validated['no_faktur']
            : (DB::table('transaksi_penjualan')
                ->whereNotIn('no_faktur', $fakturTerpakai)
                ->value('no_faktur')
                    ?? DB::table('transaksi_penjualan')->inRandomOrder()->value('no_faktur')
                    ?? Dikirim::whereNotNull('no_faktur')->value('no_faktur')
                    ?? 'TRX-001');

        Dikirim::create([
            'no_pengiriman'     => $validated['no_pengiriman'],
            'alamat_pengiriman' => $validated['alamat_pengiriman'],
            'status_pengiriman' => $validated['status_pengiriman'],
            'id_karyawan'       => $idKaryawan,
            'no_faktur'         => $noFaktur,
        ]);

        return redirect()
            ->route('karyawan.data')
            ->with('success', 'Data pengiriman ' . $validated['no_pengiriman'] . ' berhasil ditambahkan.');
    }

    // 8. Export Data Pengiriman ke CSV / Excel
    public function exportExcel(Request $request)
    {
        $query = Dikirim::with(['transaksi.customer']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_pengiriman', 'like', '%' . $search . '%')
                  ->orWhere('alamat_pengiriman', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status') && $request->status != 'Semua Status') {
            $query->where('status_pengiriman', $request->status);
        }

        $kolomTanggal = $this->deteksiKolomTanggalDikirim();
        if ($kolomTanggal && $request->filled('tanggal')) {
            $query->whereDate($kolomTanggal, $request->tanggal);
        }

        $rows = $query->get();
        $filename = 'data-pengiriman-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($rows) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, ['No. Resi / Pengiriman', 'Penerima', 'Tujuan / Alamat', 'Status']);

            foreach ($rows as $item) {
                $penerima = $item->transaksi->customer->nama_customer
                    ?? $item->transaksi->customer->nama
                    ?? '-';

                fputcsv($file, [
                    $item->no_pengiriman,
                    $penerima,
                    $item->alamat_pengiriman ?? '-',
                    $item->status_pengiriman ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // 9. Logout Karyawan & Kembali ke Login
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->forget(['id_karyawan', 'nama_karyawan', 'role']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda berhasil logout.');
    }

    // Helper: Deteksi otomatis kolom tanggal pada tabel 'dikirim'
    private function deteksiKolomTanggalDikirim(): ?string
    {
        $kandidat = [
            'tanggal_pengiriman',
            'tgl_pengiriman',
            'tanggal_kirim',
            'tgl_kirim',
            'tanggal',
            'created_at',
        ];

        foreach ($kandidat as $kolom) {
            if (Schema::hasColumn('dikirim', $kolom)) {
                return $kolom;
            }
        }

        return null;
    }
}