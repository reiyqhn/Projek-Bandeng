<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Master Pengiriman - Bandeng Samudra</title>
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
            background: linear-gradient(180deg, #031c2c 0%, #02131f 100%);
            padding: 18px 14px;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(56, 189, 248, 0.14);
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
            width: 58px;
            height: 58px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid rgba(45, 212, 191, 0.45);
            box-shadow: 0 0 12px rgba(45, 212, 191, 0.2);
        }

        .brand-logo span {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.7px;
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
            font-size: 16px;
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
            border-radius: 9px;
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
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 8px;
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
            padding: 24px 28px;
            background:
                radial-gradient(ellipse at 92% 6%, rgba(16, 185, 129, 0.16), transparent 36%),
                radial-gradient(ellipse at 55% 45%, rgba(14, 116, 144, 0.18), transparent 55%),
                linear-gradient(135deg, #042136 0%, #031624 55%, #020e18 100%);
            min-width: 0;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.18);
            border: 1px solid #34d399;
            color: #d1fae5;
            padding: 10px 15px;
            border-radius: 9px;
            margin-bottom: 16px;
            font-size: 13px;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.18);
            border: 1px solid #f87171;
            color: #fee2e2;
            padding: 10px 15px;
            border-radius: 9px;
            margin-bottom: 16px;
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
            font-size: 27px;
            font-weight: 700;
            line-height: 1.25;
            color: #ffffff;
            margin-bottom: 3px;
        }

        .header-title p {
            color: #9bb0c4;
            font-size: 13px;
            font-weight: 400;
        }

        .header-action-btns {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn-tambah {
            background: linear-gradient(90deg, #0fa3b1 0%, #19c7b7 100%);
            color: #ffffff;
            padding: 9px 16px;
            border-radius: 8px;
            border: 1px solid rgba(153, 246, 228, 0.45);
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            box-shadow: 0 0 15px rgba(25, 199, 183, 0.28);
            transition: all 0.2s ease;
        }

        .btn-tambah:hover {
            filter: brightness(1.08);
        }

        .btn-export {
            background: rgba(15, 36, 52, 0.65);
            color: #f1f5f9;
            border: 1px solid rgba(255, 255, 255, 0.26);
            padding: 9px 16px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 13px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-export:hover {
            border-color: #2dd4bf;
            color: #99f6e4;
        }

        /* STATS CARDS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 18px;
        }

        .stat-card {
            background: linear-gradient(145deg, rgba(11, 43, 66, 0.72), rgba(5, 24, 38, 0.82));
            border: 1px solid rgba(125, 211, 252, 0.3);
            border-radius: 11px;
            padding: 15px 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.08);
        }

        .stat-info span {
            font-size: 10.5px;
            letter-spacing: 0.6px;
            font-weight: 600;
            display: block;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .stat-info h2 {
            font-size: 22px;
            font-weight: 700;
            line-height: 1.2;
        }

        .stat-label-total { color: #e2e8f0; }
        .stat-val-total   { color: #ffffff; }
        .stat-icon-total  { color: #e2e8f0; }

        .stat-label-proses, .stat-val-proses, .stat-icon-proses { color: #facc15; }
        .stat-label-kirim,  .stat-val-kirim,  .stat-icon-kirim  { color: #7dd3fc; }
        .stat-label-selesai,.stat-val-selesai,.stat-icon-selesai{ color: #86efac; }

        /* FILTER BAR */
        .filter-bar {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-input {
            flex-grow: 1;
            position: relative;
            min-width: 240px;
        }

        .search-input .search-ico {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #8fa3b8;
            pointer-events: none;
        }

        .search-input input {
            width: 100%;
            padding: 10px 14px 10px 38px;
            background: rgba(6, 26, 41, 0.78);
            border: 1px solid rgba(125, 211, 252, 0.24);
            border-radius: 8px;
            color: #ffffff;
            font-size: 13px;
            outline: none;
        }

        .search-input input::placeholder {
            color: #8fa3b8;
        }

        .search-input input:focus,
        .filter-select select:focus,
        .filter-date input:focus {
            border-color: #2dd4bf;
        }

        .filter-select select,
        .filter-date input {
            padding: 10px 13px;
            background: rgba(6, 26, 41, 0.78);
            border: 1px solid rgba(125, 211, 252, 0.24);
            border-radius: 8px;
            color: #cbd5e1;
            font-size: 13px;
            outline: none;
        }

        /* TABLE */
        .table-container {
            background: rgba(5, 23, 37, 0.72);
            border: 1px solid rgba(125, 211, 252, 0.24);
            border-radius: 11px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background: rgba(9, 34, 52, 0.9);
            padding: 13px 16px;
            font-size: 11px;
            font-weight: 600;
            color: #cbd5e1;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            border-bottom: 1px solid rgba(125, 211, 252, 0.2);
        }

        td {
            padding: 13px 16px;
            font-size: 13px;
            color: #e2e8f0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        tbody tr:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        /* STATUS BADGES */
        .badge {
            padding: 3px 10px;
            border-radius: 5px;
            font-size: 10.5px;
            font-weight: 600;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .badge-dikirim {
            background: rgba(2, 132, 199, 0.35);
            color: #7dd3fc;
            border: 1px solid rgba(56, 189, 248, 0.45);
        }

        .badge-diproses {
            background: rgba(161, 98, 7, 0.35);
            color: #fde047;
            border: 1px solid rgba(250, 204, 21, 0.45);
        }

        .badge-selesai {
            background: rgba(21, 128, 61, 0.38);
            color: #86efac;
            border: 1px solid rgba(74, 222, 128, 0.45);
        }

        /* ACTION BUTTONS */
        .action-btns {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .icon-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.16);
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

        .icon-btn:hover:not(:disabled) {
            border-color: #2dd4bf;
            color: #2dd4bf;
        }

        /* PAGINATION */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 11px 16px;
            font-size: 12px;
            color: #9bb0c4;
            background: rgba(7, 29, 45, 0.72);
            flex-wrap: wrap;
            gap: 10px;
        }

        .pagination-custom {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .page-pill {
            padding: 4px 10px;
            font-size: 11.5px;
            border-radius: 5px;
            border: 1px solid rgba(255, 255, 255, 0.16);
            background: rgba(255, 255, 255, 0.04);
            color: #cbd5e1;
            text-decoration: none;
            cursor: pointer;
        }

        .page-pill.active {
            background: #14b8a6;
            border-color: #2dd4bf;
            color: #ffffff;
            font-weight: 600;
        }

        .page-pill.disabled {
            opacity: 0.45;
            pointer-events: none;
        }

        /* MODAL */
        .modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
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
            padding: 22px;
            width: 100%;
            max-width: 430px;
            color: #ffffff;
        }

        .modal-box h3 {
            margin-bottom: 14px;
            font-size: 17px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 13px;
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
            border-radius: 8px;
            border: 1px solid rgba(125, 211, 252, 0.28);
            background: #02121d;
            color: #ffffff;
            font-size: 13px;
            outline: none;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            font-size: 13px;
        }

        .detail-row span:first-child {
            color: #94a3b8;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 16px;
        }

        .btn-batal {
            padding: 8px 15px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.24);
            background: transparent;
            color: #ffffff;
            font-size: 12.5px;
            cursor: pointer;
        }

        .btn-simpan {
            padding: 8px 15px;
            border-radius: 8px;
            border: none;
            background: linear-gradient(90deg, #0fa3b1, #19c7b7);
            color: #ffffff;
            font-weight: 600;
            font-size: 12.5px;
            cursor: pointer;
        }

        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 720px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="brand-logo">
            <img src="<?php echo e(asset('uploads/Bandeng-Gacor.jpeg')); ?>" alt="Logo Bandeng Samudra">
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
                <a href="<?php echo e(url('/karyawan/beranda')); ?>">
                    <svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 3.2 2.5 11.5h2.7v9.3h5.4v-6h2.8v6h5.4v-9.3h2.7L12 3.2z"/>
                    </svg>
                    <span>Beranda</span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(url('/karyawan/konfirmasi')); ?>">
                    <svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                        <path d="m3 7 9 6 9-6"/>
                    </svg>
                    <span>Konfirmasi Pengiriman</span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(url('/karyawan/data')); ?>" class="active">
                    <svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="16" rx="2"/>
                        <path d="M8 16v-4M12 16V9M16 16v-2"/>
                    </svg>
                    <span>Data Pengiriman</span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(url('/karyawan/riwayat')); ?>">
                    <svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 12a9 9 0 1 0 3-6.7L3 8"/>
                        <path d="M3 3v5h5M12 7v5l3 2"/>
                    </svg>
                    <span>Riwayat Pengiriman</span>
                </a>
            </li>
        </ul>

        <a href="<?php echo e(url('/logout')); ?>" class="logout-btn">
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

        <?php if(session('success')): ?>
            <div class="alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert-error"><?php echo e($errors->first()); ?></div>
        <?php endif; ?>

        <!-- HEADER -->
        <div class="header-section">
            <div class="header-title">
                <h1>Data Master Pengiriman</h1>
                <p>Kelola dan pantau seluruh manifes paket pengiriman yang terdaftar.</p>
            </div>
            <div class="header-action-btns">
                <button type="button" class="btn-tambah" onclick="bukaModalTambah()">
                    <svg class="ico" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    <span>Tambah Data</span>
                </button>
                <a href="<?php echo e(route('karyawan.data.export', request()->query())); ?>" class="btn-export">
                    <svg class="ico" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="12" y1="11" x2="12" y2="17"/>
                        <polyline points="9 14 12 17 15 14"/>
                    </svg>
                    <span>Export Excel</span>
                </a>
            </div>
        </div>

        <!-- STATS CARDS -->
        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-info">
                    <span class="stat-label-total">TOTAL MANIFES</span>
                    <h2 class="stat-val-total"><?php echo e($totalManifes ?? 0); ?> Paket</h2>
                </div>
                <svg class="ico stat-icon-total" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                    <rect x="8" y="3" width="12" height="14" rx="2"/>
                    <path d="M4 7v12a2 2 0 0 0 2 2h10"/>
                </svg>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <span class="stat-label-proses">DIPROSES</span>
                    <h2 class="stat-val-proses"><?php echo e($totalDiproses ?? 0); ?> Paket</h2>
                </div>
                <svg class="ico stat-icon-proses" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                    <path d="M3 12a9 9 0 1 0 3-6.7L3 8"/>
                    <path d="M3 3v5h5M12 7v5l3 2"/>
                </svg>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <span class="stat-label-kirim">DIKIRIM</span>
                    <h2 class="stat-val-kirim"><?php echo e($totalDikirim ?? 0); ?> Paket</h2>
                </div>
                <svg class="ico stat-icon-kirim" width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M3 6h11v9H3V6zm12 3h3.6l2.4 3v3H15V9zM6.5 18.5a1.8 1.8 0 1 0 0-3.6 1.8 1.8 0 0 0 0 3.6zm11 0a1.8 1.8 0 1 0 0-3.6 1.8 1.8 0 0 0 0 3.6z"/>
                </svg>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <span class="stat-label-selesai">SELESAI</span>
                    <h2 class="stat-val-selesai"><?php echo e($totalSelesai ?? 0); ?> Paket</h2>
                </div>
                <svg class="ico stat-icon-selesai" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9"/>
                    <polyline points="8.5 12.5 11 15 15.8 9.5"/>
                </svg>
            </div>
        </section>

        <!-- FILTER BAR -->
        <form method="GET" action="<?php echo e(route('karyawan.data')); ?>" class="filter-bar">
            <div class="search-input">
                <svg class="ico search-ico" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="7"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nomor resi, kurir, penerima...">
            </div>

            <div class="filter-select">
                <select name="status" onchange="this.form.submit()">
                    <option value="Semua Status" <?php echo e(request('status') == 'Semua Status' ? 'selected' : ''); ?>>Semua Status</option>
                    <option value="Diproses" <?php echo e(request('status') == 'Diproses' ? 'selected' : ''); ?>>Diproses</option>
                    <option value="Di Perjalanan" <?php echo e(request('status') == 'Di Perjalanan' ? 'selected' : ''); ?>>Dikirim</option>
                    <option value="Terkirim" <?php echo e(request('status') == 'Terkirim' ? 'selected' : ''); ?>>Selesai</option>
                </select>
            </div>

            <div class="filter-date">
                <input type="date" name="tanggal" value="<?php echo e(request('tanggal')); ?>" onchange="this.form.submit()">
            </div>
        </form>

        <!-- TABEL DATA -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>NO. RESI</th>
                        <th>TANGGAL MASUK</th>
                        <th>PENERIMA</th>
                        <th>TUJUAN</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $pengiriman ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $statusRaw = $item->status_pengiriman ?? 'Diproses';
                            $badgeClass = match ($statusRaw) {
                                'Terkirim', 'Selesai' => 'badge-selesai',
                                'Di Perjalanan', 'Dikirim' => 'badge-dikirim',
                                default => 'badge-diproses',
                            };
                            $labelStatus = match ($statusRaw) {
                                'Terkirim' => 'SELESAI',
                                'Di Perjalanan' => 'DIKIRIM',
                                default => strtoupper($statusRaw),
                            };
                            $penerima = $item->transaksi->customer->nama_customer
                                ?? $item->transaksi->customer->nama
                                ?? '-';
                            $tglMasuk = $item->created_at
                                ? $item->created_at->translatedFormat('d M Y')
                                : '24 Mei 2026';
                        ?>
                        <tr>
                            <td>#<?php echo e($item->no_pengiriman); ?></td>
                            <td><?php echo e($tglMasuk); ?></td>
                            <td><?php echo e($penerima); ?></td>
                            <td><?php echo e($item->alamat_pengiriman ?? '-'); ?></td>
                            <td><span class="badge <?php echo e($badgeClass); ?>"><?php echo e($labelStatus); ?></span></td>
                            <td>
                                <div class="action-btns">
                                    <button type="button"
                                            class="icon-btn"
                                            title="Lihat Detail"
                                            onclick="bukaModalDetail('<?php echo e($item->no_pengiriman); ?>', '<?php echo e($tglMasuk); ?>', '<?php echo e(addslashes($penerima)); ?>', '<?php echo e(addslashes($item->alamat_pengiriman ?? '-')); ?>', '<?php echo e($labelStatus); ?>')">
                                        <svg class="ico" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </button>

                                    <?php if($statusRaw !== 'Terkirim'): ?>
                                        <form action="<?php echo e(route('karyawan.prosesSelesai', $item->no_pengiriman)); ?>" method="POST" style="display:inline;">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="icon-btn" title="Konfirmasi Selesai">
                                                <svg class="ico" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M12 20h9"/>
                                                    <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <button type="button" class="icon-btn" title="Sudah Selesai" disabled style="opacity:0.45;cursor:default;">
                                            <svg class="ico" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M12 20h9"/>
                                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                            </svg>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" style="text-align:center; color:#94a3b8;">Belum ada data pengiriman.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- PAGINATION -->
            <div class="pagination-container">
                <?php if(isset($pengiriman) && method_exists($pengiriman, 'total')): ?>
                    <div>Menampilkan <?php echo e($pengiriman->firstItem() ?? 0); ?>-<?php echo e($pengiriman->lastItem() ?? 0); ?> dari <?php echo e($pengiriman->total()); ?> total baris data</div>
                    <div class="pagination-custom">
                        <?php if($pengiriman->onFirstPage()): ?>
                            <span class="page-pill disabled">Sebelumnya</span>
                        <?php else: ?>
                            <a href="<?php echo e($pengiriman->appends(request()->query())->previousPageUrl()); ?>" class="page-pill">Sebelumnya</a>
                        <?php endif; ?>

                        <?php for($i = 1; $i <= $pengiriman->lastPage(); $i++): ?>
                            <a href="<?php echo e($pengiriman->appends(request()->query())->url($i)); ?>"
                               class="page-pill <?php echo e($pengiriman->currentPage() == $i ? 'active' : ''); ?>"><?php echo e($i); ?></a>
                        <?php endfor; ?>

                        <?php if($pengiriman->hasMorePages()): ?>
                            <a href="<?php echo e($pengiriman->appends(request()->query())->nextPageUrl()); ?>" class="page-pill">Selanjutnya</a>
                        <?php else: ?>
                            <span class="page-pill disabled">Selanjutnya</span>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div>Menampilkan data pengiriman</div>
                    <div class="pagination-custom">
                        <span class="page-pill disabled">Sebelumnya</span>
                        <span class="page-pill active">1</span>
                        <span class="page-pill disabled">Selanjutnya</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </main>

    <!-- MODAL TAMBAH DATA -->
    <div id="modalTambah" class="modal-backdrop">
        <div class="modal-box">
            <h3>Tambah Data Pengiriman</h3>
            <form action="<?php echo e(route('karyawan.data.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label>No. Resi / Pengiriman</label>
                    <input type="text" name="no_pengiriman" value="<?php echo e(old('no_pengiriman')); ?>" placeholder="Contoh: KRM240524004" required>
                </div>
                <div class="form-group">
                    <label>Tujuan / Alamat Pengiriman</label>
                    <input type="text" name="alamat_pengiriman" value="<?php echo e(old('alamat_pengiriman')); ?>" placeholder="Contoh: Temanggung" required>
                </div>
                <div class="form-group">
                    <label>No. Faktur (Opsional)</label>
                    <input type="text" name="no_faktur" value="<?php echo e(old('no_faktur')); ?>" placeholder="Kosongkan jika otomatis">
                </div>
                <div class="form-group">
                    <label>Status Pengiriman</label>
                    <select name="status_pengiriman" required>
                        <option value="Diproses">Diproses</option>
                        <option value="Di Perjalanan">Dikirim</option>
                        <option value="Terkirim">Selesai</option>
                    </select>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-batal" onclick="tutupModalTambah()">Batal</button>
                    <button type="submit" class="btn-simpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL DETAIL -->
    <div id="modalDetail" class="modal-backdrop">
        <div class="modal-box">
            <h3>Detail Pengiriman</h3>
            <div class="detail-row"><span>No. Resi</span><strong id="detailResi">-</strong></div>
            <div class="detail-row"><span>Tanggal Masuk</span><span id="detailTanggal">-</span></div>
            <div class="detail-row"><span>Penerima</span><span id="detailPenerima">-</span></div>
            <div class="detail-row"><span>Tujuan</span><span id="detailTujuan">-</span></div>
            <div class="detail-row"><span>Status</span><span id="detailStatus">-</span></div>
            <div class="modal-actions">
                <button type="button" class="btn-batal" onclick="tutupModalDetail()">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        function bukaModalTambah() {
            document.getElementById('modalTambah').classList.add('show');
        }

        function tutupModalTambah() {
            document.getElementById('modalTambah').classList.remove('show');
        }

        function bukaModalDetail(resi, tanggal, penerima, tujuan, status) {
            document.getElementById('detailResi').textContent = '#' + resi;
            document.getElementById('detailTanggal').textContent = tanggal;
            document.getElementById('detailPenerima').textContent = penerima;
            document.getElementById('detailTujuan').textContent = tujuan;
            document.getElementById('detailStatus').textContent = status;
            document.getElementById('modalDetail').classList.add('show');
        }

        function tutupModalDetail() {
            document.getElementById('modalDetail').classList.remove('show');
        }

        <?php if($errors->any()): ?>
            bukaModalTambah();
        <?php endif; ?>
    </script>

</body>
</html><?php /**PATH C:\xampp\htdocs\Projek-Bandeng\resources\views/karyawan/data.blade.php ENDPATH**/ ?>