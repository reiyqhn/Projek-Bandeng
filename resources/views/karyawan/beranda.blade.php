<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Karyawan - Bandeng Samudra</title>

    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <style>
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #031c2b;
            color: white;
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
            background:
                radial-gradient(circle at 75% 20%, rgba(0, 225, 220, 0.18), transparent 35%),
                linear-gradient(135deg, #061b2c, #003b4b, #031522);
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: rgba(13, 48, 77, 0.96);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            border-right: 1px solid rgba(255,255,255,0.1);
        }

        .logo-area {
            height: 135px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 15px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .logo-area img {
            width: 85px;
            height: 85px;
            object-fit: contain;
            border-radius: 50%;
        }

        .logo-area h2 {
            font-size: 23px;
            font-weight: 700;
            color: white;
            text-shadow: 0 0 15px #00e5ff;
        }

        .profile {
            padding: 18px 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 17px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .profile i {
            font-size: 32px;
        }

        .menu {
            padding: 22px 14px;
            flex: 1;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 13px;
            color: #e8f5ff;
            text-decoration: none;
            padding: 13px 16px;
            margin-bottom: 10px;
            border-radius: 30px;
            font-size: 15px;
            transition: 0.3s;
        }

        .menu a i {
            width: 22px;
            font-size: 19px;
        }

        .menu a:hover,
        .menu a.active {
            background: linear-gradient(90deg, #087d85, #10c7bb);
            box-shadow: 0 0 18px rgba(0, 238, 225, 0.5);
            color: white;
        }

        .logout {
            padding: 25px;
        }

        .logout a {
            color: white;
            text-decoration: none;
            font-size: 15px;
        }

        .logout i {
            margin-right: 12px;
        }

        /* KONTEN UTAMA */
        .main-content {
            flex: 1;
            padding: 30px;
            min-width: 0;
        }

        .alert-success {
            background: rgba(8, 123, 88, 0.35);
            border: 1px solid #2ee59d;
            color: #c7ffea;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        /* KARTU STATISTIK */
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            min-height: 175px;
            padding: 22px 20px;
            border: 1px solid rgba(177, 236, 255, 0.55);
            border-radius: 17px;
            background: rgba(255,255,255,0.10);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            backdrop-filter: blur(8px);
        }

        .stat-card h3 {
            font-size: 19px;
            margin-bottom: 18px;
        }

        .stat-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stat-icon {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            background: rgba(131, 225, 230, 0.2);
            border: 1px solid rgba(165, 245, 255, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            color: #e5ffff;
        }

        .stat-number {
            font-size: 37px;
            font-weight: 700;
        }

        .stat-info p {
            font-size: 14px;
        }

        /* BAGIAN BAWAH */
        .content-grid {
            display: grid;
            grid-template-columns: 1.65fr 1fr;
            gap: 22px;
        }

        .panel {
            background: rgba(0, 20, 30, 0.45);
            border: 1px solid rgba(83, 232, 214, 0.75);
            border-radius: 17px;
            padding: 22px;
            box-shadow: 0 0 12px rgba(0, 220, 200, 0.12);
        }

        .panel h2 {
            font-size: 19px;
            margin-bottom: 17px;
        }

        .panel-line {
            border: none;
            border-top: 1px solid rgba(255,255,255,0.25);
            margin-bottom: 15px;
        }

        /* DAFTAR PENGIRIMAN */
        .delivery-item {
            display: grid;
            grid-template-columns: 1.1fr 0.8fr auto;
            align-items: center;
            gap: 12px;
            padding: 16px 0;
            border-bottom: 1px solid rgba(255,255,255,0.25);
        }

        .delivery-item strong {
            font-size: 14px;
        }

        .delivery-item p {
            font-size: 13px;
            color: #d2e4eb;
        }

        .btn-confirm {
            border: 1px solid #70e4ca;
            background: #248d7e;
            color: white;
            padding: 10px 15px;
            border-radius: 10px;
            cursor: pointer;
            font-family: inherit;
            font-size: 13px;
            transition: 0.3s;
        }

        .btn-confirm:hover {
            background: #10bca9;
            box-shadow: 0 0 12px #10c7bb;
        }

        .status {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 12px;
            margin-top: 4px;
        }

        .diproses {
            background: #887326;
            color: #ffe783;
        }

        .di-perjalanan {
            background: #244b78;
            color: #9ecaff;
        }

        .selesai {
            background: #087b58;
            color: #a6ffda;
        }

        .lihat-semua {
            display: inline-block;
            margin-top: 20px;
            color: #45d9e4;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        /* BAGIAN KANAN */
        .right-content {
            display: flex;
            flex-direction: column;
            gap: 22px;
        }

        .quick-confirm {
            border-color: rgba(55, 156, 255, 0.7);
            box-shadow: 0 0 17px rgba(0, 132, 255, 0.2);
        }

        .quick-confirm label {
            display: block;
            color: #bdcbd6;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .quick-confirm input {
            width: 100%;
            padding: 13px;
            background: rgba(0, 20, 40, 0.6);
            border: 1px solid #42647c;
            border-radius: 10px;
            color: white;
            outline: none;
            font-family: inherit;
        }

        .quick-confirm input:focus {
            border-color: #16d9ed;
        }

        .btn-submit {
            width: 100%;
            margin-top: 18px;
            padding: 13px;
            background: linear-gradient(90deg, #00a7cb, #20c9e0);
            border: 1px solid #4deaff;
            border-radius: 11px;
            color: #03283a;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            font-family: inherit;
            box-shadow: 0 0 15px rgba(0, 220, 255, 0.35);
        }

        .btn-submit:hover {
            background: #55eaff;
        }

        /* STATUS PENGIRIMAN */
        .status-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
        }

        .yellow {
            background: #776522;
            color: #ffe68b;
        }

        .blue {
            background: #244b78;
            color: #9ecaff;
        }

        .green {
            background: #087653;
            color: #a8ffdc;
        }

        /* RESPONSIVE */
        @media (max-width: 1000px) {
            .sidebar {
                width: 220px;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 650px) {
            .dashboard {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                min-height: auto;
            }

            .logo-area {
                height: 100px;
            }

            .menu {
                display: flex;
                overflow-x: auto;
                padding: 10px;
            }

            .menu a {
                white-space: nowrap;
            }

            .logout {
                padding: 10px 20px;
            }

            .main-content {
                padding: 15px;
            }

            .delivery-item {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="dashboard">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="logo-area">
            <img src="{{ asset('uploads/Bandeng-Gacor.jpeg') }}"
                 alt="Logo Bandeng Samudra">

            <h2>WELCOME</h2>
        </div>

        <div class="profile">
            <i class="fas fa-circle-user"></i>
            <span>Bellarmine</span>
        </div>

        <nav class="menu">
            <a href="{{ url('/karyawan/beranda') }}" class="active">
                <i class="fas fa-house"></i>
                Dashboard
            </a>

            <a href="{{ url('/karyawan/konfirmasi') }}">
                <i class="far fa-square-check"></i>
                Konfirmasi Pengiriman
            </a>

            <a href="{{ url('/karyawan/data') }}">
                <i class="fas fa-box"></i>
                Data Pengiriman
            </a>

            <a href="{{ url('/karyawan/riwayat') }}">
                <i class="fas fa-clock-rotate-left"></i>
                Riwayat Pengiriman
            </a>
        </nav>

        <div class="logout">
            <a href="{{ url('/logout') }}">
                <i class="fas fa-right-from-bracket"></i>
                Logout
            </a>
        </div>

    </aside>


    <!-- KONTEN UTAMA -->
    <main class="main-content">

        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- KARTU STATISTIK -->
        <section class="stats">

            <div class="stat-card">
                <h3>Tugas Hari Ini</h3>

                <div class="stat-info">
                    <div class="stat-icon">
                        <i class="fas fa-user"></i>
                    </div>

                    <div>
                        <div class="stat-number">{{ $totalTugas ?? 0 }}</div>
                        <p>Pengiriman</p>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <h3>Dalam Proses</h3>

                <div class="stat-info">
                    <div class="stat-icon">
                        <i class="fas fa-truck"></i>
                    </div>

                    <div>
                        <div class="stat-number">{{ $dalamProses ?? 0 }}</div>
                        <p>Pengiriman</p>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <h3>Selesai</h3>

                <div class="stat-info">
                    <div class="stat-icon">
                        <i class="fas fa-certificate"></i>
                    </div>

                    <div>
                        <div class="stat-number">{{ $selesai ?? 0 }}</div>
                        <p>Pengiriman</p>
                    </div>
                </div>
            </div>

        </section>


        <!-- BAGIAN PENGIRIMAN DAN KONFIRMASI -->
        <section class="content-grid">

            <!-- PENGIRIMAN HARI INI -->
            <div class="panel">

                <h2>Pengiriman Hari Ini</h2>
                <hr class="panel-line">

                @forelse ($pengiriman as $item)
                    @php
                        $noKirim = $item->no_pengiriman ?? ($item['nomor'] ?? '');
                        $alamat  = $item->alamat_pengiriman ?? ($item['alamat'] ?? '-');
                        $status  = $item->status_pengiriman ?? ($item['status'] ?? '');
                        $namaCus = $item->transaksi->customer->nama_customer
                            ?? $item->transaksi->customer->nama
                            ?? ($item['nama'] ?? '-');
                    @endphp

                    <div class="delivery-item">

                        <div>
                            <strong>#{{ $noKirim }}</strong>
                            <p>{{ $alamat }}</p>

                            @if ($status)
                                @php
                                    $kelasStatus = match ($status) {
                                        'Terkirim', 'Selesai' => 'selesai',
                                        'Di Perjalanan', 'Dikirim' => 'di-perjalanan',
                                        default => 'diproses',
                                    };
                                @endphp
                                <span class="status {{ $kelasStatus }}">
                                    {{ $status }}
                                </span>
                            @endif
                        </div>

                        <div>
                            <strong>{{ $namaCus }}</strong>
                            <p>-</p>
                        </div>

                        @if ($status !== 'Terkirim')
                            <form action="{{ route('karyawan.prosesSelesai', $noKirim) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-confirm">
                                    Konfirmasi
                                </button>
                            </form>
                        @else
                            <span class="status selesai">Terkirim</span>
                        @endif

                    </div>
                @empty
                    <p style="padding: 12px 0; color: #b8d6df;">Belum ada data pengiriman.</p>
                @endforelse

                <a href="{{ url('/karyawan/data') }}"
                   class="lihat-semua">
                    Lihat Semua
                </a>

            </div>


            <!-- BAGIAN KANAN -->
            <div class="right-content">

                <!-- KONFIRMASI CEPAT -->
                <div class="panel quick-confirm">

                    <h2>Konfirmasi Cepat</h2>

                    <form action="{{ url('/karyawan/konfirmasi') }}"
                          method="GET">

                        <label>Masukkan No. Pengiriman</label>

                        <input type="text"
                               name="nomor"
                               placeholder="Contoh: KRM240524001"
                               required>

                        <button type="submit" class="btn-submit">
                            Konfirmasi Dikirim
                        </button>

                    </form>

                </div>


                <!-- STATUS PENGIRIMAN -->
                <div class="panel">

                    <h2>Status Pengiriman</h2>

                    <div class="status-list">

                        <span class="status-badge yellow">
                            ● Diproses
                        </span>

                        <span class="status-badge blue">
                            ● Dikirim
                        </span>

                        <span class="status-badge green">
                            ● Selesai
                        </span>

                    </div>

                </div>

            </div>

        </section>

    </main>

</div>

</body>
</html>