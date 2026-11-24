<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pengiriman - Bandeng Samudra</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #02121d;
            color: #ffffff;
            display: flex;
            min-height: 100vh;
        }

        .ico {
            display: inline-block;
            flex-shrink: 0;
            vertical-align: middle;
        }

        /* SIDEBAR */
        .sidebar {
            width: 245px;
            background: linear-gradient(180deg, #031d2e 0%, #02131f 100%);
            padding: 18px 14px;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(56, 189, 248, 0.16);
            flex-shrink: 0;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 2px 6px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 14px;
        }

        .brand-logo img {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid rgba(45, 212, 191, 0.5);
            box-shadow: 0 0 14px rgba(34, 211, 238, 0.25);
        }

        .brand-logo span {
            font-size: 19px;
            font-weight: 700;
            letter-spacing: 0.8px;
            color: #ffffff;
            text-shadow: 0 0 14px rgba(34, 211, 238, 0.55);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 6px 16px;
            margin-bottom: 14px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .user-profile strong {
            font-size: 15.5px;
            font-weight: 500;
            color: #f8fafc;
        }

        .sidebar-menu {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex-grow: 1;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 15px;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 400;
            transition: all 0.22s ease;
        }

        .sidebar-menu a:hover {
            background: rgba(20, 184, 166, 0.14);
            color: #ffffff;
        }

        .sidebar-menu a.active {
            background: linear-gradient(90deg, #0a7e8c 0%, #16c4b0 100%);
            color: #ffffff;
            font-weight: 500;
            box-shadow: 0 0 18px rgba(22, 196, 176, 0.42), inset 0 0 8px rgba(255, 255, 255, 0.22);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            color: #e2e8f0;
            text-decoration: none;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 9px;
            font-size: 13.5px;
            transition: all 0.2s ease;
        }

        .logout-btn:hover {
            border-color: rgba(45, 212, 191, 0.5);
            color: #ffffff;
        }

        /* MAIN CONTENT */
        .main-content {
            flex-grow: 1;
            padding: 26px 32px;
            background:
                radial-gradient(ellipse at 95% 8%, rgba(20, 184, 166, 0.18), transparent 38%),
                radial-gradient(ellipse at 50% 45%, rgba(14, 116, 144, 0.16), transparent 55%),
                linear-gradient(135deg, #042238 0%, #031726 55%, #020e18 100%);
            min-width: 0;
        }

        .header-section {
            margin-bottom: 20px;
        }

        .header-section h1 {
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 4px;
        }

        .header-section p {
            color: #93adc2;
            font-size: 13px;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(2, minmax(180px, 1fr));
            gap: 14px;
            margin-bottom: 20px;
        }

        .stat-box {
            background: rgba(6, 28, 45, 0.72);
            border: 1px solid rgba(56, 189, 248, 0.24);
            border-radius: 12px;
            padding: 14px 16px;
        }

        .stat-box span {
            font-size: 12px;
            color: #93adc2;
            display: block;
            margin-bottom: 4px;
        }

        .stat-box strong {
            font-size: 22px;
            color: #ffffff;
        }

        .filter-card {
            background: rgba(6, 28, 45, 0.72);
            border: 1px solid rgba(56, 189, 248, 0.26);
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 20px;
        }

        .filter-form {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-form input,
        .filter-form select {
            padding: 10px 14px;
            background: rgba(3, 18, 30, 0.85);
            border: 1px solid rgba(125, 211, 252, 0.22);
            border-radius: 9px;
            color: #ffffff;
            font-size: 13px;
            outline: none;
        }

        .filter-form input[type="text"] {
            flex-grow: 1;
            min-width: 220px;
        }

        .btn-filter {
            background: #0d9488;
            color: #ffffff;
            border: none;
            padding: 10px 16px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
        }

        .btn-reset {
            background: rgba(255, 255, 255, 0.06);
            color: #cbd5e1;
            border: 1px solid rgba(255, 255, 255, 0.16);
            padding: 10px 14px;
            border-radius: 9px;
            font-size: 13px;
            text-decoration: none;
        }

        .table-card {
            background: rgba(5, 24, 39, 0.76);
            border: 1px solid rgba(45, 212, 191, 0.34);
            border-radius: 14px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background: rgba(8, 36, 56, 0.92);
            padding: 14px 16px;
            font-size: 11px;
            font-weight: 600;
            color: #cbd5e1;
            letter-spacing: 0.7px;
            text-transform: uppercase;
            border-bottom: 1px solid rgba(56, 189, 248, 0.2);
        }

        td {
            padding: 14px 16px;
            font-size: 13px;
            color: #e2e8f0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
            vertical-align: middle;
        }

        .wilayah-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 11.5px;
            font-weight: 500;
            background: rgba(20, 184, 166, 0.16);
            color: #5eead4;
            border: 1px solid rgba(45, 212, 191, 0.32);
        }

        .status-done {
            display: inline-block;
            padding: 4px 11px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 500;
            background: rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
            border: 1px solid rgba(52, 211, 153, 0.38);
        }

        .table-footer {
            padding: 13px 18px;
            background: rgba(6, 26, 42, 0.82);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            font-size: 12px;
            color: #93adc2;
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
            }
            .main-content {
                padding: 20px 16px;
            }
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="brand-logo">
            <img src="{{ asset('uploads/Bandeng-Gacor.jpeg') }}" alt="Logo Bandeng Samudra">
            <span>WELCOME</span>
        </div>

        <div class="user-profile">
            <svg class="ico" width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 4.2a3.3 3.3 0 1 1-3.3 3.3A3.3 3.3 0 0 1 12 6.2zm0 14.3a7.8 7.8 0 0 1-5.9-2.7c.7-2.2 3.1-3.6 5.9-3.6s5.2 1.4 5.9 3.6a7.8 7.8 0 0 1-5.9 2.7z"/>
            </svg>
            <strong>Kurir</strong>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ url('/karyawan/beranda') }}">
                    <svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 3.2 2.5 11.5h2.7v9.3h5.4v-6h2.8v6h5.4v-9.3h2.7L12 3.2z"/>
                    </svg>
                    <span>Beranda</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/karyawan/konfirmasi') }}">
                    <svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                        <path d="m3 7 9 6 9-6"/>
                    </svg>
                    <span>Konfirmasi Pengiriman</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/karyawan/data') }}">
                    <svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="16" rx="2"/>
                        <path d="M8 16v-4M12 16V9M16 16v-2"/>
                    </svg>
                    <span>Data Pengiriman</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/karyawan/riwayat') }}" class="active">
                    <svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 12a9 9 0 1 0 3-6.7L3 8"/>
                        <path d="M3 3v5h5M12 7v5l3 2"/>
                    </svg>
                    <span>Riwayat Pengiriman</span>
                </a>
            </li>
        </ul>

        <a href="{{ url('/logout') }}" class="logout-btn">
            <svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                <polyline points="16 17 21 12 16 7"/>
                <line x1="21" y1="12" x2="9" y2="12"/>
            </svg>
            <span>Logout</span>
        </a>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <div class="header-section">
            <h1>Riwayat Pengiriman</h1>
            <p>Daftar paket yang telah selesai dikirim berdasarkan nomor, wilayah, dan alamat.</p>
        </div>

        <div class="stats-row">
            <div class="stat-box">
                <span>Total Selesai</span>
                <strong>{{ $totalSelesai ?? 0 }}</strong>
            </div>
            <div class="stat-box">
                <span>Penyelesaian Bulan Ini</span>
                <strong>{{ $penyelesaianBulanIni ?? 0 }}</strong>
            </div>
        </div>

        <div class="filter-card">
            <form action="{{ route('karyawan.riwayat') }}" method="GET" class="filter-form">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Pengiriman, Wilayah, atau Alamat...">

                <select name="wilayah">
                    <option value="">Semua Wilayah</option>
                    @foreach (($daftarWilayah ?? \App\Models\Dikirim::daftarWilayah()) as $wilayahOpsi)
                        <option value="{{ $wilayahOpsi }}" {{ request('wilayah') === $wilayahOpsi ? 'selected' : '' }}>
                            {{ $wilayahOpsi }}
                        </option>
                    @endforeach
                </select>

                <input type="month" name="bulan" value="{{ request('bulan', $bulanDipilih ?? '') }}">

                <button type="submit" class="btn-filter">Filter</button>
                <a href="{{ route('karyawan.riwayat') }}" class="btn-reset">Reset</a>
            </form>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NO. PENGIRIMAN</th>
                        <th>PENERIMA</th>
                        <th>WILAYAH</th>
                        <th>ALAMAT</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayat ?? [] as $index => $item)
                        @php
                            $penerima = $item->transaksi->customer->nama_customer
                                ?? $item->transaksi->customer->nama
                                ?? '-';
                            $alamat = $item->alamat_pengiriman ?? '-';

                            if (!empty($item->wilayah)) {
                                $wilayahTampil = trim($item->wilayah);
                            } elseif ($alamat !== '' && $alamat !== '-') {
                                $teksAlamat = strtolower($alamat);
                                $mapWilayah = [
                                    'Temanggung / Parakan / Bulu (Rp 7.000)'            => ['temanggung', 'parakan', 'bulu'],
                                    'Kedu / Kranggan / Tlogomulyo (Rp 10.000)'           => ['kedu', 'kranggan', 'tlogomulyo'],
                                    'Ngadirejo / Selopampang / Pringsurat (Rp 15.000)' => ['ngadirejo', 'selopampang', 'pringsurat'],
                                    'Candiroto / Kaloran / Jumo (Rp 18.000)'           => ['candiroto', 'kaloran', 'jumo'],
                                    'Tretep / Bejen / Gemawang / Wonoboyo (Rp 25.000)' => ['tretep', 'bejen', 'gemawang', 'wonoboyo'],
                                ];
                                $wilayahTampil = 'Luar Kab. Temanggung via J&T (Rp 20.000)';
                                foreach ($mapWilayah as $label => $keywords) {
                                    foreach ($keywords as $kw) {
                                        if (str_contains($teksAlamat, $kw)) {
                                            $wilayahTampil = $label;
                                            break 2;
                                        }
                                    }
                                }
                            } else {
                                $wilayahTampil = '-';
                            }

                            $noUrut = method_exists($riwayat, 'firstItem')
                                ? ($riwayat->firstItem() + $index)
                                : ($index + 1);
                        @endphp
                        <tr>
                            <td>{{ $noUrut }}</td>
                            <td><strong>#{{ $item->no_pengiriman }}</strong></td>
                            <td>{{ $penerima }}</td>
                            <td>
                                @if ($wilayahTampil !== '-')
                                    <span class="wilayah-badge">{{ $wilayahTampil }}</span>
                                @else
                                    <span style="color:#93adc2;">-</span>
                                @endif
                            </td>
                            <td>{{ $alamat }}</td>
                            <td><span class="status-done">{{ $item->status_pengiriman ?? 'Terkirim' }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; color:#93adc2;">Belum ada riwayat pengiriman selesai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="table-footer">
                <div>Menampilkan {{ method_exists($riwayat, 'count') ? $riwayat->count() : count($riwayat ?? []) }} data</div>
                <div>
                    @if (method_exists($riwayat, 'links'))
                        {{ $riwayat->links() }}
                    @endif
                </div>
            </div>
        </div>

    </main>
</body>
</html>