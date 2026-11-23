<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Bandeng Samudera'); ?></title>

    <?php
        $isAdmin = request()->is('admin*');
        $isKasir = request()->is('kasir*');
        $isKaryawan = request()->is('karyawan*');

        $namaKasir = session('nama_kasir') 
                    ?? optional(\Illuminate\Support\Facades\Auth::user())->nama 
                    ?? 'Kasir';
    ?>

    <?php if($isKasir): ?>
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
    <?php else: ?>
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
                display: flex; cursor: pointer; position: relative; z-index: 20;
                transition: all 0.25s ease;
            }
            .user-profile-box:hover {
                background: rgba(0, 180, 216, 0.18);
                border-color: rgba(0, 180, 216, 0.55);
                transform: translateY(-1px);
            }
            .main-content {
                flex-grow: 1; margin-left: 270px; width: calc(100vw - 270px); height: 100vh;
                overflow-y: auto !important; background-image: linear-gradient(rgba(10, 28, 48, 0.65), rgba(10, 28, 48, 0.65)), 
                url("<?php echo e(asset('image/Daftar_Akun.png')); ?>"); background-size: cover; background-position: center;
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
    <?php endif; ?>

    <style>
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
</head>
<body class="<?php echo e($isKasir ? 'text-white flex h-screen overflow-hidden' : ''); ?>">

    <?php if($isKasir): ?>
        <aside class="w-64 bg-sidebar flex flex-col justify-between p-6 border-r border-teal-900/30 z-10">
            <div>
                <div class="flex items-center gap-3 mb-8">
                    <img src="<?php echo e(asset('images/logo-ikan.png')); ?>" alt="Logo Bandeng Samudera" class="w-12 h-12 object-contain drop-shadow-[0_0_8px_rgba(20,184,166,0.5)]">
                    <h1 class="text-xl font-black tracking-wider text-white">WELCOME</h1>
                </div>

                <div class="flex items-center gap-3 mb-8 px-2">
                    <div class="w-9 h-9 rounded-full bg-teal-700/50 flex items-center justify-center text-white">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <span class="font-medium text-sm"><?php echo e($namaKasir); ?></span>
                </div>

                <nav class="space-y-2" x-data="{ 
                    openOnline: <?php echo e(request()->routeIs('kasir.online.pembayaran') || request()->routeIs('kasir.transaksi-online.faktur') ? 'true' : 'false'); ?>, 
                    openOffline: <?php echo e(request()->routeIs('kasir.offline.*') ? 'true' : 'false'); ?> 
                }">
                    <a href="<?php echo e(route('kasir.dashboard')); ?>" class="flex items-center gap-4 px-4 py-3 rounded-xl transition text-sm font-medium <?php echo e(request()->routeIs('kasir.dashboard') ? 'bg-gradient-to-r from-teal-600 to-teal-800 text-white shadow-lg shadow-teal-900/40' : 'hover:bg-white/5 text-gray-300'); ?>">
                        <i class="fa-solid fa-house <?php echo e(request()->routeIs('kasir.dashboard') ? 'text-teal-300' : 'text-gray-400'); ?>"></i> Beranda
                    </a>

                    <div>
                        <button @click="openOnline = !openOnline" class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition text-sm <?php echo e(request()->routeIs('kasir.online.pembayaran') || request()->routeIs('kasir.transaksi-online.faktur') ? 'bg-white/5 text-teal-300 font-semibold' : 'hover:bg-white/5 text-gray-300'); ?>">
                            <div class="flex items-center gap-4">
                                <i class="fa-solid fa-desktop"></i> Transaksi Online
                            </div>
                            <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': openOnline }"></i>
                        </button>
                        <div x-show="openOnline" x-transition class="pl-11 pr-4 py-2 space-y-2 text-xs">
                            <a href="<?php echo e(route('kasir.online.pembayaran')); ?>" class="block transition <?php echo e(request()->routeIs('kasir.online.pembayaran') ? 'text-teal-300 font-bold' : 'text-gray-400 hover:text-teal-300'); ?>">Pembayaran</a>
                            <a href="<?php echo e(route('kasir.transaksi-online.faktur')); ?>" class="block transition <?php echo e(request()->routeIs('kasir.transaksi-online.faktur') ? 'text-teal-300 font-bold' : 'text-gray-400 hover:text-teal-300'); ?>">Faktur</a>
                        </div>
                    </div>

                    <div>
                        <button @click="openOffline = !openOffline" class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition text-sm <?php echo e(request()->routeIs('kasir.offline.*') ? 'bg-white/5 text-teal-300 font-semibold' : 'hover:bg-white/5 text-gray-300'); ?>">
                            <div class="flex items-center gap-4">
                                <i class="fa-solid fa-cash-register"></i> Transaksi Offline
                            </div>
                            <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': openOffline }"></i>
                        </button>
                        <div x-show="openOffline" x-transition class="pl-11 pr-4 py-2 space-y-2 text-xs">
                            <a href="<?php echo e(route('kasir.offline.index')); ?>" class="block transition <?php echo e(request()->routeIs('kasir.offline.index') ? 'text-teal-300 font-bold' : 'text-gray-400 hover:text-teal-300'); ?>">Penjualan Offline</a>
                            <a href="<?php echo e(route('kasir.offline.pembayaran')); ?>" class="block transition <?php echo e(request()->routeIs('kasir.offline.pembayaran') ? 'text-teal-300 font-bold' : 'text-gray-400 hover:text-teal-300'); ?>">Pembayaran</a>
                            <a href="<?php echo e(route('kasir.offline.faktur')); ?>" class="block transition <?php echo e(request()->routeIs('kasir.offline.faktur*') ? 'text-teal-300 font-bold' : 'text-gray-400 hover:text-teal-300'); ?>">Faktur</a>
                        </div>
                    </div>

                    <a href="<?php echo e(route('kasir.riwayat')); ?>" class="flex items-center gap-4 px-4 py-3 rounded-xl transition text-sm font-medium <?php echo e(request()->routeIs('kasir.riwayat') ? 'bg-gradient-to-r from-teal-600 to-teal-800 text-white shadow-lg shadow-teal-900/40' : 'hover:bg-white/5 text-gray-300'); ?>">
                        <i class="fa-solid fa-clock-rotate-left <?php echo e(request()->routeIs('kasir.riwayat') ? 'text-teal-300' : 'text-gray-400'); ?>"></i> Riwayat Pesanan
                    </a>
                </nav>
            </div>

            <div>
                <button type="button" onclick="bukaModalLogout()" class="w-full flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-red-500/10 text-red-400 text-sm transition border-0 bg-transparent text-start cursor-pointer">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </div>
        </aside>

        <main class="flex-1 flex flex-col relative overflow-y-auto" style="background-image: url('<?php echo e(asset('images/background-bandeng.png')); ?>'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; background-color: #03131f;">
            <div class="absolute inset-0 bg-[#03131f]/40 pointer-events-none"></div>
            <div class="relative z-10 flex flex-col flex-1">
                <header class="flex justify-end p-6">
                    <div class="px-5 py-1.5 rounded-lg card-glass text-xs font-semibold tracking-wider text-gray-300 shadow-lg flex items-center gap-2">
                        <i class="fa-solid fa-user-shield text-teal-400"></i>
                        <span><?php echo e($namaKasir); ?></span>
                    </div>
                </header>
                <div class="px-8 pb-8 flex-1">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>
        </main>

    <?php else: ?>
        <div class="app-container">
            <div class="sidebar">
                <div>
                    <div class="d-flex align-items-center mb-3">
                        <img src="<?php echo e(asset('image/Logo_Bandeng.png')); ?>" alt="Logo" style="width: 45px; height: auto;" class="me-3">
                        <div>
                            <h5 class="fw-bold mb-0 text-white" style="font-size: 1.15rem; letter-spacing: 1px;">WELCOME</h5>
                            <small class="text-white-50" style="font-size: 0.75rem;">Selamat Berbelanja</small>
                        </div>
                    </div>
                    <hr style="border-color: rgba(255, 255, 255, 0.1); margin-bottom: 20px;">

                    <?php if(Auth::check()): ?>
                        <a href="<?php echo e(route('customer.profil')); ?>"
                           title="Klik untuk edit profil"
                           class="user-profile-box d-flex align-items-center justify-content-between gap-2 text-decoration-none"
                           style="<?php echo e(request()->routeIs('customer.profil') ? 'background: rgba(0, 180, 216, 0.25); border-color: #00b4d8;' : ''); ?>">
                            <div class="d-flex align-items-center gap-3 text-truncate">
                                <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 38px; height: 38px; flex-shrink: 0;">
                                    <i class="bi bi-person-fill fs-5"></i>
                                </div>
                                <div class="text-truncate">
                                    <h6 class="mb-0 fw-semibold text-white text-truncate" style="font-size: 0.9rem;">
                                        <?php echo e(Auth::user()->nama); ?>

                                    </h6>
                                    <small class="text-white-50 d-block" style="font-size: 0.7rem;">Edit Profil</small>
                                </div>
                            </div>
                            <i class="bi bi-pencil-square text-info small"></i>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="user-profile-box d-flex align-items-center gap-3 text-decoration-none">
                            <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 38px; height: 38px; flex-shrink: 0;">
                                <i class="bi bi-person-fill fs-5"></i>
                            </div>
                            <div class="text-truncate">
                                <h6 class="mb-0 fw-semibold text-white text-truncate" style="font-size: 0.9rem;">
                                    Login Customer
                                </h6>
                            </div>
                        </a>
                    <?php endif; ?>

                    <div>
                        <a href="<?php echo e(route('pesanan.index')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('pesanan.index') ? 'active' : ''); ?>">
                            <i class="bi bi-house-door-fill me-3 fs-5"></i> Beranda
                        </a>
                        <a href="<?php echo e(route('pesanan.keranjang')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('pesanan.keranjang') ? 'active' : ''); ?>">
                            <i class="bi bi-cart-fill me-3 fs-5"></i> Keranjang
                        </a>
                        <a href="<?php echo e(route('pesanan.riwayat')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('pesanan.riwayat') ? 'active' : ''); ?>">
                            <i class="bi bi-clock-history me-3 fs-5"></i> Riwayat Pesanan
                        </a>
                        <a href="<?php echo e(route('pesanan.notifikasi')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('pesanan.notifikasi') ? 'active' : ''); ?>">
                            <i class="bi bi-bell-fill me-3 fs-5"></i> Notifikasi
                        </a>
                    </div>
                </div>
                <div>
                    <button type="button" onclick="bukaModalLogout()" class="nav-link-custom w-100 text-start border-0 bg-transparent text-white fw-semibold cursor-pointer" style="color: #ff6b6b !important;">
                        <i class="bi bi-box-arrow-right me-3 fs-5"></i> Logout
                    </button>
                </div>
            </div>

            <div class="main-content">
                <div class="d-flex justify-content-end align-items-center gap-3 mb-4">
                    <form action="<?php echo e(route('pesanan.index')); ?>" method="GET" class="position-relative" style="width: 260px;">
                        <input type="text" name="cari" class="form-control search-input py-2" placeholder="Cari bandeng..." value="<?php echo e(request('cari')); ?>">
                        <button type="submit" class="position-absolute top-50 end-0 translate-middle-y me-3 text-white-50 border-0 bg-transparent p-0" style="cursor: pointer;">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>

                    <a href="<?php echo e(route('pesanan.notifikasi')); ?>" class="icon-btn text-decoration-none position-relative">
                        <i class="bi bi-bell-fill"></i>
    
                        <?php
                        $customerId = \Illuminate\Support\Facades\Auth::user()->id_customer ?? null;
                        $jumlahNotif = \Illuminate\Support\Facades\DB::table('transaksi_penjualan')
                                                    ->where('id_customer', $customerId)
                                                    ->where('status_pembayaran', 'Belum Lunas')
                                                    ->count();
                        ?>

                        <?php if($jumlahNotif > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" 
                                style="font-size: 0.65rem; border: 2px solid #0f1c2d;">
                                <?php echo e($jumlahNotif); ?>

                            </span>
                        <?php endif; ?>
                    </a>
                </div>

                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php endif; ?>

    <!-- POP-UP KONFIRMASI LOGOUT -->
    <div id="modalLogout" class="logout-modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="judulModalLogout">
        <div class="logout-modal-card">
            <div class="logout-modal-icon">
                <?php if($isKasir): ?>
                    <i class="fa-solid fa-right-from-bracket"></i>
                <?php else: ?>
                    <i class="bi bi-box-arrow-right"></i>
                <?php endif; ?>
            </div>

            <div id="judulModalLogout" class="logout-modal-title">Yakin ingin Keluar ?</div>

            <form action="<?php echo e(route('logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="logout-btn-confirm">Ya, Keluar</button>
            </form>

            <button type="button" onclick="tutupModalLogout()" class="logout-btn-cancel">Batal</button>
        </div>
    </div>

    <script>
        function bukaModalLogout() {
            const modal = document.getElementById('modalLogout');
            if (modal) {
                modal.classList.add('is-open');
            }
        }

        function tutupModalLogout() {
            const modal = document.getElementById('modalLogout');
            if (modal) {
                modal.classList.remove('is-open');
            }
        }

        document.addEventListener('click', function (e) {
            const modal = document.getElementById('modalLogout');
            if (modal && e.target === modal) {
                tutupModalLogout();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                tutupModalLogout();
            }
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\laragon\www\Projek-Bandeng\resources\views/layouts/app.blade.php ENDPATH**/ ?>