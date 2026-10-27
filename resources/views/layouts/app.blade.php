<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bandeng Samudera')</title>

    @php
        // Cek berdasarkan URL aktif untuk setiap role
        $isAdmin = request()->is('admin*');
        $isKasir = request()->is('kasir*');
        $isKaryawan = request()->is('karyawan*');

        // Ambil nama kasir supaya tidak undefined error
        $namaKasir = session('nama_kasir') 
                  ?? optional(\Illuminate\Support\Facades\Auth::user())->nama 
                  ?? 'Kasir';
    @endphp

    @if($isKasir)
        <!-- Asset & Style Khusus Kasir (Tailwind) -->
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <style>
            body { 
                background-color: #03131f; 
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            }
            .bg-sidebar { 
                background: rgba(10, 45, 75, 0.45) !important; 
                backdrop-filter: blur(15px); 
                -webkit-backdrop-filter: blur(15px);
                border-right: 1px solid rgba(20, 184, 166, 0.3);
            }
            .card-glass { 
                background: rgba(8, 35, 54, 0.6); 
                backdrop-filter: blur(10px); 
                border: 1px solid rgba(20, 90, 120, 0.4); 
            }
        </style>
    @else
        <!-- Asset & Style Khusus Customer (Bootstrap) -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style>
            * { font-family: 'Poppins', sans-serif; box-sizing: border-box; }
            body, html { width: 100%; height: 100%; margin: 0; background-color: #0b1a2b; overflow: hidden; }
            .app-container { display: flex; width: 100vw; height: 100vh; overflow: hidden; position: relative; }
            .sidebar {
                width: 270px; background: linear-gradient(180deg, #0f2b48 0%, #0a1c30 100%);
                border-right: 1px solid rgba(255, 255, 255, 0.1); display: flex;
                flex-direction: column; justify-content: space-between; padding: 25px 20px;
                height: 100vh; position: fixed; top: 0; left: 0; z-index: 100;
            }
            .nav-link-custom {
                color: rgba(255, 255, 255, 0.7); border-radius: 12px; padding: 12px 18px;
                margin-bottom: 8px; font-weight: 500; font-size: 0.9rem; text-decoration: none;
                display: flex; align-items: center; transition: all 0.3s ease;
            }
            .nav-link-custom:hover, .nav-link-custom.active {
                background: linear-gradient(90deg, #00b4d8 0%, #0077b6 100%);
                color: #ffffff; box-shadow: 0 4px 15px rgba(0, 180, 216, 0.35);
            }
            .user-profile-box {
                background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 15px; padding: 10px 15px; margin-bottom: 25px;
            }
            .main-content {
                flex-grow: 1; margin-left: 270px; width: calc(100vw - 270px); height: 100vh;
                overflow-y: auto !important; background-image: linear-gradient(rgba(10, 28, 48, 0.65), rgba(10, 28, 48, 0.65)), 
                url("{{ asset('image/Daftar_Akun.png') }}"); background-size: cover; background-position: center;
                background-repeat: no-repeat; background-attachment: fixed; padding: 35px 45px; color: white;
            }
            .search-input {
                background: rgba(255, 255, 255, 0.15) !important; backdrop-filter: blur(8px);
                border: 1px solid rgba(255, 255, 255, 0.25) !important; border-radius: 20px !important;
                color: white !important; font-size: 0.85rem; padding-left: 20px; padding-right: 40px;
            }
            .search-input::placeholder { color: rgba(255, 255, 255, 0.6); }
            .icon-btn {
                width: 40px; height: 40px; background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(8px);
                border: 1px solid rgba(255, 255, 255, 0.25); border-radius: 10px; display: flex;
                align-items: center; justify-content: center; color: white; cursor: pointer;
            }
            .main-content::-webkit-scrollbar { width: 8px; }
            .main-content::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.1); }
            .main-content::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.3); border-radius: 4px; }
        </style>
    @endif
