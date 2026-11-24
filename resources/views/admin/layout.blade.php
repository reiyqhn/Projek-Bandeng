<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Bandeng Samudra')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
        }
        html, body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #03131f !important;
            color: #ffffff !important;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden;
        }

        .admin-shell {
            display: flex;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            position: relative;
            background-image: url("{{ asset('images/background-bandeng.png') }}");
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .admin-shell::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(3, 19, 31, 0.42);
            pointer-events: none;
            z-index: 0;
        }

        .sidebar {
            width: 256px;
            height: 100vh;
            flex-shrink: 0;
            position: relative;
            z-index: 2;
            background: rgba(10, 45, 75, 0.45) !important;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-right: 1px solid rgba(20, 184, 166, 0.3);
            padding: 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow-y: auto;
        }

        .admin-profile-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 10px 12px;
            margin-bottom: 18px;
            border-radius: 14px;
            text-decoration: none;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.12);
            transition: all 0.2s ease;
        }

        .admin-profile-link:hover,
        .admin-profile-link.active {
            background: rgba(20, 184, 166, 0.18);
            border-color: rgba(45, 212, 191, 0.55);
            color: #ffffff;
        }

        .sidebar .nav-link {
            color: #d1d5db !important;
            border-radius: 12px;
            padding: 11px 16px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.06);
            color: #5eead4 !important;
        }

        .sidebar .nav-link.active {
            background: linear-gradient(90deg, #0d9488 0%, #115e59 100%) !important;
            color: #ffffff !important;
            font-weight: 600;
            box-shadow: 0 8px 20px rgba(19, 78, 74, 0.45);
        }

        .sidebar .nav-link.parent-active {
            background: rgba(255, 255, 255, 0.06);
            color: #5eead4 !important;
            font-weight: 600;
        }

        .sidebar .submenu-link {
            font-size: 0.8rem;
            padding: 7px 14px;
            color: #9ca3af !important;
            border-radius: 8px;
        }

        .sidebar .submenu-link:hover,
        .sidebar .submenu-link.active {
            background: transparent !important;
            box-shadow: none !important;
            color: #5eead4 !important;
            font-weight: 700;
        }

        .admin-main {
            flex: 1;
            height: 100vh;
            overflow-y: auto;
            position: relative;
            z-index: 1;
            padding: 24px 32px 36px 32px;
            display: flex;
            flex-direction: column;
        }

        .admin-main::-webkit-scrollbar {
            width: 7px;
        }
        .admin-main::-webkit-scrollbar-track {
            background: rgba(3, 19, 31, 0.3);
        }
        .admin-main::-webkit-scrollbar-thumb {
            background: rgba(20, 184, 166, 0.35);
            border-radius: 4px;
        }

        .card-glass-admin {
            background: rgba(8, 35, 54, 0.65) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(20, 184, 166, 0.28) !important;
            border-radius: 16px;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.4);
        }

        .role-pill {
            background: rgba(8, 35, 54, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(20, 184, 166, 0.35);
            border-radius: 10px;
            padding: 6px 18px;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            color: #d1d5db;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .role-pill:hover {
            border-color: rgba(45, 212, 191, 0.65);
            color: #ffffff;
        }

        input[type="date"] {
            color-scheme: dark;
        }
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
            cursor: pointer;
            opacity: 0.9;
        }
        input[type="date"]::-webkit-calendar-picker-indicator:hover {
            opacity: 1;
        }

        .logout-modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(3, 12, 22, 0.68);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            padding: 16px;
        }
        .logout-modal-backdrop.is-open {
            display: flex;
        }
        .logout-modal-card {
            width: 100%;
            max-width: 360px;
            background: rgba(15, 28, 46, 0.96);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 20px;
            padding: 28px 24px;
            text-align: center;
            color: #ffffff;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.65);
        }
        .logout-modal-icon {
            font-size: 42px;
            color: #ef4444;
            margin-bottom: 14px;
            display: inline-block;
        }
        .logout-modal-title {
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 20px;
        }
        .logout-btn-confirm {
            width: 100%;
            padding: 11px 16px;
            border: none;
            border-radius: 10px;
            background: #dc2626;
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s ease;
            margin-bottom: 10px;
        }
        .logout-btn-confirm:hover {
            background: #b91c1c;
        }
        .logout-btn-cancel {
            width: 100%;
            padding: 11px 16px;
            border: none;
            border-radius: 10px;
            background: #4b5563;
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease;
        }
        .logout-btn-cancel:hover {
            background: #374151;
        }
    </style>
    @stack('styles')
