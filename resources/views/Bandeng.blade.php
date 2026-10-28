@extends('layouts.katalog')
@section('title', 'Bandeng Presto - Bandeng Samudra')

@section('styles')
  <style>
    .container {
      max-width: 1100px;
      margin: 45px auto;
      padding: 25px;
      text-align: center;
    }

    h1 {
      color: #00e5ff;
      font-size: 34px;
      margin-bottom: 15px;
      font-weight: 700;
    }

    .deskripsi-halaman {
      color: #cfd8dc;
      font-size: 16px;
      line-height: 1.7;
      margin-bottom: 35px;
    }

    .produk {
      max-width: 900px;
      margin: 0 auto;
      background: rgba(13, 38, 59, 0.55);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid rgba(0, 229, 255, 0.25);
      border-radius: 16px;
      overflow: hidden;
      display: grid;
      grid-template-columns: 1fr 1fr;
      align-items: center;
      text-align: left;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
    }

    .gambar-produk-wrapper {
      width: 100%;
      height: 380px;
      overflow: hidden;
      background: #02121e;
    }

    .gambar-produk {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center;
      display: block;
    }

    .isi-produk {
      padding: 30px;
    }

    .isi-produk h2 {
      color: #ffffff;
      font-size: 24px;
      margin-top: 0;
      margin-bottom: 10px;
      font-weight: 600;
    }

    .isi-produk p {
      color: #90a4ae;
      line-height: 1.6;
      font-size: 13px;
      margin-bottom: 20px;
    }

    .pilihan-ukuran {
      margin-top: 20px;
      padding: 15px;
      background: rgba(13, 38, 59, 0.6);
      border: 1px solid rgba(0, 229, 255, 0.2);
      border-radius: 12px;
    }

    .pilihan-ukuran h3 {
      color: #00e5ff;
      margin-top: 0;
      font-size: 15px;
      font-weight: 600;
      margin-bottom: 10px;
    }

    .ukuran {
      padding: 10px 14px;
      margin-top: 8px;
      background: rgba(255, 255, 255, 0.04);
      border-radius: 8px;
    }

    .ukuran strong {
      display: block;
      margin-bottom: 2px;
      color: white;
      font-size: 13px;
    }

    .ukuran span {
      color: #90a4ae;
      font-size: 11px;
    }

    .tombol {
      display: inline-block;
      background: linear-gradient(90deg, #d4af37, #b8860b);
      color: #ffffff;
      padding: 10px 20px;
      border-radius: 6px;
      text-decoration: none;
      margin-top: 20px;
      font-weight: 600;
      font-size: 13px;
      transition: 0.3s;
    }

    .tombol:hover {
      opacity: 0.9;
    }

    .kembali {
      margin-top: 35px;
    }

    @media (max-width: 700px) {
      .produk {
        grid-template-columns: 1fr;
      }
      .gambar-produk-wrapper {
        height: 280px;
      }
    }
  </style>
@endsection

@section('content')
  <main class="container">
    <h1>Produk Bandeng Samudra</h1>

    <p class="deskripsi-halaman">
      Nikmati Bandeng Presto Samudra yang gurih dan praktis untuk hidangan bersama keluarga.
    </p>

    <div class="produk">
      <div class="gambar-produk-wrapper">
        <img src="{{ asset('uploads/bandeng.jpeg') }}" alt="Bandeng Presto Samudra" class="gambar-produk">
      </div>

      <div class="isi-produk">
        <h2>Bandeng Presto</h2>
        <p>
          Bandeng presto pilihan dengan cita rasa gurih yang cocok dinikmati bersama keluarga. Tersedia dalam dua pilihan ukuran.
        </p>

        <div class="pilihan-ukuran">
          <h3>Pilihan Ukuran</h3>
          <div class="ukuran">
            <strong>Ukuran Kecil</strong>
            <span>Bandeng presto ukuran kecil.</span>
          </div>
          <div class="ukuran">
            <strong>Ukuran Besar</strong>
            <span>Bandeng presto ukuran besar.</span>
          </div>
        </div>

        <a href="{{ url('/kontak') }}" class="tombol">
          Hubungi Kami
        </a>
      </div>
    </div>

    <div class="kembali">
      <a href="{{ url('/') }}" class="tombol">
        &larr; Kembali ke Beranda
      </a>
    </div>
  </main>
@endsection