</head>
<body class="{{ $isKasir ? 'text-white flex h-screen overflow-hidden' : '' }}">

    @if($isKasir)
        <!-- ================= TAMPILAN KASIR ================= -->
        <aside class="w-64 bg-sidebar flex flex-col justify-between p-6 border-r border-teal-900/30 z-10">
            <div>
                <div class="flex items-center gap-3 mb-8">
                    <img src="{{ asset('images/logo-ikan.png') }}" alt="Logo Bandeng Samudera" class="w-12 h-12 object-contain drop-shadow-[0_0_8px_rgba(20,184,166,0.5)]">
                    <h1 class="text-xl font-black tracking-wider text-white">WELCOME</h1>
                </div>

                <div class="flex items-center gap-3 mb-8 px-2">
                    <div class="w-9 h-9 rounded-full bg-teal-700/50 flex items-center justify-center text-white">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <span class="font-medium text-sm">{{ $namaKasir }}</span>
                </div>

                <nav class="space-y-2" x-data="{ 
                    openOnline: {{ request()->routeIs('kasir.online.pembayaran') || request()->routeIs('kasir.transaksi-online.faktur') ? 'true' : 'false' }}, 
                    openOffline: false 
                }">
                    <a href="{{ route('kasir.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition text-sm font-medium {{ request()->routeIs('kasir.dashboard') ? 'bg-gradient-to-r from-teal-600 to-teal-800 text-white shadow-lg shadow-teal-900/40' : 'hover:bg-white/5 text-gray-300' }}">
                        <i class="fa-solid fa-house {{ request()->routeIs('kasir.dashboard') ? 'text-teal-300' : 'text-gray-400' }}"></i> Beranda
                    </a>

                    <div>
                        <button @click="openOnline = !openOnline" class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition text-sm {{ request()->routeIs('kasir.online.pembayaran') || request()->routeIs('kasir.transaksi-online.faktur') ? 'bg-white/5 text-teal-300 font-semibold' : 'hover:bg-white/5 text-gray-300' }}">
                            <div class="flex items-center gap-4">
                                <i class="fa-solid fa-desktop"></i> Transaksi Online
                            </div>
                            <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': openOnline }"></i>
                        </button>
                        <div x-show="openOnline" x-transition class="pl-11 pr-4 py-2 space-y-2 text-xs">
                            <a href="{{ route('kasir.online.pembayaran') }}" class="block transition {{ request()->routeIs('kasir.online.pembayaran') ? 'text-teal-300 font-bold' : 'text-gray-400 hover:text-teal-300' }}">Pembayaran</a>
                            <a href="{{ route('kasir.transaksi-online.faktur') }}" class="block transition {{ request()->routeIs('kasir.transaksi-online.faktur') ? 'text-teal-300 font-bold' : 'text-gray-400 hover:text-teal-300' }}">Faktur</a>
                        </div>
                    </div>

                    <div>
                        <button @click="openOffline = !openOffline" class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition text-sm hover:bg-white/5 text-gray-300">
                            <div class="flex items-center gap-4">
                                <i class="fa-solid fa-cash-register"></i> Transaksi Offline
                            </div>
                            <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': openOffline }"></i>
                        </button>
                        <div x-show="openOffline" x-transition class="pl-11 pr-4 py-2 space-y-2 text-xs">
                            <a href="#" class="block text-gray-400 hover:text-teal-300 transition">Pembayaran</a>
                            <a href="#" class="block text-gray-400 hover:text-teal-300 transition">Faktur</a>
                        </div>
                    </div>

                    <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/5 text-gray-300 text-sm transition">
                        <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Pesanan
                    </a>
                </nav>
            </div>

            <div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-red-500/10 text-red-400 text-sm transition border-0 bg-transparent text-start">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 flex flex-col relative overflow-y-auto" style="background-image: url('{{ asset('images/background-bandeng.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; background-color: #03131f;">
            <div class="absolute inset-0 bg-[#03131f]/40 pointer-events-none"></div>
            <div class="relative z-10 flex flex-col flex-1">
                <header class="flex justify-end p-6">
                    <div class="px-5 py-1.5 rounded-lg card-glass text-xs font-semibold tracking-wider text-gray-300 shadow-lg flex items-center gap-2">
                        <i class="fa-solid fa-user-shield text-teal-400"></i>
                        <span>{{ $namaKasir }}</span>
                    </div>
                </header>
                <div class="px-8 pb-8 flex-1">
                    @yield('content')
                </div>
            </div>
        </main>

    @else
        <!-- ================= TAMPILAN CUSTOMER ================= -->
        <div class="app-container">
            <div class="sidebar">
                <div>
                    <div class="d-flex align-items-center mb-4">
                        <img src="{{ asset('image/Logo_Bandeng.png') }}" alt="Logo" style="width: 45px; height: auto;" class="me-3">
                        <div>
                            <h5 class="fw-bold mb-0 text-white" style="font-size: 1.15rem; letter-spacing: 1px;">WELCOME</h5>
                            <small class="text-white-50" style="font-size: 0.75rem;">Selamat Berbelanja</small>
                        </div>
                    </div>

                    <div class="user-profile-box d-flex align-items-center gap-3">
                        <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 38px; height: 38px; flex-shrink: 0;">
                            <i class="bi bi-person-fill fs-5"></i>
                        </div>
                        <div class="text-truncate">
                            <h6 class="mb-0 fw-semibold text-white text-truncate" style="font-size: 0.9rem;">
                                {{ Auth::check() ? Auth::user()->nama : 'Customer' }}
                            </h6>
                        </div>
                    </div>

                    <div>
                        <a href="{{ route('pesanan.index') }}" class="nav-link-custom {{ request()->routeIs('pesanan.index') ? 'active' : '' }}">
                            <i class="bi bi-house-door-fill me-3 fs-5"></i> Beranda
                        </a>
                        <a href="{{ route('pesanan.keranjang') }}" class="nav-link-custom {{ request()->routeIs('pesanan.keranjang') ? 'active' : '' }}">
                            <i class="bi bi-cart-fill me-3 fs-5"></i> Keranjang
                        </a>
                        <a href="{{ route('pesanan.riwayat') }}" class="nav-link-custom {{ request()->routeIs('pesanan.riwayat') ? 'active' : '' }}">
                            <i class="bi bi-clock-history me-3 fs-5"></i> Riwayat Pesanan
                        </a>
                        <a href="{{ route('pesanan.notifikasi') }}" class="nav-link-custom {{ request()->routeIs('pesanan.notifikasi') ? 'active' : '' }}">
                            <i class="bi bi-bell-fill me-3 fs-5"></i> Notifikasi
                        </a>
                    </div>
                </div>

                <div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link-custom w-100 text-start border-0 bg-transparent text-white fw-semibold">
                            <i class="bi bi-box-arrow-right me-3 fs-5"></i> Logout
                        </button>
                    </form>
                </div>
            </div>

            <div class="main-content">
                <div class="d-flex justify-content-end align-items-center gap-3 mb-4">
                    <form action="{{ route('pesanan.index') }}" method="GET" class="position-relative" style="width: 260px;">
                        <input type="text" name="cari" class="form-control search-input py-2" placeholder="Cari bandeng..." value="{{ request('cari') }}">
                        <button type="submit" class="position-absolute top-50 end-0 translate-middle-y me-3 text-white-50 border-0 bg-transparent p-0" style="cursor: pointer;">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>

                    <a href="{{ route('pesanan.notifikasi') }}" class="icon-btn text-decoration-none position-relative">
                        <i class="bi bi-bell-fill"></i>
        
                        @php
                        $customerId = \Illuminate\Support\Facades\Auth::user()->id_customer ?? null;
                        $jumlahNotif = \Illuminate\Support\Facades\DB::table('transaksi_penjualan')
                                                    ->where('id_customer', $customerId)
                                                    ->where('status_pembayaran', 'Belum Lunas')
                                                    ->count();
                        @endphp

                        @if($jumlahNotif > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" 
                                    style="font-size: 0.65rem; border: 2px solid #0f1c2d;">
                                {{ $jumlahNotif }}
                            </span>
                        @endif
                    </a>
                </div>

                @yield('content')
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @endif

    @stack('scripts')
</body>
</html>