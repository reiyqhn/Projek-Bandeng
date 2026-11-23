<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projek - Bandeng Samudra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <!-- CSS PAKSAAN UNTUK LATAR BELAKANG BIRU GELAP KONSISTEN -->
    <style>
        html, body {
            background-color: #071320 !important;
            color: #ffffff !important;
            min-height: 100vh;
        }
        .sidebar {
            background-color: #040c14 !important;
            min-height: 100vh;
        }
        .main-content-card {
            background: rgba(11, 25, 44, 0.85);
            border: 1px solid rgba(13, 202, 240, 0.2);
            border-radius: 16px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            backdrop-filter: blur(8px);
            padding: 25px;
            margin-top: 10px;
        }
    </style>
</head>
<body style="background-color: #071320 !important;">
    <div class="container-fluid">
        <div class="row">
            <!-- SIDEBAR -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar p-3 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center mb-4 px-2">
                        <span class="fs-3 me-2">🐟</span>
                        <div>
                            <div class="text-white fw-bold" style="font-size: 0.8rem; letter-spacing: 1px;">BANDENG</div>
                            <span class="text-info fw-bold" style="font-size: 0.75rem; letter-spacing: 2px;">SAMUDRA</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4 px-3 py-2" style="border-top: 1px solid rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <i class="fa-solid fa-user-circle fs-4 me-2 text-white"></i>
                        <span class="text-white fw-semibold">Admin</span>
                    </div>

                    <ul class="nav flex-column gap-1">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="fa-solid fa-house me-2"></i> Beranda
                            </a>
                        </li>

                        <!-- DATA BANDENG -->
                        <li class="nav-item">
                            <a href="#bandengSubmenu" data-bs-toggle="collapse" class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('admin.bandeng.*') ? 'active' : '' }}">
                                <span><i class="fa-solid fa-fish me-2"></i> Data Bandeng</span>
                                <i class="fa-solid fa-chevron-down small"></i>
                            </a>
                            <ul class="collapse list-unstyled ms-3 mt-1 {{ request()->routeIs('admin.bandeng.*') ? 'show' : '' }}" id="bandengSubmenu">
                                <li class="mb-1">
                                    <a href="{{ route('admin.bandeng.index') }}" class="nav-link {{ request()->routeIs('admin.bandeng.index') ? 'active text-info' : '' }}">
                                        <i class="fa-solid fa-arrow-turn-down-right me-2" style="transform: rotate(90deg);"></i> Lihat Data
                                    </a>
                                </li>
                                <li class="mb-1">
                                    <a href="{{ route('admin.bandeng.create') }}" class="nav-link {{ request()->routeIs('admin.bandeng.create') ? 'active text-info' : '' }}">
                                        <i class="fa-solid fa-arrow-turn-down-right me-2" style="transform: rotate(90deg);"></i> Input Bandeng
                                    </a>
                                </li>
                                <li class="mb-1">
                                    <a href="{{ route('admin.bandeng.edit.direct') }}" class="nav-link {{ request()->routeIs('admin.bandeng.edit*') ? 'active text-info' : '' }}">
                                        <i class="fa-solid fa-arrow-turn-down-right me-2" style="transform: rotate(90deg);"></i> Edit Bandeng
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                                <i class="fa-solid fa-chart-column me-2"></i> Laporan Penjualan
                            </a>
                        </li>
                        
                        <!-- DATA USER -->
                        <li class="nav-item">
                            <a href="#userSubmenu" data-bs-toggle="collapse" class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('admin.customer.*') || request()->routeIs('admin.pegawai.*') ? 'active' : '' }}">
                                <span><i class="fa-solid fa-users me-2"></i> Data User</span>
                                <i class="fa-solid fa-chevron-down small"></i>
                            </a>
                            <ul class="collapse list-unstyled ms-3 mt-1 {{ request()->routeIs('admin.customer.*') || request()->routeIs('admin.pegawai.*') ? 'show' : '' }}" id="userSubmenu">
                                <li class="mb-1">
                                    <a href="{{ route('admin.customer.index') }}" class="nav-link {{ request()->routeIs('admin.customer.*') ? 'active text-info' : '' }}">
                                        <i class="fa-solid fa-arrow-turn-down-right me-2" style="transform: rotate(90deg);"></i> Data Customer
                                    </a>
                                </li>
                                <li class="mb-1">
                                    <!-- MENU DATA PEGAWAI SUDAH DIHUBUNGKAN -->
                                    <a href="{{ route('admin.pegawai.index') }}" class="nav-link {{ request()->routeIs('admin.pegawai.*') ? 'active text-info' : 'text-white' }}">
                                        <i class="fa-solid fa-arrow-turn-down-right me-2" style="transform: rotate(90deg);"></i> Data Pegawai
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="mt-4">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link bg-transparent border-0 w-100 text-start d-flex align-items-center text-white">
                            <i class="fa-solid fa-right-from-bracket me-2 fs-5"></i> Logout
                        </button>
                    </form>
                </div>
            </nav>

            <!-- MAIN CONTENT -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="fw-bold m-0 text-white" style="letter-spacing: 0.5px;">WELCOME</h3>
                    <div class="bg-dark px-3 py-1 rounded border border-secondary text-secondary small shadow-sm">
                        Admin
                    </div>
                </div>

                <div class="main-content-card">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>