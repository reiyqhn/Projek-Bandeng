@extends('layouts.app')

@section('title', 'Kontak - Bandeng Samudra')

@section('styles')
  <style>
    /* KONTEN KONTAK */
    .contact-container {
      max-width: 1100px;
      margin: 60px auto;
      padding: 20px;
      text-align: center;
    }

    .contact-container h1 {
      color: #00e5ff;
      font-size: 38px;
      margin-bottom: 15px;
    }

    .contact-description {
      color: #cfd8dc;
      line-height: 1.8;
      max-width: 650px;
      margin: 0 auto 35px;
    }

    .contact-card {
      max-width: 650px;
      margin: 0 auto;
      padding: 35px 25px;
      background: rgba(13, 38, 59, 0.55);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid rgba(0, 229, 255, 0.25);
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
    }

    .contact-icon {
      font-size: 48px;
      margin-bottom: 15px;
    }

    .contact-card h2 {
      color: #ffffff;
      margin-bottom: 15px;
    }

    .contact-card p {
      color: #cfd8dc;
      line-height: 1.8;
      margin-bottom: 25px;
    }

    /* TOMBOL WHATSAPP */
    .btn-wa {
      display: inline-block;
      padding: 13px 25px;
      background: #25d366;
      color: #ffffff;
      text-decoration: none;
      font-weight: bold;
      border-radius: 8px;
      transition: 0.3s;
    }

    .btn-wa:hover {
      background: #1ebe5d;
      transform: translateY(-2px);
    }

    /* TOMBOL BERANDA */
    .btn-home {
      display: inline-block;
      margin-top: 30px;
      padding: 12px 22px;
      border: 1px solid #00e5ff;
      border-radius: 8px;
      color: #00e5ff;
      text-decoration: none;
      transition: 0.3s;
    }

    .btn-home:hover {
      background: #00e5ff;
      color: #02121e;
    }

    /* FOOTER */
    footer {
      margin-top: 60px;
      padding: 22px;
      text-align: center;
      color: #9eafb8;
      border-top: 1px solid rgba(0, 229, 255, 0.15);
      font-size: 14px;
    }
  </style>
@endsection

@section('content')
  <!-- KONTEN KONTAK -->
  <main class="contact-container">
    <h1>Hubungi Kami</h1>

    <p class="contact-description">
      Selamat datang di Bandeng Samudra. Jika kamu memiliki pertanyaan tentang produk Bandeng Presto atau ingin melakukan pemesanan, silakan hubungi admin kami melalui WhatsApp.
    </p>

    <section class="contact-card">
      <div class="contact-icon">💬</div>
      <h2>WhatsApp Admin</h2>
      <p>
        Admin kami siap membantu menjawab pertanyaan dan memberikan informasi mengenai produk serta pemesanan Bandeng Presto. Klik tombol di bawah untuk memulai percakapan.
      </p>

      <a
        href="https://wa.me/6281234567890?text=Halo%20Admin%20Bandeng%20Samudra%2C%20saya%20ingin%20bertanya%20tentang%20Bandeng%20Presto."
        target="_blank"
        rel="noopener noreferrer"
        class="btn-wa">
        WhatsApp Admin
      </a>
    </section>

    <a href="{{ url('/') }}" class="btn-home">
      Kembali ke Beranda
    </a>
  </main>

  <!-- FOOTER -->
  <footer>
    &copy; {{ date('Y') }} Bandeng Samudra. Semua Hak Dilindungi.
  </footer>
@endsection