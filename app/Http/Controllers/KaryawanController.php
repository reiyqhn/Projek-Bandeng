<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\Dikirim;

class KaryawanController extends Controller
{
    public function beranda()
    {
        $totalTugas  = Dikirim::count();
        $dalamProses = Dikirim::whereIn('status_pengiriman', ['Diproses', 'Di Perjalanan'])->count();
        $selesai     = Dikirim::whereIn('status_pengiriman', ['Terkirim', 'Selesai'])->count();

        $pengiriman = Dikirim::with(['transaksi.customer'])
            ->orderByRaw("CASE WHEN status_pengiriman IN ('Terkirim', 'Selesai') THEN 1 ELSE 0 END ASC")
            ->orderByDesc('no_pengiriman')
            ->take(5)
            ->get();

        $daftarWilayah = Dikirim::daftarWilayah();

        return view('karyawan.beranda', compact('totalTugas', 'dalamProses', 'selesai', 'pengiriman', 'daftarWilayah'));
    }

    public function konfirmasi(Request $request)
    {
        $query = Dikirim::with(['transaksi.customer'])
            ->whereIn('status_pengiriman', ['Diproses', 'Di Perjalanan']);

        if ($request->filled('nomor')) {
            $query->where('no_pengiriman', 'like', '%' . $request->nomor . '%');
        }

        if ($request->filled('wilayah')) {
            $query->where('wilayah', 'like', '%' . $request->wilayah . '%');
        }

        $pengiriman = $query->orderByDesc('no_pengiriman')->get();
        $daftarWilayah = Dikirim::daftarWilayah();

        return view('karyawan.konfirmasi', compact('pengiriman', 'daftarWilayah'));
    }

    public function prosesSelesai($no_pengiriman)
    {
        $paket = Dikirim::where('no_pengiriman', $no_pengiriman)->firstOrFail();
        $paket->status_pengiriman = 'Terkirim';
        $paket->save();

        return redirect()->back()->with('success', 'Paket ' . $no_pengiriman . ' berhasil dikonfirmasi selesai!');
    }

    public function semuaSelesai()
    {
        Dikirim::whereIn('status_pengiriman', ['Diproses', 'Di Perjalanan'])
            ->update(['status_pengiriman' => 'Terkirim']);

        return redirect()->back()->with('success', 'Semua paket berhasil dikonfirmasi selesai!');
    }

