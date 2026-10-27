@extends('layouts.app')

@section('title', 'Tentang Kami - Bandeng Samudra')

@section('styles')
  <style>
    /* Style Khusus Konten Tentang Kami */
    .container {
      max-width: 1000px;
      margin: 55px auto;
      padding: 0 35px;
    }

    .tentang-card {
      padding: 35px;
      background: rgba(13, 38, 59, 0.55);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid rgba(0, 229, 255, 0.25);
      border-radius: 16px;
    }

    .tentang-card h1 {
      margin-top: 0;
      margin-bottom: 20px;
      color: #00e5ff;
      font-size: 32px;
    }

    .tentang-card p {
      color: #cfd8dc;
      font-size: 16px;
      line-height: 1.8;
      margin-bottom: 16px;
    }

    .btn-kembali {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background: linear-gradient(90deg, #d4af37, #b8860b);
      color: #ffffff;
      text-decoration: none;
      border-radius: 6px;
      font-weight: 600;
      font-size: 14px;
      transition: 0.3s;
    }

    .btn-kembali:hover {
      opacity: 0.9;
    }

    footer {
      padding: 20px;
      text-align: center;
      color: #90a4ae;
      border-top: 1px solid rgba(0, 229, 255, 0.15);
      font-size: 14px;
      margin-top: 60px;
    }
  </style>
@endsection

@section('content')
  <!-- KONTEN TENTANG KAMI -->
  <main class="container">
    <section class="tentang-card">
      <h1>Tentang Bandeng Samudra</h1>
      <p>
        Bandeng Samudra adalah penyedia ikan bandeng segar pilihan berkualitas premium dari Temanggung.
      </p>
      <p>
        Kami berkomitmen menyediakan ikan dengan daging yang tebal, gurih, higienis, dan bebas dari rasa lumpur. Kami juga berusaha memberikan pelayanan terbaik untuk setiap pelanggan.
      </p>
      <a href="{{ url('/') }}" class="btn-kembali">
        &larr; Kembali ke Beranda
      </a>
    </section>
  </main>

  <!-- FOOTER -->
  <footer>
    &copy; {{ date('Y') }} Bandeng Samudra
  </footer>
@endsection