</head>
<body>
    @php
        $adminGuardUser = \Illuminate\Support\Facades\Auth::guard('admin')->user();
        if (!$adminGuardUser && session('role') === 'admin' && session('user_id')) {
            $adminGuardUser = \App\Models\Admin::where('id_admin', session('user_id'))->first();
        }
        $namaAdminTampil = $adminGuardUser->nama
            ?? session('nama_admin')
            ?? 'Admin';
    @endphp

    <div class="admin-shell">
        <aside id="sidebar" class="sidebar">
            <div>
                <div class="d-flex align-items-center gap-3 mb-4">
                    <img src="{{ asset('images/logo-ikan.png') }}" alt="Logo Bandeng Samudra" style="width: 48px; height: 48px; object-fit: contain; filter: drop-shadow(0 0 8px rgba(20, 184, 166, 0.5));">
                    <h1 class="h5 text-white m-0" style="font-weight: 900; letter-spacing: 1px;">WELCOME</h1>
                </div>

                <a href="{{ route('admin.profil') }}"
                   title="Klik untuk edit profil admin"
                   class="admin-profile-link {{ request()->routeIs('admin.profil') ? 'active' : '' }}">
                    <div class="d-flex align-items-center gap-3 min-w-0">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white flex-shrink-0" style="width: 36px; height: 36px; background: rgba(15, 118, 110, 0.55);">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div class="text-truncate">
                            <div class="text-white fw-semibold small text-truncate">{{ $namaAdminTampil }}</div>
                            <div style="font-size: 0.7rem; color: #5eead4;">Edit Profil</div>
                        </div>
                    </div>
                    <i class="fa-solid fa-pen-to-square small" style="color: #5eead4;"></i>
                </a>

                <ul class="nav flex-column gap-2">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fa-solid fa-house me-3" style="width: 18px;"></i> Beranda
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#bandengSubmenu" data-bs-toggle="collapse" class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('admin.bandeng.*') ? 'parent-active' : '' }}">
                            <span><i class="fa-solid fa-fish me-3" style="width: 18px;"></i> Data Bandeng</span>
                            <i class="fa-solid fa-chevron-down small"></i>
                        </a>
                        <ul class="collapse list-unstyled ps-4 pt-1 {{ request()->routeIs('admin.bandeng.*') ? 'show' : '' }}" id="bandengSubmenu">
                            <li>
                                <a href="{{ route('admin.bandeng.index') }}" class="nav-link submenu-link {{ request()->routeIs('admin.bandeng.index') ? 'active' : '' }}">
                                    Lihat Data
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.bandeng.create') }}" class="nav-link submenu-link {{ request()->routeIs('admin.bandeng.create') ? 'active' : '' }}">
                                    Input Bandeng
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.bandeng.edit.direct') }}" class="nav-link submenu-link {{ request()->routeIs('admin.bandeng.edit*') ? 'active' : '' }}">
                                    Edit Bandeng
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-chart-column me-3" style="width: 18px;"></i> Laporan Penjualan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#userSubmenu" data-bs-toggle="collapse" class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('admin.customer.*') || request()->routeIs('admin.pegawai.*') ? 'parent-active' : '' }}">
                            <span><i class="fa-solid fa-users me-3" style="width: 18px;"></i> Data User</span>
                            <i class="fa-solid fa-chevron-down small"></i>
                        </a>
                        <ul class="collapse list-unstyled ps-4 pt-1 {{ request()->routeIs('admin.customer.*') || request()->routeIs('admin.pegawai.*') ? 'show' : '' }}" id="userSubmenu">
                            <li>
                                <a href="{{ route('admin.customer.index') }}" class="nav-link submenu-link {{ request()->routeIs('admin.customer.*') ? 'active' : '' }}">
                                    Data Customer
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.pegawai.index') }}" class="nav-link submenu-link {{ request()->routeIs('admin.pegawai.*') ? 'active' : '' }}">
                                    Data Pegawai
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="pt-3">
                <button type="button" onclick="bukaModalLogout()" class="nav-link bg-transparent border-0 w-100 text-start" style="color: #f87171 !important; cursor: pointer;">
                    <i class="fa-solid fa-right-from-bracket me-3" style="width: 18px;"></i> Logout
                </button>
            </div>
        </aside>

        <main class="admin-main">
            <div class="d-flex justify-content-end align-items-center mb-4">
                <a href="{{ route('admin.profil') }}" title="Edit Profil Admin" class="role-pill shadow-sm">
                    <i class="fa-solid fa-user-shield text-info"></i>
                    <span>{{ $namaAdminTampil }}</span>
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm auto-hide-alert" role="alert" style="background: rgba(16, 185, 129, 0.25); color: #fff; backdrop-filter: blur(8px);">
                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm auto-hide-alert" role="alert" style="background: rgba(239, 68, 68, 0.25); color: #fff; backdrop-filter: blur(8px);">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <div id="modalLogout" class="logout-modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="judulModalLogout">
        <div class="logout-modal-card">
            <div class="logout-modal-icon">
                <i class="fa-solid fa-right-from-bracket"></i>
            </div>
            <div id="judulModalLogout" class="logout-modal-title">Yakin ingin Keluar ?</div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <input type="hidden" name="role" value="admin">
                <button type="submit" class="logout-btn-confirm">Ya, Keluar</button>
            </form>
            <button type="button" onclick="tutupModalLogout()" class="logout-btn-cancel">Batal</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function bukaModalLogout() {
            const modal = document.getElementById('modalLogout');
            if (modal) modal.classList.add('is-open');
        }
        function tutupModalLogout() {
            const modal = document.getElementById('modalLogout');
            if (modal) modal.classList.remove('is-open');
        }
        document.addEventListener('click', function (e) {
            const modal = document.getElementById('modalLogout');
            if (modal && e.target === modal) tutupModalLogout();
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') tutupModalLogout();
        });
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                document.querySelectorAll('.alert').forEach(function (alertEl) {
                    alertEl.style.transition = 'opacity 0.5s ease';
                    alertEl.style.opacity = '0';
                    setTimeout(function () {
                        alertEl.remove();
                    }, 500);
                });
            }, 3000);
        });
    </script>
    @stack('scripts')
</body>
</html>