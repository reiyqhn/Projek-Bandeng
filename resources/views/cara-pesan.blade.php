@extends('layouts.app')

@section('title', 'Cara Pesan - Bandeng Samudra')

@section('styles')
  <style>
    /* KONTEN HALAMAN CARA PESAN */
    .container {
      max-width: 900px;
      margin: 45px auto;
      padding: 20px;
    }

    .judul {
      text-align: center;
      margin-bottom: 35px;
    }

    h1 {
      color: #00e5ff;
      margin-bottom: 12px;
    }

    .judul p {
      color: #cfd8dc;
    }

    .langkah {
      display: flex;
      align-items: flex-start;
      gap: 20px;
      background: rgba(13, 38, 59, 0.55);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      padding: 22px;
      margin-bottom: 18px;
      border-radius: 12px;
      border: 1px solid rgba(0, 229, 255, 0.25);
    }

    .nomor {
      min-width: 42px;
      height: 42px;
      display: flex;
      justify-content: center;
      align-items: center;
      background: #00e5ff;
      color: #02121e;
      border-radius: 50%;
      font-size: 18px;
      font-weight: bold;
    }

    .isi h3 {
      color: #00e5ff;
      margin: 0 0 10px;
    }

    .isi p {
      color: #cfd8dc;
      line-height: 1.7;
      margin: 0;
    }

    .tombol {
      display: inline-block;
      margin: 20px 5px 0;
      padding: 12px 22px;
      background: #ff9800;
      color: #ffffff;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
      transition: 0.3s;
    }

    .tombol:hover {
      background: #e68900;
    }

    .aksi {
      text-align: center;
    }

    footer {
      text-align: center;
      padding: 25px;
      color: #9eacb5;
      font-size: 13px;
      border-top: 1px solid rgba(0, 229, 255, 0.15);
      margin-top: 50px;
    }
  </style>
@endsection

@section('content')
  <!-- ISI HALAMAN CARA PEMESANAN -->
  <div class="container">
    <div class="judul">
      <h1>Cara Pemesanan</h1>
      <p>
        Ikuti langkah-langkah berikut untuk memesan produk Bandeng Samudra.
      </p>
    </div>

    <div class="langkah">
      <div class="nomor">1</div>
      <div class="isi">
        <h3>Pilih Produk</h3>
        <p>
          Buka halaman Bandeng untuk melihat informasi produk yang tersedia.
        </p>
      </div>
    </div>

    <div class="langkah">
      <div class="nomor">2</div>
      <div class="isi">
        <h3>Hubungi Kami</h3>
        <p>
          Hubungi Bandeng Samudra untuk menanyakan harga, ketersediaan produk, dan informasi pemesanan.
        </p>
      </div>
    </div>

    <div class="langkah">
      <div class="nomor">3</div>
      <div class="isi">
        <h3>Lakukan Pemesanan</h3>
        <p>
          Sampaikan produk dan jumlah yang ingin dipesan, kemudian ikuti petunjuk pemesanan yang diberikan.
        </p>
      </div>
    </div>

    <div class="langkah">
      <div class="nomor">4</div>
      <div class="isi">
        <h3>Lakukan Pembayaran</h3>
        <p>
          Ikuti informasi pembayaran yang diberikan dan konfirmasikan pembayaran kepada pihak Bandeng Samudra.
        </p>
      </div>
    </div>

    <div class="aksi">
      <a href="{{ url('/bandeng') }}" class="tombol">
        Lihat Produk Bandeng
      </a>

      <a href="{{ url('/kontak') }}" class="tombol">
        Hubungi Kami
      </a>
    </div>
  </div>

  <footer>
    &copy; {{ date('Y') }} Bandeng Samudra. Semua hak dilindungi.
  </footer>
@endsection