<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandeng Samudera</title>
</head>
<body style="margin: 0; font-family: sans-serif; display: flex; min-height: 100vh;">

    <!-- SIDEBAR NAVIGASI CUSTOMER -->
    <div style="width: 250px; background-color: #0f2a4a; color: white; padding: 20px; display: flex; flex-direction: column; justify-content: space-between;">
        <div>
           
            <!-- Header / Logo -->
            <h2>WELCOME</h2>
            <p style="font-size: 14px; color: #ccc;">Selamat Berbelanja</p>
            <hr style="border-color: #1e406d; margin-bottom: 20px;">

            <!-- Info Customer -->
            <div style="margin-bottom: 25px;">
                <strong>👤 Customer</strong>
            </div>

            <!-- Menu Navigasi Utamanya -->
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="margin-bottom: 15px;">
                    <a href="{{ route('pesanan.index') }}" style="color: white; text-decoration: none; font-weight: bold;">🏠 Beranda</a>
                </li>
                <li style="margin-bottom: 15px;">
                    <a href="{{ route('pesanan.keranjang') }}" style="color: #bbb; text-decoration: none;">🛒 Keranjang</a>
                </li>
                <li style="margin-bottom: 15px;">
                    <a href="#" style="color: #bbb; text-decoration: none;">📑 Riwayat Pesanan</a>
                </li>
                <li style="margin-bottom: 15px;">
                    <a href="#" style="color: #bbb; text-decoration: none;">🔔 Notifikasi</a>
                </li>
            </ul>
        </div>

        <!-- Tombol Logout -->
        <div>
            <a href="#" style="color: #ff6b6b; text-decoration: none; font-weight: bold;">🚪 Logout</a>
        </div>
    </div>

    <!-- KONTEN UTAMA HALAMAN -->
    <div style="flex: 1; padding: 30px; background-color: #f4f7f6;">
        <!-- Bar Pencarian Atas -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <input type="text" placeholder="Cari..." style="padding: 8px 15px; width: 300px; border-radius: 20px; border: 1px solid #ccc;">
            <div>🔔</div>
        </div>

        <!-- Konten Dinamis dari Halaman Lain -->
        @yield('content')
    </div>

</body>
</html>