    public function dataPengiriman(Request $request)
    {
        $query = Dikirim::with(['transaksi.customer']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_pengiriman', 'like', '%' . $search . '%')
                  ->orWhere('alamat_pengiriman', 'like', '%' . $search . '%')
                  ->orWhere('wilayah', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('wilayah') && $request->wilayah != 'Semua Wilayah') {
            $query->where('wilayah', 'like', '%' . $request->wilayah . '%');
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

        $pengiriman = $query->orderByDesc('no_pengiriman')->paginate(10)->withQueryString();
        $daftarWilayah = Dikirim::daftarWilayah();

        $totalManifes  = Dikirim::count();
        $totalDiproses = Dikirim::where('status_pengiriman', 'Diproses')->count();
        $totalDikirim  = Dikirim::where('status_pengiriman', 'Di Perjalanan')->count();
        $totalSelesai  = Dikirim::whereIn('status_pengiriman', ['Terkirim', 'Selesai'])->count();

        return view('karyawan.data', compact(
            'pengiriman',
            'daftarWilayah',
            'totalManifes',
            'totalDiproses',
            'totalDikirim',
            'totalSelesai',
            'tanggalTersedia'
        ));
    }

    public function riwayat(Request $request)
    {
        $query = Dikirim::with(['transaksi.customer'])
            ->where('status_pengiriman', 'Terkirim');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_pengiriman', 'like', '%' . $search . '%')
                  ->orWhere('alamat_pengiriman', 'like', '%' . $search . '%')
                  ->orWhere('wilayah', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('wilayah') && $request->wilayah != 'Semua Wilayah') {
            $query->where('wilayah', 'like', '%' . $request->wilayah . '%');
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

        $riwayat = $query->orderByDesc('no_pengiriman')->paginate(10)->withQueryString();
        $daftarWilayah = Dikirim::daftarWilayah();

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
            'daftarWilayah',
            'totalSelesai',
            'penyelesaianBulanIni',
            'bulanDipilih'
        ));
    }

    public function storePengiriman(Request $request)
    {
        $validated = $request->validate([
            'no_pengiriman'     => 'required|string|max:50|unique:dikirim,no_pengiriman',
            'alamat_pengiriman' => 'required|string|max:255',
            'wilayah'           => 'nullable|string|max:120',
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

        $wilayah = $this->deteksiWilayahDariAlamat(
            $validated['alamat_pengiriman'],
            $validated['wilayah'] ?? null
        );

        Dikirim::create([
            'no_pengiriman'     => $validated['no_pengiriman'],
            'alamat_pengiriman' => $validated['alamat_pengiriman'],
            'wilayah'           => $wilayah,
            'status_pengiriman' => $validated['status_pengiriman'],
            'id_karyawan'       => $idKaryawan,
            'no_faktur'         => $noFaktur,
        ]);

        return redirect()
            ->route('karyawan.data')
            ->with('success', 'Data pengiriman ' . $validated['no_pengiriman'] . ' berhasil ditambahkan.');
    }

    public function exportExcel(Request $request)
    {
        $query = Dikirim::with(['transaksi.customer']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_pengiriman', 'like', '%' . $search . '%')
                  ->orWhere('alamat_pengiriman', 'like', '%' . $search . '%')
                  ->orWhere('wilayah', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('wilayah') && $request->wilayah != 'Semua Wilayah') {
            $query->where('wilayah', 'like', '%' . $request->wilayah . '%');
        }

        if ($request->filled('status') && $request->status != 'Semua Status') {
            $query->where('status_pengiriman', $request->status);
        }

        $kolomTanggal = $this->deteksiKolomTanggalDikirim();
        if ($kolomTanggal && $request->filled('tanggal')) {
            $query->whereDate($kolomTanggal, $request->tanggal);
        }

        $rows = $query->orderByDesc('no_pengiriman')->get();
        $filename = 'data-pengiriman-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($rows) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, ['No. Resi / Pengiriman', 'Penerima', 'Tujuan / Alamat', 'Wilayah', 'Status']);

            foreach ($rows as $item) {
                $penerima = $item->transaksi->customer->nama_customer
                    ?? $item->transaksi->customer->nama
                    ?? '-';

                $wilayah = $item->wilayah
                    ?: $this->deteksiWilayahDariAlamat($item->alamat_pengiriman);

                fputcsv($file, [
                    $item->no_pengiriman,
                    $penerima,
                    $item->alamat_pengiriman ?? '-',
                    $wilayah,
                    $item->status_pengiriman ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->forget(['id_karyawan', 'nama_karyawan', 'role']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda berhasil logout.');
    }

    private function deteksiWilayahDariAlamat(?string $alamat, ?string $wilayahInput = null): string
    {
        if (!empty($wilayahInput) && $wilayahInput !== 'Pilih Kecamatan / Wilayah Pengiriman') {
            return trim($wilayahInput);
        }

        $teks = strtolower($alamat ?? '');

        $mapping = [
            'Temanggung / Parakan / Bulu (Rp 7.000)'             => ['temanggung', 'parakan', 'bulu'],
            'Kedu / Kranggan / Tlogomulyo (Rp 10.000)'            => ['kedu', 'kranggan', 'tlogomulyo'],
            'Ngadirejo / Selopampang / Pringsurat (Rp 15.000)'  => ['ngadirejo', 'selopampang', 'pringsurat'],
            'Candiroto / Kaloran / Jumo (Rp 18.000)'            => ['candiroto', 'kaloran', 'jumo'],
            'Tretep / Bejen / Gemawang / Wonoboyo (Rp 25.000)'  => ['tretep', 'bejen', 'gemawang', 'wonoboyo'],
        ];

        foreach ($mapping as $labelWilayah => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($teks, $keyword)) {
                    return $labelWilayah;
                }
            }
        }

        if ($teks !== '' && $teks !== '-') {
            return 'Luar Kab. Temanggung via J&T (Rp 20.000)';
        }

        return '-';
    }

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