<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pengiriman - Bandeng Samudra</title>
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

        .btn-konfirmasi-semua {
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

        .btn-konfirmasi-semua:hover {
            border-color: #2dd4bf;
            background: rgba(13, 82, 108, 0.85);
        }

        /* FILTER CARD */
        .filter-card {
            background: rgba(6, 28, 45, 0.72);
            border: 1px solid rgba(56, 189, 248, 0.26);
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 20px;
        }

        .filter-bar {
            display: flex;
            gap: 14px;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-box {
            flex-grow: 1;
            position: relative;
            min-width: 240px;
        }

        .search-box .search-ico {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #7e96ab;
            pointer-events: none;
        }

        .search-box input {
            width: 100%;
            padding: 10px 14px 10px 40px;
            background: rgba(3, 18, 30, 0.85);
            border: 1px solid rgba(125, 211, 252, 0.22);
            border-radius: 9px;
            color: #ffffff;
            font-size: 13px;
            outline: none;
        }

        .search-box input::placeholder {
            color: #7e96ab;
        }

        .search-box input:focus,
        .wilayah-select select:focus {
            border-color: #2dd4bf;
        }

        .wilayah-select select {
            min-width: 165px;
            padding: 10px 14px;
            background: rgba(3, 18, 30, 0.85);
            border: 1px solid rgba(125, 211, 252, 0.22);
            border-radius: 9px;
            color: #e2e8f0;
            font-size: 13px;
            outline: none;
            cursor: pointer;
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
            padding: 14px 18px;
            font-size: 11px;
            font-weight: 600;
            color: #cbd5e1;
            letter-spacing: 0.7px;
            text-transform: uppercase;
            border-bottom: 1px solid rgba(56, 189, 248, 0.2);
        }

        td {
            padding: 15px 18px;
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
        }

        /* STATUS PILLS */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 11px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 500;
        }

        .status-pill .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .pill-dikirim {
            background: rgba(14, 116, 144, 0.28);
            color: #7dd3fc;
            border: 1px solid rgba(56, 189, 248, 0.35);
        }

        .pill-dikirim .dot {
            background: #38bdf8;
        }

        .pill-diproses {
            background: rgba(161, 98, 7, 0.28);
            color: #fde047;
            border: 1px solid rgba(250, 204, 21, 0.35);
        }

        .pill-diproses .dot {
            background: #facc15;
        }

        /* ACTION BUTTON */
        .btn-selesai-kirim {
            background: linear-gradient(90deg, #0d9488 0%, #10b981 100%);
            color: #ffffff;
            border: 1px solid rgba(110, 231, 183, 0.45);
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 0 12px rgba(16, 185, 129, 0.24);
            transition: all 0.2s ease;
        }

        .btn-selesai-kirim:hover {
            filter: brightness(1.08);
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
                <a href="{{ url('/karyawan/konfirmasi') }}" class="active">
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

        <!-- HEADER -->
        <div class="header-section">
            <div class="header-title">
                <h1>Konfirmasi Pengiriman</h1>
                <p>Perbarui status paket yang telah berhasil Anda kirim ke penerima.</p>
            </div>

            <form action="{{ route('karyawan.semuaSelesai') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn-konfirmasi-semua">
                    <svg class="ico" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>Konfirmasi Semua Paket</span>
                </button>
            </form>
        </div>

        <!-- FILTER BAR -->
        <div class="filter-card">
            <div class="filter-bar">
                <div class="search-box">
                    <svg class="ico search-ico" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" id="filterSearch" value="{{ request('nomor') }}" placeholder="Cari berdasarkan No. Pengiriman atau Nama Penerima...">
                </div>

                <div class="wilayah-select">
                    <select id="filterWilayah">
                        <option value="">Semua Wilayah</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- TABEL KONFIRMASI -->
        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NO. PENGIRIMAN</th>
                        <th>PENERIMA</th>
                        <th>ALAMAT / WILAYAH</th>
                        <th>STATUS SAAT INI</th>
                        <th>AKSI KONFIRMASI</th>
                    </tr>
                </thead>
                <tbody id="tabelKonfirmasiBody">
                    @forelse ($pengiriman ?? [] as $index => $item)
                        @php
                            $statusRaw = $item->status_pengiriman ?? 'Diproses';
                            $isDikirim = in_array($statusRaw, ['Di Perjalanan', 'Sedang Dikirim', 'Dikirim']);
                            $pillClass = $isDikirim ? 'pill-dikirim' : 'pill-diproses';
                            $statusLabel = $isDikirim ? 'Sedang Dikirim' : 'Baru Diproses';
                            $penerima = $item->transaksi->customer->nama_customer
                                ?? $item->transaksi->customer->nama
                                ?? '-';
                            $alamat = $item->alamat_pengiriman ?? '-';
                        @endphp
                        <tr class="row-paket"
                            data-search="{{ strtolower(($item->no_pengiriman ?? '') . ' ' . $penerima . ' ' . $alamat) }}"
                            data-wilayah="{{ trim($alamat) }}">
                            <td>{{ $index + 1 }}</td>
                            <td class="resi-text">#{{ $item->no_pengiriman }}</td>
                            <td>{{ $penerima }}</td>
                            <td>{{ $alamat }}</td>
                            <td>
                                <span class="status-pill {{ $pillClass }}">
                                    <span class="dot"></span>
                                    <span>{{ $statusLabel }}</span>
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('karyawan.prosesSelesai', $item->no_pengiriman) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-selesai-kirim">
                                        <svg class="ico" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                            <polyline points="20 6 9 17 4 12"/>
                                        </svg>
                                        <span>Selesai Dikirim</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr id="rowKosongServer">
                            <td colspan="6" style="text-align:center; color:#93adc2;">Tidak ada paket yang menunggu konfirmasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="table-footer">
                <div id="infoJumlahData">Menampilkan {{ count($pengiriman ?? []) }} data paket</div>
                <div class="pagination-group">
                    <span class="page-btn disabled">Sebelumnya</span>
                    <span class="page-btn active">1</span>
                    <span class="page-btn disabled">Selanjutnya</span>
                </div>
            </div>
        </div>

    </main>

    <script>
        (function () {
            const searchInput = document.getElementById('filterSearch');
            const wilayahSelect = document.getElementById('filterWilayah');
            const rows = Array.from(document.querySelectorAll('#tabelKonfirmasiBody .row-paket'));
            const infoText = document.getElementById('infoJumlahData');

            // Isi opsi wilayah unik dari data baris
            const wilayahSet = new Set();
            rows.forEach(function (row) {
                const w = (row.getAttribute('data-wilayah') || '').trim();
                if (w && w !== '-') {
                    wilayahSet.add(w);
                }
            });

            Array.from(wilayahSet).sort().forEach(function (w) {
                const opt = document.createElement('option');
                opt.value = w.toLowerCase();
                opt.textContent = w;
                wilayahSelect.appendChild(opt);
            });

            function terapkanFilter() {
                const keyword = (searchInput.value || '').trim().toLowerCase();
                const selectedWilayah = (wilayahSelect.value || '').trim().toLowerCase();
                let tampil = 0;

                rows.forEach(function (row, idx) {
                    const searchData = row.getAttribute('data-search') || '';
                    const wilayahData = (row.getAttribute('data-wilayah') || '').toLowerCase();

                    const cocokSearch = !keyword || searchData.includes(keyword);
                    const cocokWilayah = !selectedWilayah || wilayahData === selectedWilayah;

                    if (cocokSearch && cocokWilayah) {
                        row.style.display = '';
                        tampil++;
                        const noCell = row.querySelector('td:first-child');
                        if (noCell) noCell.textContent = tampil;
                    } else {
                        row.style.display = 'none';
                    }
                });

                const totalAwal = rows.length;
                if (totalAwal === 0) {
                    infoText.textContent = 'Menampilkan 0 data paket';
                } else if (tampil === totalAwal) {
                    infoText.textContent = 'Menampilkan 1-' + totalAwal + ' dari ' + totalAwal + ' data paket';
                } else {
                    infoText.textContent = 'Menampilkan ' + tampil + ' dari ' + totalAwal + ' data paket';
                }
            }

            if (searchInput && wilayahSelect && rows.length > 0) {
                searchInput.addEventListener('input', terapkanFilter);
                wilayahSelect.addEventListener('change', terapkanFilter);
                if (searchInput.value.trim() !== '') {
                    terapkanFilter();
                } else {
                    infoText.textContent = 'Menampilkan 1-' + rows.length + ' dari ' + rows.length + ' data paket';
                }
            }
        })();
    </script>
</body>
</html>