<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Kurir - Bandeng Samudra</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #031c2b;
            color: white;
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
            background:
                radial-gradient(circle at 75% 20%, rgba(0, 225, 220, 0.18), transparent 35%),
                linear-gradient(135deg, #061b2c, #003b4b, #031522);
        }

        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: rgba(13, 48, 77, 0.96);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            border-right: 1px solid rgba(255,255,255,0.1);
        }

        .logo-area {
            height: 135px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 15px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .logo-area img {
            width: 85px;
            height: 85px;
            object-fit: contain;
            border-radius: 50%;
        }

        .logo-area h2 {
            font-size: 23px;
            font-weight: 700;
            color: white;
            text-shadow: 0 0 15px #00e5ff;
        }

        .profile-link {
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            text-decoration: none;
            color: white;
            background: rgba(16, 199, 187, 0.16);
            border-bottom: 1px solid rgba(83, 232, 214, 0.45);
            transition: 0.25s;
        }

        .profile-link:hover {
            background: rgba(16, 199, 187, 0.28);
        }

        .profile-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .profile-left i {
            font-size: 32px;
            color: #45d9e4;
        }

        .profile-name {
            font-size: 15px;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .profile-sub {
            font-size: 11px;
            color: #7ee8ef;
            display: block;
        }

        .menu {
            padding: 22px 14px;
            flex: 1;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 13px;
            color: #e8f5ff;
            text-decoration: none;
            padding: 13px 16px;
            margin-bottom: 10px;
            border-radius: 30px;
            font-size: 15px;
            transition: 0.3s;
        }

        .menu a i {
            width: 22px;
            font-size: 19px;
        }

        .menu a:hover,
        .menu a.active {
            background: linear-gradient(90deg, #087d85, #10c7bb);
            box-shadow: 0 0 18px rgba(0, 238, 225, 0.5);
            color: white;
        }

        .logout {
            padding: 25px;
        }

        .logout a {
            color: white;
            text-decoration: none;
            font-size: 15px;
        }

        .logout i {
            margin-right: 12px;
        }

        .main-content {
            flex: 1;
            padding: 34px;
            min-width: 0;
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: #ffb703;
            margin-bottom: 4px;
        }

        .page-subtitle {
            font-size: 13px;
            color: #b8d6df;
            margin-bottom: 24px;
        }

        .alert-success {
            background: rgba(8, 123, 88, 0.35);
            border: 1px solid #2ee59d;
            color: #c7ffea;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            max-width: 820px;
        }

        .alert-danger {
            background: rgba(220, 38, 38, 0.25);
            border: 1px solid #f87171;
            color: #fecaca;
            padding: 12px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 13px;
            max-width: 820px;
        }

        .panel {
            max-width: 820px;
            background: rgba(0, 20, 30, 0.55);
            border: 1px solid rgba(83, 232, 214, 0.65);
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 0 18px rgba(0, 220, 200, 0.14);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #9ec5d6;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px;
            border-radius: 11px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-family: inherit;
            font-size: 14px;
            outline: none;
            transition: 0.25s;
        }

        .form-group input:focus {
            border-color: #16d9ed;
            background: rgba(255, 255, 255, 0.14);
        }

        .form-group input[disabled] {
            background: rgba(255, 255, 255, 0.05);
            color: #8fb1c0;
            cursor: not-allowed;
        }

        .helper-text {
            font-size: 11px;
            color: #8fb1c0;
            margin-top: 5px;
        }

        .divider {
            border: none;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            margin: 24px 0 18px;
        }

        .section-note {
            font-size: 13px;
            color: #b8d6df;
            margin-bottom: 18px;
        }

        .form-actions {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-back {
            padding: 11px 22px;
            border-radius: 25px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            color: white;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: 0.25s;
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.12);
        }

        .btn-save {
            padding: 11px 26px;
            border-radius: 25px;
            border: none;
            background: linear-gradient(90deg, #087d85, #10c7bb);
            color: white;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 0 15px rgba(0, 238, 225, 0.35);
            transition: 0.25s;
        }

        .btn-save:hover {
            background: linear-gradient(90deg, #0a9aa4, #17e2d4);
        }

        @media (max-width: 768px) {
            .dashboard { flex-direction: column; }
            .sidebar { width: 100%; min-height: auto; }
            .form-grid { grid-template-columns: 1fr; }
            .main-content { padding: 18px; }
        }
    </style>
</head>
<body>

<div class="dashboard">
    <aside class="sidebar">
        <div class="logo-area">
            <img src="{{ asset('uploads/Bandeng-Gacor.jpeg') }}" alt="Logo Bandeng Samudra">
            <h2>WELCOME</h2>
        </div>

        <a href="{{ route('karyawan.profil') }}" class="profile-link" title="Edit Profil Kurir">
            <div class="profile-left">
                <i class="fas fa-circle-user"></i>
                <div style="min-width: 0;">
                    <div class="profile-name">{{ session('nama_karyawan') ?? $karyawan->nama }}</div>
                    <span class="profile-sub">Edit Profil</span>
                </div>
            </div>
            <i class="fas fa-pen-to-square" style="font-size: 14px; color: #45d9e4;"></i>
        </a>

        <nav class="menu">
            <a href="{{ url('/karyawan/beranda') }}">
                <i class="fas fa-house"></i>
                Dashboard
            </a>

            <a href="{{ url('/karyawan/konfirmasi') }}">
                <i class="far fa-square-check"></i>
                Konfirmasi Pengiriman
            </a>

            <a href="{{ url('/karyawan/data') }}">
                <i class="fas fa-box"></i>
                Data Pengiriman
            </a>

            <a href="{{ url('/karyawan/riwayat') }}">
                <i class="fas fa-clock-rotate-left"></i>
                Riwayat Pengiriman
            </a>
        </nav>

        <div class="logout">
            <a href="{{ url('/logout') }}">
                <i class="fas fa-right-from-bracket"></i>
                Logout
            </a>
        </div>
    </aside>

    <main class="main-content">
        <h1 class="page-title">Profil Kurir</h1>
        <p class="page-subtitle">Perbarui informasi pribadi dan akun kurir Anda</p>

        @if (session('success'))
            <div class="alert-success auto-hide-alert">
                <i class="fas fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-danger auto-hide-alert">
                <ul style="padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="panel">
            <form action="{{ route('karyawan.profil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group">
                        <label>ID Kurir (Otomatis)</label>
                        <input type="text" value="{{ $karyawan->id_karyawan }}" readonly disabled>
                        <p class="helper-text">ID dibuat otomatis oleh sistem dan tidak dapat diubah.</p>
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" value="{{ old('username', $karyawan->username) }}" required>
                    </div>

                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama', $karyawan->nama) }}" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', $karyawan->email) }}" placeholder="contoh@gmail.com">
                    </div>

                    <div class="form-group">
                        <label>No. Telepon / WhatsApp</label>
                        <input type="text" name="no_telp" value="{{ old('no_telp', $karyawan->no_telp) }}" placeholder="Contoh: 081234567890">
                    </div>

                    <div class="form-group">
                        <label>Status Akun</label>
                        <input type="text" value="{{ $karyawan->status ?? 'Aktif' }}" readonly disabled>
                    </div>
                </div>

                <hr class="divider">
                <p class="section-note">
                    <i class="fas fa-shield-halved" style="color: #45d9e4;"></i>
                    <strong>Ubah Password</strong> (Kosongkan jika tidak ingin mengganti password)
                </p>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" name="password" placeholder="Minimal 6 karakter">
                    </div>

                    <div class="form-group">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password baru">
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('karyawan.beranda') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                    </a>

                    <button type="submit" class="btn-save">
                        <i class="fas fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function () {
            document.querySelectorAll('.auto-hide-alert').forEach(function (el) {
                el.style.transition = 'opacity 0.5s ease';
                el.style.opacity = '0';
                setTimeout(function () { el.remove(); }, 500);
            });
        }, 3000);
    });
</script>
</body>
</html>