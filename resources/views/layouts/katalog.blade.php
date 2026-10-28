<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Bandeng Samudra Temanggung')</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <style>
    /* Pengaman Total agar tidak ada elemen yang memaksa geser horizontal */
    html, body {
      width: 100%;
      max-width: 100vw;
      overflow-x: hidden !important;
      margin: 0;
      padding: 0;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background-color: #02121e;
      color: #ffffff;
      min-height: 100vh;
      position: relative;
    }

    /* Background fixed */
    body::before {
      content: "";
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background-image: 
        linear-gradient(rgba(2, 18, 30, 0.4), rgba(2, 18, 30, 0.15)),
        url("{{ asset('image/bg.jpeg') }}");
      background-size: cover;
      background-position: center top;
      background-repeat: no-repeat;
      z-index: -1;
    }

    /* Navbar Utama - Dikunci agar tidak over-width */
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 30px;
      height: 90px;
      border-bottom: 1px solid rgba(0, 229, 255, 0.15);
      background: rgba(2, 18, 30, 0.65);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      position: sticky;
      top: 0;
      z-index: 1000;
      width: 100%;
      max-width: 100vw;
    }

    .nav-brand {
      display: flex;
      align-items: center;
      flex-shrink: 0;
    }

    .nav-brand a {
      position: relative; 
      display: inline-flex; 
      align-items: center; 
      justify-content: center; 
      text-decoration: none; 
      width: 110px; 
      height: 75px;
    }

    .nav-menu {
      display: flex;
      gap: 35px;
      list-style: none;
      height: 100%;
      align-items: center;
    }

    .nav-menu a {
      color: #90a4ae;
      text-decoration: none;
      font-size: 17px;
      font-weight: 500;
      position: relative;
      height: 100%;
      display: flex;
      align-items: center;
      transition: color 0.3s;
    }

    .nav-menu a:hover {
      color: #00e5ff;
    }

    .nav-menu a.active {
      color: #ffffff;
      font-weight: 600;
    }

    .nav-menu a.active::after {
      content: '';
      position: absolute;
      bottom: -1px;
      left: 0;
      width: 100%;
      height: 3.5px;
      background-color: #00e5ff;
      border-radius: 2px 2px 0 0;
      box-shadow: 0 0 12px #00e5ff;
    }

    .nav-right {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .search-box {
      display: flex;
      align-items: center;
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(0, 229, 255, 0.3);
      padding: 8px 18px;
      border-radius: 20px;
      gap: 10px;
      color: #90a4ae;
      font-size: 14px;
      backdrop-filter: blur(5px);
    }

    .search-box input {
      background: transparent;
      border: none;
      outline: none;
      color: #ffffff;
      font-size: 14px;
      max-width: 120px; /* Batasi lebar input agar tidak dorong elemen lain */
    }

    .search-box input::placeholder {
      color: #90a4ae;
    }

    .btn-auth {
      text-decoration: none;
      font-size: 15px;
      font-weight: 500;
      padding: 9px 22px;
      border-radius: 8px;
      transition: all 0.3s;
      white-space: nowrap; /* Mencegah teks tombol turun atau melebar */
    }

    .btn-login {
      color: #ffffff;
    }

    .btn-login:hover {
      color: #00e5ff;
    }

    .btn-register {
      background: #ffffff;
      color: #02121e;
      font-weight: 600;
    }

    .btn-register:hover {
      background: #00e5ff;
    }
  </style>
  
  @yield('styles')
</head>
<body>

  <!-- Navbar Katalog -->
  <nav class="navbar">
    <div class="nav-brand">
      <a href="{{ url('/') }}">
        <img src="{{ asset('image/Logo_Bandeng.png') }}" alt="Logo" style="width: 100%; height: 100%; object-fit: contain; mix-blend-mode: screen; filter: drop-shadow(0 0 2px rgba(0,229,255,0.4));">
        <img src="{{ asset('image/Nama_Logo.png') }}" alt="Bandeng Samudera" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 92%; height: auto; object-fit: contain; mix-blend-mode: screen; filter: brightness(2) contrast(1.5);">
      </a>
    </div>

    <ul class="nav-menu">
      <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a></li>
      <li><a href="{{ url('/tentang-kami') }}" class="{{ request()->is('tentang-kami') ? 'active' : '' }}">Tentang Kami</a></li>
      <li><a href="{{ url('/bandeng') }}" class="{{ request()->is('bandeng') ? 'active' : '' }}">Bandeng</a></li>
      <li><a href="{{ url('/cara-pesan') }}" class="{{ request()->is('cara-pesan') ? 'active' : '' }}">Cara Pesan</a></li>
      <li><a href="{{ url('/kontak') }}" class="{{ request()->is('kontak') ? 'active' : '' }}">Kontak</a></li>
    </ul>

    <div class="nav-range nav-right">
      <form action="{{ url('/bandeng') }}" method="GET" style="margin: 0; display: inline-block;">
        <div class="search-box">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari bandeng Sam...">
        </div>
      </form>
      
      <a href="{{ route('login') }}" class="btn-auth btn-login">Login</a>
      <a href="{{ route('register') }}" class="btn-auth btn-register">Registrasi</a>
    </div>
  </nav>

  <!-- Bagian Konten Katalog -->
  <main>
    @yield('content')
  </main>

</body>
</html>