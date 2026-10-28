<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin') - Projek Bandeng</title>

    @vite(['resources/css/admin.css'])

    <style>
        body {
            background: linear-gradient(135deg, rgba(4, 25, 50, 0.35), rgba(4, 40, 65, 0.20)), url('{{ asset('image/background.jpeg') }}') no-repeat center center fixed !important;
            background-size: cover !important;
            min-height: 100vh;
            margin: 0;
            overflow-x: hidden;
            color: #f1f5f9;
        }

        .admin-wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
            position: relative;
        }

        /* Sidebar Lebih Terang & Menyatu (Glassmorphism Halus) */
        .sidebar {
            width: 260px;
            background: rgba(12, 35, 65, 0.35);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-right: 1px solid rgba(0, 242, 254, 0.2);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1.25rem 1rem;
            box-sizing: border-box;
        }

        /* Konten Utama Menyesuaikan Posisi Sidebar */
        .main-content {
            margin-left: 260px;
            flex: 1;
            width: calc(100% - 260px);
            padding: 2rem;
            box-sizing: border-box;
            min-height: 100vh;
        }
    </style>
</head>

<body>
    <div class="admin-wrapper">

        {{-- SIDEBAR --}}
        <aside class="sidebar">

            <div>
                {{-- HEADER LOGO & WELCOME --}}
                <div class="sidebar-brand" style="position: relative; display: flex; align-items: center; gap: 12px; padding-bottom: 1rem; border-bottom: 1px solid rgba(255, 255, 255, 0.12); margin-bottom: 1rem;">
                    
                    {{-- Efek Glow di belakang teks WELCOME --}}
                    <div style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); width: 140px; height: 50px; background: rgba(0, 242, 254, 0.22); filter: blur(16px); border-radius: 50%; pointer-events: none; z-index: 0;"></div>
                    
                    <img
                        src="{{ asset('image/Logo_Bandeng.png') }}"
                        alt="Logo Projek Bandeng"
                        class="sidebar-brand-logo"
                        style="width: 45px; height: 45px; object-fit: contain; position: relative; z-index: 1;"
                    >

                    <div class="sidebar-brand-text" style="position: relative; z-index: 1;">
                        <h5 style="margin: 0; font-size: 1rem; font-weight: 700; color: #ffffff; text-shadow: 0 0 10px rgba(0, 242, 254, 0.6); letter-spacing: 1px;">WELCOME</h5>
                        <small style="color: #00f2fe; font-size: 0.75rem;">Admin Dashboard</small>
                    </div>
                </div>

                {{-- PROFIL ADMIN (Sesuai Database / Nama User) --}}
                <div class="sidebar-user-box" style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; background: rgba(16, 40, 70, 0.45); border: 1px solid rgba(0, 242, 254, 0.25); border-radius: 12px; margin-bottom: 1.5rem; backdrop-filter: blur(8px);">
                    <div style="width: 32px; height: 32px; background: rgba(0, 242, 254, 0.2); color: #00f2fe; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0;">
                        👤
                    </div>
                    <div style="color: #f1f5f9; font-weight: 600; font-size: 0.9rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ Auth::check() ? Auth::user()->name : 'Admin' }}
                    </div>
                </div>

                <nav class="sidebar-menu">

                    {{-- BERANDA --}}
                    <a href="{{ route('admin.dashboard') }}"
                       class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="menu-icon">🏠</span>
                        <span class="menu-title">Beranda</span>
                    </a>

                    {{-- DATA BANDENG --}}
                    <div class="menu-group
                        {{ request()->routeIs('admin.bandeng.*') ? 'menu-open' : '' }}">

                        <button type="button"
                                class="menu-toggle"
                                onclick="toggleMenu(this)">

                            <span class="menu-icon">🐟</span>
                            <span class="menu-title">Data Bandeng</span>
                            <span class="menu-arrow">▼</span>
                        </button>

                        <div class="submenu">
                            <a href="{{ route('admin.bandeng.index') }}"
                               class="{{ request()->routeIs('admin.bandeng.index') ? 'active' : '' }}">
                                📋 Lihat Data
                            </a>

                            <a href="{{ route('admin.bandeng.create') }}"
                               class="{{ request()->routeIs('admin.bandeng.create') ? 'active' : '' }}">
                                ➕ Input Bandeng
                            </a>

                            <a href="{{ route('admin.bandeng.index') }}#daftar-bandeng"
                               class="sidebar-menu-item {{ request()->routeIs('admin.bandeng.index') ? 'active' : '' }}">
                               <span>✏️</span>
                               <span>Edit Bandeng</span>
                            </a>
                        </div>
                    </div>

                    {{-- LAPORAN --}}
                    <a href="{{ route('admin.laporan.index') }}"
                       class="{{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                        <span class="menu-icon">📊</span>
                        <span class="menu-title">Laporan Penjualan</span>
                    </a>

                    {{-- DATA USER --}}
                    <div class="menu-group
                        {{ request()->routeIs('admin.user.*') ? 'menu-open' : '' }}">

                        <button type="button"
                                class="menu-toggle"
                                onclick="toggleMenu(this)">

                            <span class="menu-icon">👥</span>
                            <span class="menu-title">Data User</span>
                            <span class="menu-arrow">▼</span>
                        </button>

                        <div class="submenu">
                            <a href="#data-customer">
                                🛒 Data Customer
                            </a>

                            <a href="#data-pegawai">
                                👨‍💼 Data Pegawai
                            </a>
                        </div>
                    </div>

                </nav>
            </div>

        </aside>

        {{-- KONTEN UTAMA --}}
        <main class="main-content">
            <section class="page-content">
                @yield('content')
            </section>
        </main>

    </div>

    {{-- JAVASCRIPT MENU --}}
    <script>
        function toggleMenu(element) {
            const currentMenu = element.parentElement;
            const wasOpen = currentMenu.classList.contains('menu-open');

            document.querySelectorAll('.sidebar .menu-group').forEach(function(menu) {
                menu.classList.remove('menu-open');
            });

            if (!wasOpen) {
                currentMenu.classList.add('menu-open');
            }
        }
    </script>

</body>
</html>