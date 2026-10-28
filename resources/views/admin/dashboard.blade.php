@extends('admin.layout')

@section('title', 'Dashboard Admin - Projek Bandeng')

@section('content')
<div class="dashboard-container">

    {{-- WELCOME BANNER --}}
    <div class="admin-welcome-card">
        <div class="welcome-text">
            <span class="welcome-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                Admin Panel
            </span>
            <h1>Selamat Datang, Admin! <span class="wave">👋</span></h1>
            <p>Kelola inventaris produk bandeng dan pantau total pesanan pelanggan dengan mudah di sini.</p>
        </div>
        <div class="welcome-icon-box">
        </div>
    </div>

    {{-- STATS GRID --}}
    <div class="admin-stats-grid">

        {{-- CARD PRODUK --}}
        <div class="admin-stat-card product-card">
            <div class="card-header-top">
                <div class="stat-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m2 7 10-5 10 5-10 5z"/><path d="m2 17 10 5 10-5"/><path d="m2 12 10 5 10-5"/></svg>
                </div>
                <span class="trend-badge active-status">Aktif</span>
            </div>
            <div class="card-body">
                <span class="stat-label">Total Produk Bandeng</span>
                <h2 class="stat-number">{{ number_format($totalProduk ?? 0) }}</h2>
            </div>
            <div class="card-footer">
                <span>Produk terdaftar di sistem</span>
            </div>
        </div>

        {{-- CARD PESANAN --}}
        <div class="admin-stat-card order-card">
            <div class="card-header-top">
                <div class="stat-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                </div>
                <span class="trend-badge order-status">Transaksi</span>
            </div>
            <div class="card-body">
                <span class="stat-label">Total Pesanan</span>
                <h2 class="stat-number">{{ number_format($totalPesanan ?? 0) }}</h2>
            </div>
            <div class="card-footer">
                <span>Pesanan masuk tercatat</span>
            </div>
        </div>

    </div>

</div>

{{-- CSS KHUSUS DASHBOARD --}}
<style>
    .dashboard-container {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    /* Welcome Banner */
    .admin-welcome-card {
        background: linear-gradient(135deg, rgba(16, 30, 54, 0.75) 0%, rgba(8, 18, 33, 0.85) 100%);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(0, 242, 254, 0.15);
        border-radius: 16px;
        padding: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
    }

    .welcome-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(0, 242, 254, 0.1);
        color: #00f2fe;
        border: 1px solid rgba(0, 242, 254, 0.25);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .admin-welcome-card h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #ffffff;
        margin: 0 0 0.5rem 0;
    }

    .admin-welcome-card p {
        color: #94a3b8;
        font-size: 0.95rem;
        margin: 0;
    }

    .big-fish {
        font-size: 3.5rem;
        filter: drop-shadow(0 0 10px rgba(0, 242, 254, 0.4));
    }

    /* Stats Grid */
    .admin-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.5rem;
    }

    .admin-stat-card {
        background: rgba(16, 26, 43, 0.6);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.3s ease;
    }

    .admin-stat-card:hover {
        transform: translateY(-4px);
        border-color: rgba(0, 242, 254, 0.3);
        box-shadow: 0 10px 25px -5px rgba(0, 242, 254, 0.15);
    }

    .product-card { border-left: 4px solid #00f2fe; }
    .order-card { border-left: 4px solid #f59e0b; }

    .card-header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .stat-icon-wrapper {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-card .stat-icon-wrapper {
        background: rgba(0, 242, 254, 0.12);
        color: #00f2fe;
    }

    .order-card .stat-icon-wrapper {
        background: rgba(245, 158, 11, 0.12);
        color: #f59e0b;
    }

    .trend-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 6px;
    }

    .active-status {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
    }

    .order-status {
        background: rgba(245, 158, 11, 0.15);
        color: #f59e0b;
    }

    .card-body {
        margin-bottom: 1rem;
    }

    .stat-label {
        font-size: 0.85rem;
        color: #94a3b8;
        display: block;
        margin-bottom: 0.25rem;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #ffffff;
        margin: 0;
    }

    .card-footer {
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        padding-top: 0.75rem;
        font-size: 0.78rem;
        color: #64748b;
    }

    @media (max-width: 768px) {
        .admin-welcome-card {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        .big-fish {
            align-self: flex-end;
        }
    }
</style>
@endsection