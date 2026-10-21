
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Bandeng Samudera Temanggung</title>

    <link rel="stylesheet" href="{{ asset('css/bandeng.css') }}">
</head>

<body class="bandeng-page">

    
    <main class="hero" id="beranda">

        <header class="navbar">

            <a href="#beranda" class="brand">
                <img src="{{ asset('images/logo.png') }}"
                     alt="Logo Bandeng Samudera">
            </a>

            <nav class="nav-links" id="navLinks">
                <a href="#beranda" class="active">Beranda</a>
                <a href="#tentang">Tentang Kami</a>
                <a href="#produk">Bandeng</a>
                <a href="#cara-pesan">Cara Pesan</a>
                <a href="#kontak">Kontak</a>
            </nav>

            <div class="nav-actions">

                <form class="search-box" id="searchForm">
                    <span>⌕</span>
                    <input
                        type="search"
                        id="searchInput"
                        placeholder="Cari bandeng Samudera"
                        aria-label="Cari produk">
                </form>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="login-link">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="login-link">
                            Login
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="register-button">
                                Registrasi
                            </a>
                        @endif
                    @endauth
                @endif

            </div>

            <button
                type="button"
                class="menu-toggle"
                id="menuToggle"
                aria-label="Buka menu"
                aria-expanded="false">
                ☰
            </button>

        </header>

      
        <section class="hero-content">

            <div class="hero-text">

                <p class="eyebrow">SISTEM INFORMASI</p>

                <h1>
                    BANDENG <span>SAMUDERA</span><br>
                    TEMANGGUNG
                </h1>

                <p class="description">
                    Bandeng segar berkualitas dari Temanggung untuk
                    Anda dan keluarga. Daging tebal, gurih, dan higienis.
                </p>

                
                <div class="features">

                    <div class="feature">
                        <span class="feature-icon">✳</span>
                        <div>
                            <strong>Segar</strong>
                            <small>Setiap Hari</small>
                        </div>
                    </div>

                    <div class="feature">
                        <span class="feature-icon">✥</span>
                        <div>
                            <strong>Berkualitas</strong>
                            <small>Pilihan Terbaik</small>
                        </div>
                    </div>

                    <div class="feature">
                        <span class="feature-icon">♢</span>
                        <div>
                            <strong>Higienis</strong>
                            <small>Kebersihan Terjaga</small>
                        </div>
                    </div>

                </div>

               
                <article class="product-card" id="produk">

                    <div class="product-thumb">
                        <img
                            src="{{ asset('images/bandeng.png') }}"
                            alt="Produk Bandeng Samudera">
                    </div>

                    <div class="product-info">
                        <h2>Bandeng Samudera</h2>
                        <p>
                            Bandeng segar premium, daging tebal,
                            gurih, dan berkualitas.
                        </p>
                    </div>

                    <div class="product-action">
                        <strong class="price">Rp 35.000 / ekor</strong>

                        <a href="#detail-produk" class="detail-button">
                            Lihat Detail
                        </a>
                    </div>

                </article>

            </div>

        
            <div class="hero-visual">

                <div class="glow"></div>
                <div class="decoration"></div>

                <span class="leaf leaf-one">🍃</span>
                <span class="leaf leaf-two">🌿</span>
                <span class="leaf leaf-three">🍃</span>

                <div class="main-product-image">
                    <img
                        src="{{ asset('images/bandeng.png') }}"
                        alt="Foto Bandeng Samudera Temanggung">
                </div>

            </div>

        </section>

    </main>

    
    <section class="information-section" id="tentang">

        <p class="section-label">TENTANG KAMI</p>

        <h2>Bandeng Berkualitas untuk Keluarga</h2>

        <p>
            Bandeng Samudera Temanggung menyediakan bandeng
            berkualitas untuk memenuhi kebutuhan keluarga Anda.
        </p>

    </section>

    <section class="information-section order-section" id="cara-pesan">

        <p class="section-label">CARA PESAN</p>

        <h2>Mudah Memesan Bandeng Favoritmu</h2>

        <div class="order-steps">

            <article class="step-card">
                <span>01</span>
                <h3>Pilih Produk</h3>
                <p>Lihat informasi dan harga bandeng.</p>
            </article>

            <article class="step-card">
                <span>02</span>
                <h3>Buat Pesanan</h3>
                <p>Masuk ke akun dan lengkapi pesanan.</p>
            </article>

            <article class="step-card">
                <span>03</span>
                <h3>Lakukan Pembayaran</h3>
                <p>Ikuti petunjuk pembayaran yang tersedia.</p>
            </article>

        </div>

    </section>

    
    <footer class="footer" id="kontak">

        <strong>Bandeng Samudera Temanggung</strong>

        <p>Temanggung, Jawa Tengah</p>

        <p>
            © {{ date('Y') }} Sistem Informasi Bandeng Samudera
        </p>

    </footer>


    <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
