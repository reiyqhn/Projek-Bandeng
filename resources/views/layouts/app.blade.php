<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandeng Samudera</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }
        
        body, html {
            width: 100%;
            height: 100%;
            margin: 0;
            background-color: #0b1a2b;
            overflow: hidden; 
        }
        
        .app-container {
            display: flex;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        .sidebar {
            width: 270px;
            background: linear-gradient(180deg, #0f2b48 0%, #0a1c30 100%);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 25px 20px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
        }

        .nav-link-custom {
            color: rgba(255, 255, 255, 0.7);
            border-radius: 12px;
            padding: 12px 18px;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 0.9rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .nav-link-custom:hover, .nav-link-custom.active {
            background: linear-gradient(90deg, #00b4d8 0%, #0077b6 100%);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(0, 180, 216, 0.35);
        }

        .user-profile-box {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 10px 15px;
            margin-bottom: 25px;
        }

        .main-content {
            flex-grow: 1;
            margin-left: 270px; 
            width: calc(100vw - 270px);
            height: 100vh;
            overflow-y: auto !important; 
            background-image: linear-gradient(rgba(10, 28, 48, 0.65), rgba(10, 28, 48, 0.65)), 
                            url('{{ asset('image/Daftar_Akun.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            padding: 35px 45px;
            color: white;
        }

        .search-input {
            background: rgba(255, 255, 255, 0.15) !important;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.25) !important;
            border-radius: 20px !important;
            color: white !important;
            font-size: 0.85rem;
            padding-left: 20px;
            padding-right: 40px;
        }
        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }
        .icon-btn {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
        }

        .main-content::-webkit-scrollbar {
            width: 8px;
        }
        .main-content::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
        }
        .main-content::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
        }
    </style>
</head>
<body>

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

    @stack('scripts')

</body>
</html>