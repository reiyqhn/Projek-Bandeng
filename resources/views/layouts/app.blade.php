<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Kasir') - Bandeng Samudera</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { 
            background-color: #03131f; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        }
        
        /* Sidebar transparan tembus pandang menyatu dengan background */
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
</head>
<body class="text-white flex h-screen overflow-hidden">

    <!-- SIDEBAR KHUSUS KASIR -->
    <aside class="w-64 bg-sidebar flex flex-col justify-between p-6 border-r border-teal-900/30 z-10">
        <div>
            <!-- Logo Ikan & WELCOME Sejajar -->
            <div class="flex items-center gap-3 mb-8">
                <img src="{{ asset('images/logo-ikan.png') }}" alt="Logo Bandeng Samudera" class="w-12 h-12 object-contain drop-shadow-[0_0_8px_rgba(20,184,166,0.5)]">
                <h1 class="text-xl font-black tracking-wider text-white">WELCOME</h1>
            </div>

            <!-- User Profile Kasir -->
            <div class="flex items-center gap-3 mb-8 px-2">
                <div class="w-9 h-9 rounded-full bg-teal-700/50 flex items-center justify-center text-white">
                    <i class="fa-solid fa-user"></i>
                </div>
                <span class="font-medium text-sm">Theresia</span>
            </div>

            <!-- Navigation Menu Kasir dengan Alpine.js Dropdown -->
            <nav class="space-y-2" x-data="{ 
                openOnline: {{ request()->routeIs('kasir.online.pembayaran') || request()->routeIs('kasir.transaksi-online.faktur') ? 'true' : 'false' }}, 
                openOffline: false 
            }">
                
                <!-- Beranda -->
                <a href="{{ route('kasir.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition text-sm font-medium {{ request()->routeIs('kasir.dashboard') ? 'bg-gradient-to-r from-teal-600 to-teal-800 text-white shadow-lg shadow-teal-900/40' : 'hover:bg-white/5 text-gray-300' }}">
                    <i class="fa-solid fa-house {{ request()->routeIs('kasir.dashboard') ? 'text-teal-300' : 'text-gray-400' }}"></i> Beranda
                </a>

                <!-- Transaksi Online (Dropdown) -->
                <div>
                    <button @click="openOnline = !openOnline" class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition text-sm {{ request()->routeIs('kasir.online.pembayaran') || request()->routeIs('kasir.transaksi-online.faktur') ? 'bg-white/5 text-teal-300 font-semibold' : 'hover:bg-white/5 text-gray-300' }}">
                        <div class="flex items-center gap-4">
                            <i class="fa-solid fa-desktop"></i> Transaksi Online
                        </div>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': openOnline }"></i>
                    </button>
                    <!-- Submenu Online -->
                    <div x-show="openOnline" x-transition class="pl-11 pr-4 py-2 space-y-2 text-xs">
                        <a href="{{ route('kasir.online.pembayaran') }}" class="block transition {{ request()->routeIs('kasir.online.pembayaran') ? 'text-teal-300 font-bold' : 'text-gray-400 hover:text-teal-300' }}">Pembayaran</a>
                        <a href="{{ route('kasir.transaksi-online.faktur') }}" class="block transition {{ request()->routeIs('kasir.transaksi-online.faktur') ? 'text-teal-300 font-bold' : 'text-gray-400 hover:text-teal-300' }}">Faktur</a>
                    </div>
                </div>

                <!-- Transaksi Offline (Dropdown) -->
                <div>
                    <button @click="openOffline = !openOffline" class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition text-sm hover:bg-white/5 text-gray-300">
                        <div class="flex items-center gap-4">
                            <i class="fa-solid fa-cash-register"></i> Transaksi Offline
                        </div>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': openOffline }"></i>
                    </button>
                    <!-- Submenu Offline -->
                    <div x-show="openOffline" x-transition class="pl-11 pr-4 py-2 space-y-2 text-xs">
                        <a href="#" class="block text-gray-400 hover:text-teal-300 transition">Pembayaran</a>
                        <a href="#" class="block text-gray-400 hover:text-teal-300 transition">Faktur</a>
                    </div>
                </div>

                <!-- Riwayat Pesanan -->
                <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/5 text-gray-300 text-sm transition">
                    <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Pesanan
                </a>
            </nav>
        </div>

        <!-- Logout -->
        <div>
            <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-red-500/10 text-red-400 text-sm transition">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT (Background Gambar .png) -->
    <main class="flex-1 flex flex-col relative overflow-y-auto" style="background-image: url('{{ asset('images/background-bandeng.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; background-color: #03131f;">
        
        <!-- Overlay transparan gelap tipis agar teks tetap kontras -->
        <div class="absolute inset-0 bg-[#03131f]/40 pointer-events-none"></div>

        <!-- Konten Utama -->
        <div class="relative z-10 flex flex-col flex-1">
            <!-- Top Navbar Badge -->
            <header class="flex justify-end p-6">
                <div class="px-5 py-1.5 rounded-lg card-glass text-xs font-semibold tracking-wider text-gray-300 shadow-lg">
                    Kasir
                </div>
            </header>

            <!-- Dynamic Content -->
            <div class="px-8 pb-8 flex-1">
                @yield('content')
            </div>
        </div>

    </main>

</body>
</html>