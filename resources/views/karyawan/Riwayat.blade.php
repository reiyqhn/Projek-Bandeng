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

        /* HEADER */
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 22px;
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
            font-weight: 400;
        }

        .btn-cetak {
            background: rgba(8, 52, 72, 0.75);
            color: #ffffff;
            border: 1px solid rgba(56, 189, 248, 0.42);
            padding: 10px 18px;
            border-radius: 10px;
            font-weight: 500;
            font-size: 13px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 0 14px rgba(14, 165, 233, 0.15);
            transition: all 0.2s ease;
        }

        .btn-cetak:hover {
            border-color: #2dd4bf;
            background: rgba(13, 82, 108, 0.85);
        }

        /* STATS ROW */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 18px;
        }

        .stat-card {
            background: linear-gradient(145deg, rgba(10, 42, 64, 0.76), rgba(5, 23, 37, 0.86));
            border: 1px solid rgba(56, 189, 248, 0.3);
            border-radius: 14px;
            padding: 18px 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.08);
            position: relative;
        }

        .stat-info span {
            font-size: 11px;
            letter-spacing: 0.7px;
            font-weight: 600;
            color: #cbd5e1;
            display: block;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .stat-info h2 {
            font-size: 28px;
            font-weight: 700;
            line-height: 1.15;
            color: #ffffff;
        }

        .stat-icon-check {
            color: #34d399;
        }

        .stat-icon-cal {
            color: #38bdf8;
        }

        .btn-kalender-bulan {
            background: rgba(56, 189, 248, 0.08);
            border: 1px solid rgba(56, 189, 248, 0.25);
            border-radius: 10px;
            padding: 6px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .btn-kalender-bulan:hover {
            background: rgba(20, 184, 166, 0.18);
            border-color: #2dd4bf;
        }

        /* SEARCH BAR */
        .search-card {
            background: rgba(6, 28, 45, 0.72);
            border: 1px solid rgba(56, 189, 248, 0.26);
            border-radius: 14px;
            padding: 13px 15px;
            margin-bottom: 20px;
        }

        .search-form {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .search-input-wrap {
            flex-grow: 1;
            position: relative;
        }

        .search-input-wrap .search-ico {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #7e96ab;
            pointer-events: none;
        }

        .search-input-wrap input {
            width: 100%;
            padding: 10px 14px 10px 40px;
            background: rgba(3, 18, 30, 0.85);
            border: 1px solid rgba(125, 211, 252, 0.22);
            border-radius: 9px;
            color: #ffffff;
            font-size: 13px;
            outline: none;
        }

        .search-input-wrap input::placeholder {
            color: #7e96ab;
        }

        .search-input-wrap input:focus {
            border-color: #2dd4bf;
        }

        .btn-cari {
            background: rgba(11, 56, 78, 0.85);
            color: #ffffff;
            border: 1px solid rgba(56, 189, 248, 0.35);
            padding: 10px 22px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .btn-cari:hover {
            border-color: #2dd4bf;
            background: rgba(13, 82, 108, 0.9);
        }

        /* TABLE CONTAINER */
        .table-card {
            background: rgba(5, 24, 39, 0.76);
            border: 1px solid rgba(45, 212, 191, 0.34);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 0 24px rgba(6, 78, 96, 0.18);
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
            white-space: nowrap;
        }

        td {
            padding: 14px 16px;
            font-size: 13px;
            color: #e2e8f0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
            vertical-align: middle;
        }

        tbody tr:hover {
            background: rgba(255, 255, 255, 0.025);
        }

        .resi-text {
            font-weight: 600;
            color: #ffffff;
            white-space: nowrap;
        }

        .paid-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 500;
            background: rgba(16, 185, 129, 0.16);
            color: #6ee7b7;
            border: 1px solid rgba(52, 211, 153, 0.38);
            white-space: nowrap;
        }

        .status-selesai-text {
            color: #34d399;
            font-weight: 500;
            white-space: nowrap;
        }

        .bukti-btn {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(148, 163, 184, 0.28);
            color: #cbd5e1;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .bukti-btn:hover {
            border-color: #2dd4bf;
            color: #2dd4bf;
        }

        /* FOOTER & PAGINATION */
        .table-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 13px 18px;
            font-size: 12px;
            color: #93adc2;
            background: rgba(6, 26, 42, 0.82);
            flex-wrap: wrap;
            gap: 12px;
        }

        .pagination-group {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .page-btn {
            padding: 5px 12px;
            font-size: 11.5px;
            border-radius: 7px;
            border: 1px solid rgba(255, 255, 255, 0.16);
            background: rgba(255, 255, 255, 0.04);
            color: #cbd5e1;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.18s ease;
        }

        .page-btn:hover:not(.disabled):not(.active) {
            border-color: #2dd4bf;
            color: #ffffff;
        }

        .page-btn.active {
            background: rgba(13, 148, 136, 0.45);
            border-color: #2dd4bf;
            color: #ffffff;
            font-weight: 600;
        }

        .page-btn.disabled {
            opacity: 0.45;
            pointer-events: none;
        }

        /* MODAL BUKTI FOTO */
        .modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.75);
            z-index: 999;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .modal-backdrop.show {
            display: flex;
        }

        .modal-box {
            background: #062337;
            border: 1px solid rgba(45, 212, 191, 0.48);
            border-radius: 12px;
            padding: 20px;
            width: 100%;
            max-width: 420px;
            color: #ffffff;
            text-align: center;
        }

        .modal-box h3 {
            margin-bottom: 12px;
            font-size: 16px;
            font-weight: 600;
        }

        .modal-box img {
            max-width: 100%;
            max-height: 300px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.14);
            margin-bottom: 14px;
        }

        .btn-tutup-modal {
            padding: 8px 18px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.24);
            background: transparent;
            color: #ffffff;
            font-size: 12.5px;
            cursor: pointer;
        }

        @media print {
            .sidebar, .btn-cetak, .search-card, .bukti-btn, .btn-kalender-bulan {
                display: none !important;
            }

            body, .main-content {
                background: #ffffff !important;
                color: #000000 !important;
                padding: 0 !important;
            }

            .stat-card, .table-card {
                background: #ffffff !important;
                border: 1px solid #cbd5e1 !important;
                box-shadow: none !important;
            }

            th, td, .stat-info h2, .stat-info span, .resi-text {
                color: #000000 !important;
            }
        }

        @media (max-width: 820px) {
            .stats-grid {
                grid-template-columns: 1fr;
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

        <!-- HEADER -->
        <div class="header-section">
            <div class="header-title">
                <h1>Riwayat Pengiriman</h1>
                <p>Daftar manifestasi semua paket yang telah sukses diselesaikan kurir.</p>
            </div>

            <button type="button" class="btn-cetak" onclick="window.print()">
                <svg class="ico" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="8" y1="13" x2="16" y2="13"/>
                    <line x1="8" y1="17" x2="16" y2="17"/>
                </svg>
                <span>Cetak Laporan</span>
            </button>
        </div>

        <!-- STATS CARDS -->
        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-info">
                    <span>TOTAL SELESAI DITERIMA</span>
                    <h2>{{ $totalSelesai ?? (isset($riwayat) && method_exists($riwayat, 'total') ? $riwayat->total() : count($riwayat ?? [])) }}</h2>
                </div>
                <svg class="ico stat-icon-check" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9"/>
                    <polyline points="8.5 12.5 11 15 15.8 9.5"/>
                </svg>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <span>
                        PENYELESAIAN BULAN INI
                        @if (!empty($bulanDipilih))
                            ({{ \Carbon\Carbon::createFromFormat('Y-m', $bulanDipilih)->translatedFormat('M Y') }})
                        @endif
                    </span>
                    <h2>{{ $penyelesaianBulanIni ?? $totalSelesai ?? 0 }}</h2>
                </div>

                <button type="button"
                        id="btnKalenderBulan"
                        class="btn-kalender-bulan"
                        title="Pilih Bulan Riwayat">
                    <svg class="ico stat-icon-cal" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="17" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </button>

                <input type="month"
                       id="inputBulanRiwayat"
                       value="{{ $bulanDipilih ?? request('bulan') ?? '' }}"
                       style="position:absolute; opacity:0; pointer-events:none; bottom:8px; right:22px;">
            </div>
        </section>

        <!-- SEARCH BAR -->
        <div class="search-card">
            <form method="GET" action="{{ route('karyawan.riwayat') }}" class="search-form">
                @if (!empty($bulanDipilih) || request()->filled('bulan'))
                    <input type="hidden" name="bulan" value="{{ $bulanDipilih ?? request('bulan') }}">
                @endif
                <div class="search-input-wrap">
                    <svg class="ico search-ico" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Resi Terkirim atau Tujuan...">
                </div>
                <button type="submit" class="btn-cari">Cari</button>
            </form>
        </div>

        <!-- TABEL RIWAYAT -->
        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>NO. RESI</th>
                        <th>TANGGAL KIRIM</th>
                        <th>WAKTU SAMPAI</th>
                        <th>PENERIMA</th>
                        <th>STATUS PEMBAYARAN</th>
                        <th>STATUS PAKET</th>
                        <th>BUKTI FOTO</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayat ?? [] as $item)
                        @php
                            $penerima = $item->transaksi->customer->nama_customer
                                ?? $item->transaksi->customer->nama
                                ?? '-';
                            $tglKirim = $item->created_at
                                ? $item->created_at->translatedFormat('d M Y')
                                : now()->translatedFormat('d M Y');
                            $waktuSampai = $item->updated_at
                                ? $item->updated_at->format('H:i') . ' WIB'
                                : now()->format('H:i') . ' WIB';
                            $statusBayar = $item->transaksi->status_pembayaran
                                ?? $item->transaksi->status
                                ?? 'Paid Online';
                            $buktiFoto = $item->bukti_foto ?? $item->foto_bukti ?? null;
                        @endphp
                        <tr>
                            <td class="resi-text">#{{ $item->no_pengiriman }}</td>
                            <td>{{ $tglKirim }}</td>
                            <td>{{ $waktuSampai }}</td>
                            <td>{{ $penerima }}</td>
                            <td>
                                <span class="paid-pill">
                                    <svg class="ico" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <circle cx="12" cy="12" r="9"/>
                                        <polyline points="8.5 12.5 11 15 15.8 9.5"/>
                                    </svg>
                                    <span>{{ $statusBayar }}</span>
                                </span>
                            </td>
                            <td class="status-selesai-text">Selesai</td>
                            <td>
                                <button type="button"
                                        class="bukti-btn"
                                        title="Lihat Bukti Foto"
                                        onclick="lihatBukti('{{ $item->no_pengiriman }}', '{{ $buktiFoto ? asset('uploads/' . ltrim($buktiFoto, '/')) : '' }}')">
                                    <svg class="ico" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                                        <circle cx="8.5" cy="8.5" r="1.5"/>
                                        <polyline points="21 15 16 10 5 21"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center; color:#93adc2;">Belum ada riwayat pengiriman selesai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- PAGINATION -->
            <div class="table-footer">
                @if (isset($riwayat) && method_exists($riwayat, 'total'))
                    <div>Menampilkan {{ $riwayat->firstItem() ?? 0 }}-{{ $riwayat->lastItem() ?? 0 }} dari {{ $riwayat->total() }} riwayat selesai</div>
                    <div class="pagination-group">
                        @if ($riwayat->onFirstPage())
                            <span class="page-btn disabled">Sebelumnya</span>
                        @else
                            <a href="{{ $riwayat->appends(request()->query())->previousPageUrl() }}" class="page-btn">Sebelumnya</a>
                        @endif

                        @for ($i = 1; $i <= $riwayat->lastPage(); $i++)
                            <a href="{{ $riwayat->appends(request()->query())->url($i) }}"
                               class="page-btn {{ $riwayat->currentPage() == $i ? 'active' : '' }}">{{ $i }}</a>
                        @endfor

                        @if ($riwayat->hasMorePages())
                            <a href="{{ $riwayat->appends(request()->query())->nextPageUrl() }}" class="page-btn">Selanjutnya</a>
                        @else
                            <span class="page-btn disabled">Selanjutnya</span>
                        @endif
                    </div>
                @else
                    @php $jumlahRow = count($riwayat ?? []); @endphp
                    <div>Menampilkan {{ $jumlahRow > 0 ? '1-' . $jumlahRow : '0' }} dari {{ $jumlahRow }} riwayat selesai</div>
                    <div class="pagination-group">
                        <span class="page-btn disabled">Sebelumnya</span>
                        <span class="page-btn active">1</span>
                        <span class="page-btn disabled">Selanjutnya</span>
                    </div>
                @endif
            </div>
        </div>

    </main>

    <!-- MODAL BUKTI FOTO -->
    <div id="modalBukti" class="modal-backdrop">
        <div class="modal-box">
            <h3 id="judulBukti">Bukti Foto Pengiriman</h3>
            <div id="kontenBukti"></div>
            <button type="button" class="btn-tutup-modal" onclick="tutupBukti()">Tutup</button>
        </div>
    </div>

    <script>
        function lihatBukti(resi, urlFoto) {
            document.getElementById('judulBukti').textContent = 'Bukti Foto #' + resi;
            const konten = document.getElementById('kontenBukti');
            if (urlFoto) {
                konten.innerHTML = '<img src="' + urlFoto + '" alt="Bukti Foto">';
            } else {
                konten.innerHTML = '<p style="color:#93adc2; font-size:13px; margin:14px 0 18px;">Belum ada file bukti foto untuk pengiriman ini.</p>';
            }
            document.getElementById('modalBukti').classList.add('show');
        }

        function tutupBukti() {
            document.getElementById('modalBukti').classList.remove('show');
        }

        document.getElementById('modalBukti').addEventListener('click', function (e) {
            if (e.target === this) {
                tutupBukti();
            }
        });

        (function () {
            const btnKalender = document.getElementById('btnKalenderBulan');
            const inputBulan = document.getElementById('inputBulanRiwayat');
            const searchForm = document.querySelector('.search-form');

            if (btnKalender && inputBulan && searchForm) {
                btnKalender.addEventListener('click', function () {
                    if (typeof inputBulan.showPicker === 'function') {
                        inputBulan.showPicker();
                    } else {
                        inputBulan.click();
                    }
                });

                inputBulan.addEventListener('change', function () {
                    let hiddenBulan = searchForm.querySelector('input[name="bulan"]');
                    if (!hiddenBulan) {
                        hiddenBulan = document.createElement('input');
                        hiddenBulan.type = 'hidden';
                        hiddenBulan.name = 'bulan';
                        searchForm.appendChild(hiddenBulan);
                    }
                    hiddenBulan.value = inputBulan.value;
                    searchForm.submit();
                });
            }
        })();
    </script>
</body>
</html>