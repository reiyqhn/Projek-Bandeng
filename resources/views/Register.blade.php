
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Bandeng Samudra</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            background: #031b30;
            color: white;
        }

        .register-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
            padding: 45px 6%;
            background:
                radial-gradient(ellipse at 15% 80%, #07515a 0%, transparent 45%),
                linear-gradient(120deg, #0c3154, #021722 75%);
        }

        /* Bagian kiri */
        .welcome {
            width: 50%;
            text-align: center;
            padding: 20px;
        }

        .welcome h1 {
            font-size: clamp(45px, 6vw, 85px);
            font-weight: 900;
            letter-spacing: 3px;
            color: #ff9b35;
            transform: rotate(-5deg);
            margin-bottom: 35px;
        }

        .logo {
            font-size: 42px;
            font-weight: 900;
            line-height: 1.2;
            margin-bottom: 25px;
            text-shadow: 2px 3px 5px #000;
        }

        .logo span {
            color: #ff9b35;
        }

        .welcome h2 {
            font-size: clamp(27px, 3vw, 42px);
            line-height: 1.4;
            margin-bottom: 12px;
        }

        .welcome p {
            color: #c6d6df;
            font-size: 18px;
            line-height: 1.6;
        }

        /* Bagian kanan */
        .register-card {
            width: 430px;
            max-width: 100%;
            padding: 25px 28px;
            background: rgba(55, 133, 133, 0.48);
            border: 2px solid #c8f5f5;
            border-radius: 13px;
            backdrop-filter: blur(10px);
        }

        .register-card h2 {
            text-align: center;
            font-size: 35px;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;
            color: #d4e4e7;
            margin-bottom: 25px;
            font-size: 15px;
        }

        .form-group {
            margin-bottom: 17px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #b8d7e4;
            border-radius: 7px;
            outline: none;
            background: #111e4c;
            color: white;
            font-size: 14px;
        }

        .form-group input::placeholder {
            color: #aab5cf;
        }

        .form-group input:focus {
            border-color: #00e5ff;
            box-shadow: 0 0 5px rgba(0, 229, 255, 0.5);
        }

        .btn-register {
            display: block;
            margin: 25px auto 10px;
            padding: 12px 25px;
            border: 1px solid #b5e5f5;
            border-radius: 8px;
            background: linear-gradient(110deg, #b8d9d9, #1745e8);
            color: white;
            font-size: 17px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 229, 255, 0.3);
        }

        .login-link {
            text-align: center;
            font-size: 13px;
            color: #e2eeee;
        }

        .login-link a {
            color: white;
            font-weight: bold;
            text-decoration: none;
        }

        .login-link a:hover {
            color: #00e5ff;
        }

        .error-message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 6px;
            background: rgba(255, 0, 0, 0.2);
            color: #fff;
            font-size: 14px;
        }

        @media (max-width: 850px) {
            .register-page {
                flex-direction: column;
                justify-content: center;
                padding: 30px 18px;
            }

            .welcome {
                width: 100%;
                padding: 10px;
            }

            .welcome h1 {
                margin-bottom: 20px;
            }

            .logo {
                font-size: 30px;
            }

            .register-card {
                width: 430px;
            }
        }
    </style>
</head>

<body>

    <main class="register-page">

        <!-- Bagian kiri -->
        <section class="welcome">
            <h1>WELCOME</h1>

            <div class="logo">
                BANDENG<br>
                <span>SAMUDRA</span>
            </div>

            <h2>Bandeng <span style="color:#ff9b35;">Samudra</span><br>
                Temanggung
            </h2>

            <p>Lezatnya Tradisi, Segarnya Alami</p>
        </section>

        <!-- Form registrasi -->
        <section class="register-card">
            <h2>Daftar Akun</h2>
            <p class="subtitle">Lezatnya Tradisi, Segarnya Alami</p>

            @if ($errors->any())
                <div class="error-message">
                    <ul style="padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/register') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input
                        type="text"
                        id="nama"
                        name="name"
                        placeholder="Masukan nama Anda"
                        value="{{ old('name') }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="Masukan username unik"
                        value="{{ old('username') }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Contoh@gmail.com"
                        value="{{ old('email') }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                    >
                </div>

                <button type="submit" class="btn-register">
                    Daftar Sekarang
                </button>

                <p class="login-link">
                    Sudah punya akun?
                    <a href="{{ url('/login') }}">Masuk Sini</a>
                </p>
            </form>
        </section>

    </main>

</body>
