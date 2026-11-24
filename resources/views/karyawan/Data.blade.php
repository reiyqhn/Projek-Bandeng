<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengiriman - Bandeng Samudra</title>
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

        .alert-success {
            background: rgba(16, 185, 129, 0.18);
            border: 1px solid #34d399;
            color: #d1fae5;
            padding: 10px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 13px;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.18);
            border: 1px solid #f87171;
            color: #fee2e2;
            padding: 10px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 13px;
        }

        /* HEADER */
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .header-title h1 {
            font-size: 28px;
            font-weight: 700;
            line-height: 1.25;
            color: #ffffff;
            margin-bottom: 4px;
        }

        .header-title p {
            color: #93adc2;
            font-size: 13px;
        }

        .header-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-export {
            background: rgba(8, 52, 72, 0.75);
            color: #ffffff;
            border: 1px solid rgba(56, 189, 248, 0.42);
            padding: 10px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            cursor: pointer;
        }

        .btn-tambah {
            background: linear-gradient(90deg, #0d9488 0%, #10b981 100%);
            color: #ffffff;
            border: 1px solid rgba(110, 231, 183, 0.45);
            padding: 10px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            cursor: pointer;
        }

        /* STATS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(150px, 1fr));
            gap: 14px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: rgba(6, 28, 45, 0.72);
            border: 1px solid rgba(56, 189, 248, 0.24);
            border-radius: 12px;
            padding: 14px 16px;
        }

        .stat-card span {
            font-size: 12px;
            color: #93adc2;
            display: block;
            margin-bottom: 4px;
        }

        .stat-card strong {
            font-size: 22px;
            color: #ffffff;
        }

        /* FORM TAMBAH */
        .form-tambah-card {
            display: none;
            background: rgba(6, 28, 45, 0.88);
            border: 1px solid rgba(45, 212, 191, 0.36);
            border-radius: 14px;
            padding: 18px;
            margin-bottom: 20px;
        }

        .form-tambah-card.show {
            display: block;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 12px;
            margin-bottom: 12px;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            color: #cbd5e1;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 9px 12px;
            background: rgba(3, 18, 30, 0.9);
            border: 1px solid rgba(125, 211, 252, 0.25);
            border-radius: 8px;
            color: #ffffff;
            font-size: 13px;
        }

        /* FILTER CARD */
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

        /* TABLE */
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

        .status-pill {
            display: inline-block;
            padding: 4px 11px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 500;
            background: rgba(14, 116, 144, 0.28);
            color: #7dd3fc;
            border: 1px solid rgba(56, 189, 248, 0.35);
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

        @media (max-width: 900px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
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
                <a href="{{ url('/karyawan/data') }}" class="active">
                    <svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="16" rx="2"/>
                        <path d="M8 16v-4M12 16V9M16 16v-2"/>
                    </svg>
                    <span>Data Pengiriman</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/karyawan/riwayat') }}">
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

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <div class="header-section">
            <div class="header-title">
                <h1>Data Pengiriman</h1>
                <p>Kelola seluruh data manifes, wilayah pengiriman, dan status paket.</p>
            </div>

            <div class="header-actions">
                <a href="{{ url('/karyawan/export') . (request()->query() ? '?' . http_build_query(request()->query()) : '') }}" class="btn-export">Export CSV</a>
                <button type="button" class="btn-tambah" onclick="toggleFormTambah()">+ Tambah Pengiriman</button>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <span>Total Manifes</span>
                <strong>{{ $totalManifes ?? 0 }}</strong>
            </div>
            <div class="stat-card">
                <span>Diproses</span>
                <strong>{{ $totalDiproses ?? 0 }}</strong>
            </div>
            <div class="stat-card">
                <span>Di Perjalanan</span>
                <strong>{{ $totalDikirim ?? 0 }}</strong>
            </div>
            <div class="stat-card">
                <span>Terkirim</span>
                <strong>{{ $totalSelesai ?? 0 }}</strong>
            </div>
        </div>

        <!-- FORM TAMBAH PENGIRIMAN -->
        <div class="form-tambah-card {{ $errors->any() ? 'show' : '' }}" id="formTambahCard">
            <form action="{{ url('/karyawan/data') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label>No. Pengiriman</label>
                        <input type="text" name="no_pengiriman" value="{{ old('no_pengiriman') }}" placeholder="Contoh: M-008" required>
                    </div>

                    <div class="form-group">
                        <label>Wilayah Pengiriman</label>
                        <select name="wilayah">
                            <option value="">Otomatis dari Alamat / Pilih Wilayah</option>
                            @foreach (($daftarWilayah ?? \App\Models\Dikirim::daftarWilayah()) as $wilayahOpsi)
                                <option value="{{ $wilayahOpsi }}" {{ old('wilayah') === $wilayahOpsi ? 'selected' : '' }}>
                                    {{ $wilayahOpsi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Alamat Pengiriman</label>
                        <input type="text" name="alamat_pengiriman" value="{{ old('alamat_pengiriman') }}" placeholder="Contoh: Jl. Pemuda No. 10, Parakan" required>
                    </div>

                    <div class="form-group">
                        <label>Status Pengiriman</label>
                        <select name="status_pengiriman" required>
                            <option value="Diproses" {{ old('status_pengiriman') === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Di Perjalanan" {{ old('status_pengiriman') === 'Di Perjalanan' ? 'selected' : '' }}>Di Perjalanan</option>
                            <option value="Terkirim" {{ old('status_pengiriman') === 'Terkirim' ? 'selected' : '' }}>Terkirim</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn-tambah">Simpan Data</button>
            </form>
        </div>

        <!-- FILTER CARD -->
        <div class="filter-card">
            <form action="{{ url('/karyawan/data') }}" method="GET" class="filter-form">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Pengiriman, Wilayah, atau Alamat...">

                <select name="wilayah">
                    <option value="">Semua Wilayah</option>
                    @foreach (($daftarWilayah ?? \App\Models\Dikirim::daftarWilayah()) as $wilayahOpsi)
                        <option value="{{ $wilayahOpsi }}" {{ request('wilayah') === $wilayahOpsi ? 'selected' : '' }}>
                            {{ $wilayahOpsi }}
                        </option>
                    @endforeach
                </select>

                <select name="status">
                    <option value="Semua Status">Semua Status</option>
                    <option value="Diproses" {{ request('status') === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Di Perjalanan" {{ request('status') === 'Di Perjalanan' ? 'selected' : '' }}>Di Perjalanan</option>
                    <option value="Terkirim" {{ request('status') === 'Terkirim' ? 'selected' : '' }}>Terkirim</option>
                </select>

                @if (!empty($tanggalTersedia) && count($tanggalTersedia) > 0)
                    <select name="tanggal">
                        <option value="">Semua Tanggal</option>
                        @foreach ($tanggalTersedia as $tgl)
                            <option value="{{ $tgl }}" {{ request('tanggal') === $tgl ? 'selected' : '' }}>{{ $tgl }}</option>
                        @endforeach
                    </select>
                @endif

                <button type="submit" class="btn-filter">Filter</button>
                <a href="{{ url('/karyawan/data') }}" class="btn-reset">Reset</a>
            </form>
        </div>

        <!-- TABEL DATA -->
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
                    @forelse ($pengiriman ?? [] as $index => $item)
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

                            $noUrut = method_exists($pengiriman, 'firstItem')
                                ? ($pengiriman->firstItem() + $index)
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
                            <td><span class="status-pill">{{ $item->status_pengiriman ?? '-' }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; color:#93adc2;">Belum ada data pengiriman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="table-footer">
                <div>Menampilkan {{ method_exists($pengiriman, 'count') ? $pengiriman->count() : count($pengiriman ?? []) }} data</div>
                <div>
                    @if (method_exists($pengiriman, 'links'))
                        {{ $pengiriman->links() }}
                    @endif
                </div>
            </div>
        </div>

    </main>

    <script>
        function toggleFormTambah() {
            const el = document.getElementById('formTambahCard');
            if (el) {
                el.classList.toggle('show');
            }
        }
    </script>
</body>
</html>