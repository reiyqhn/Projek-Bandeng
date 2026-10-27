
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bandeng Samudra</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            color: white;
            background: #05253d;
        }

        .login-page {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 25px;
            position: relative;
            overflow: hidden;
            background:
                radial-gradient(ellipse at 15% 80%,
                    #07515a 0%, transparent 48%),
                radial-gradient(ellipse at 90% 45%,
                    #315d40 0%, transparent 35%),
                linear-gradient(120deg, #123e60, #03202d);
        }

        /* Efek latar belakang */
        .login-page::before {
            content: "";
            position: absolute;
            inset: -20px;
            background:
                radial-gradient(ellipse at 80% 50%,
                    rgba(122, 145, 73, 0.35), transparent 40%),
                radial-gradient(ellipse at 20% 70%,
                    rgba(0, 100, 110, 0.5), transparent 45%);
            filter: blur(15px);
        }

        .login-card {
            position: relative;
            z-index: 1;
            width: 382px;
            max-width: 100%;
            padding: 25px 12px 22px;
            border: 2px solid #c8f5f5;
            border-radius: 11px;
            background: rgba(57, 132, 132, 0.48);
            backdrop-filter: blur(12px);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.12);
        }

        .logo {
            text-align: center;
            margin-bottom: 15px;
        }

        .logo img {
            width: 105px;
            height: 85px;
            object-fit: contain;
        }

        .logo-text {
            font-size: 20px;
            font-weight: bold;
            line-height: 1.1;
            text-shadow: 1px 2px 4px #000;
        }

        .login-card h1 {
            text-align: center;
            font-size: 27px;
            margin-bottom: 16px;
        }

        .form-group {
            margin-bottom: 19px;
        }

        .form-group label {
            display: block;
            margin-bottom: 9px;
            font-size: 16px;
        }

        .input-wrap {
            position: relative;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            height: 37px;
            padding: 9px 13px;
            border: 1px solid #a8c6e5;
            border-radius: 6px;
            background: #111f4b;
            color: white;
            font-size: 13px;
            outline: none;
        }

        .form-group input::placeholder {
            color: #9aa8c6;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #00e5ff;
            box-shadow: 0 0 5px rgba(0, 229, 255, 0.4);
        }

        .password-input {
            padding-right: 45px !important;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: white;
            cursor: pointer;
            font-size: 18px;
        }

        .btn-login {
            display: block;
            width: 58%;
            margin: 37px auto 8px;
            padding: 8px 15px;
            border: 1px solid #b5e5f5;
            border-radius: 7px;
            background: linear-gradient(110deg, #c4dddd, #f4f4f4);
            color: #45616b;
            font-size: 17px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #00e5ff;
            color: #05253d;
        }

        .register-link {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            color: #e0eeee;
        }

        .register-link a {
            color: white;
            text-decoration: none;
        }

        .register-link a:hover {
            color: #00e5ff;
        }

        .error-message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 6px;
            background: rgba(255, 0, 0, 0.2);
            font-size: 13px;
        }

        @media (max-width: 480px) {
            .login-page {
                padding: 18px;
            }

            .login-card {
                padding: 24px 16px;
            }
        }
    </style>
</head>

<body>

    <main class="login-page">

        <section class="login-card">

            <div class="logo">
                <!-- Logo sementara berupa teks.
                     Ganti dengan gambar logo jika sudah tersedia. -->
                <div class="logo-text">
                    BANDENG<br>SAMUDRA
                </div>
            </div>

            <h1>Login</h1>

            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST">
                @csrf

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
                    <label for="password">Password</label>

                    <div class="input-wrap">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="password-input"
                            placeholder="Masukkan password"
                            required
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            onclick="togglePassword()"
                            aria-label="Tampilkan atau sembunyikan password"
                        >◉</button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="role">Pilih Role</label>
                    <select id="role" name="role" required>
                        <option value="customer">Customer</option>
                        <option value="admin">Admin</option>
                        <option value="kasir">Kasir</option>
                    </select>
                </div>

                <button type="submit" class="btn-login">
                    Masuk
                </button>

                <p class="register-link">
                    Belum punya Akun?
                    <a href="{{ url('/register') }}">Daftar Sini</a>
                </p>

            </form>

        </section>

    </main>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');

            if (password.type === 'password') {
                password.type = 'text';
            } else {
                password.type = 'password';
            }
        }
    </script>

</body>
