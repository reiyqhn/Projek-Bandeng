<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bandeng Samudera</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .login-bg-wrapper {
            min-height: 100vh;
            width: 100%;
            background-image: linear-gradient(rgba(13, 35, 58, 0.5), rgba(13, 35, 58, 0.5)), url("{{ asset('image/Daftar_Akun.png') }}");
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            background-attachment: fixed; 
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 15px;
            position: relative;
        }

        .glass-card {
            background: rgba(22, 53, 77, 0.55);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 20px;
            border: 1.5px solid rgba(255, 255, 255, 0.7);
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        .back-to-catalog {
            position: absolute;
            top: 25px;
            left: 25px;
            color: #ffffff;
            text-decoration: none;
            font-size: 0.9rem;
            background: rgba(22, 53, 77, 0.65);
            border: 1px solid rgba(0, 229, 255, 0.3);
            padding: 8px 16px;
            border-radius: 20px;
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .back-to-catalog:hover {
            background: rgba(0, 229, 255, 0.2);
            color: #00e5ff;
            border-color: rgba(0, 229, 255, 0.6);
        }
    </style>
</head>
<body>

<div class="login-bg-wrapper">
    <!-- Tombol Kembali ke Katalog di Pojok Kiri Atas -->
    <a href="{{ url('/') }}" class="back-to-catalog">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog
    </a>

    <div class="glass-card p-4 p-md-5 my-auto">
        
        <div class="text-center mb-2 position-relative d-flex justify-content-center">
            <div style="position: relative; display: inline-block; width: 140px;">
                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 160px; height: 160px; background: radial-gradient(circle, rgba(255, 255, 255, 0.25) 0%, rgba(64, 158, 155, 0.15) 50%, rgba(0, 0, 0, 0) 75%); border-radius: 50%; filter: blur(15px); pointer-events: none; z-index: 1;"></div>

                <img src="{{ asset('image/Logo_Bandeng.png') }}" alt="Icon Bandeng" style="width: 100%; height: auto; position: relative; z-index: 2;" class="img-fluid">
                
                <img src="{{ asset('image/Nama_Logo.png') }}" alt="Teks Bandeng Samudera" style="position: absolute; top: 48%; left: 50%; transform: translate(-50%, -50%); width: 110%; height: auto; z-index: 3; pointer-events: none;">
            </div>
        </div>

        <h2 class="fw-bold text-white text-center mb-3" style="font-family: 'Arial Black', sans-serif; letter-spacing: 0.5px; font-size: 1.75rem;">
            Login
        </h2>

        @if (session('success'))
            <div class="alert alert-success py-1 px-2 mb-3 small text-center" style="border-radius: 6px; font-size: 0.8rem;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger py-1 px-2 mb-3 small" style="border-radius: 6px; font-size: 0.75rem;">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.proses') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label text-white mb-1" style="font-size: 0.85rem; font-weight: 500;">Username</label>
                <input type="text" name="username" class="form-control text-white py-2 px-3" placeholder="Masukan username Unik" value="{{ old('username') }}" style="background: #111d33; border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; font-size: 0.85rem;" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-white mb-1" style="font-size: 0.85rem; font-weight: 500;">Password</label>
                <div class="position-relative">
                    <input type="password" id="passwordInput" name="password" class="form-control text-white py-2 ps-3 pe-5" placeholder="••••••••••••" style="background: #111d33; border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; font-size: 0.85rem;" required>
                    <i class="bi bi-eye-slash-fill text-white-50 position-absolute top-50 end-0 translate-middle-y me-3" id="togglePassword" style="cursor: pointer; font-size: 1.1rem;"></i>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label text-white mb-1" style="font-size: 0.85rem; font-weight: 500;">Pilih Role</label>
                <select name="role" class="form-select text-white py-2 px-3" style="background: #111d33; border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; font-size: 0.85rem; color: #fff;" required>
                    <option value="customer" selected style="background: #111d33; color: #fff;">Customer</option>
                    <option value="admin" style="background: #111d33; color: #fff;">Admin</option>
                    <option value="kasir" style="background: #111d33; color: #fff;">Kasir</option>
                    <option value="karyawan" style="background: #111d33; color: #fff;">Karyawan</option>
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="btn fw-bold px-4 py-2 shadow-sm mb-3" style="background: linear-gradient(180deg, #b0bec5 0%, #78909c 100%); color: #0d233a; border-radius: 10px; font-size: 0.95rem; border: 1px solid rgba(255,255,255,0.5); width: 60%;">
                    Masuk
                </button>
            </div>

            <div class="text-center">
                <span class="text-white-50" style="font-size: 0.75rem;">Belum punya Akun? </span>
                <a href="{{ route('register') }}" class="text-white fw-semibold text-decoration-underline" style="font-size: 0.75rem;">Daftar Sini</a>
            </div>
        </form>

    </div>
</div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#passwordInput');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('bi-eye-fill');
        this.classList.toggle('bi-eye-slash-fill');
    });
</script>

</body>
</html>