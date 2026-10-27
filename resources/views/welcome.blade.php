@extends('layouts.app')

@section('title', 'Beranda - Bandeng Samudra Temanggung')

@section('styles')
  <style>
    /* Hero Section */
    .hero-section {
      display: grid;
      grid-template-columns: 1.2fr 1fr;
      padding: 40px 50px;
      align-items: center;
      gap: 40px;
      max-width: 1300px;
      margin: 0 auto;
    }

    .hero-subtitle-top {
      font-size: 15px;
      color: #00e5ff;
      letter-spacing: 2px;
      font-weight: 600;
      text-transform: uppercase;
      margin-bottom: 8px;
    }

    .hero-title {
      font-size: 48px;
      font-weight: 700;
      line-height: 1.2;
      color: #ffffff;
      margin-bottom: 14px;
    }

    .hero-title span {
      color: #ff9800;
    }

    .hero-desc {
      font-size: 15px;
      color: #b0bec5;
      line-height: 1.6;
      margin-bottom: 25px;
      max-width: 480px;
    }

    /* Features Badges */
    .features-row {
      display: flex;
      gap: 15px;
      margin-bottom: 30px;
    }

    .feature-badge {
      display: flex;
      align-items: center;
      gap: 10px;
      background: rgba(13, 38, 59, 0.6);
      border: 1px solid rgba(0, 229, 255, 0.2);
      padding: 10px 16px;
      border-radius: 12px;
    }

    .feature-icon {
      width: 34px;
      height: 34px;
      background: rgba(0, 229, 255, 0.15);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #00e5ff;
      font-size: 14px;
    }

    .feature-text h4 {
      font-size: 13px;
      font-weight: 600;
      color: #ffffff;
    }

    .feature-text p {
      font-size: 11px;
      color: #90a4ae;
    }

    /* Preview Product Card */
    .preview-card {
      background: rgba(13, 38, 59, 0.55);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(0, 229, 255, 0.25);
      border-radius: 14px;
      padding: 15px;
      display: flex;
      gap: 12px;
      align-items: center;
      max-width: 390px;
    }

    .preview-thumb {
      width: 75px;
      height: 75px;
      border-radius: 8px;
      object-fit: cover;
    }

    .preview-info h5 {
      font-size: 15px;
      font-weight: 600;
      color: #ffffff;
      margin-bottom: 2px;
    }

    .preview-info p {
      font-size: 12px;
      color: #90a4ae;
      line-height: 1.3;
      margin-bottom: 6px;
    }

    .preview-bottom {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .preview-price {
      font-size: 14px;
      font-weight: 600;
      color: #00e5ff;
    }

    .btn-detail {
      background: linear-gradient(90deg, #d4af37, #b8860b);
      border: none;
      padding: 6px 14px;
      border-radius: 6px;
      color: #ffffff;
      font-size: 12px;
      cursor: pointer;
      text-decoration: none;
    }

    /* Right Image Tilted Card (Tanpa teks tambahan di bawahnya) */
    .hero-image-container {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .tilted-banner-card {
      width: 390px;
      height: 440px;
      background: rgba(10, 30, 50, 0.65);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(0, 229, 255, 0.35);
      border-radius: 24px;
      padding: 15px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
      transform: rotate(3deg);
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .banner-img-wrapper {
      width: 100%;
      height: 100%;
      border-radius: 16px;
      overflow: hidden;
      background: #02121e;
    }

    .banner-img-wrapper img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center;
    }
  </style>
@endsection

@section('content')
  <section class="hero-section">
    <div>
      <div class="hero-subtitle-top">SISTEM INFORMASI</div>
      <h1 class="hero-title">BANDENG <span>SAMUDRA</span> <br>TEMANGGUNG</h1>
      <p class="hero-desc">
        Bandeng segar berkualitas dari Temanggung untuk Anda dan keluarga. Daging tebal, gurih, dan higienis tanpa lumpur.
      </p>

      <!-- Features Badges -->
      <div class="features-row">
        <div class="feature-badge">
          <div class="feature-icon"><i class="fa-solid fa-snowflake"></i></div>
          <div class="feature-text">
            <h4>Segar</h4>
            <p>Setiap Hari</p>
          </div>
        </div>
        <div class="feature-badge">
          <div class="feature-icon"><i class="fa-solid fa-award"></i></div>
          <div class="feature-text">
            <h4>Berkualitas</h4>
            <p>Pilihan Terbaik</p>
          </div>
        </div>
        <div class="feature-badge">
          <div class="feature-icon"><i class="fa-solid fa-shield-halved"></i></div>
          <div class="feature-text">
            <h4>Higienis</h4>
            <p>Dikemas Baik</p>
          </div>
        </div>
      </div>

      <!-- Preview Product Card -->
      <div class="preview-card">
        <img src="{{ asset('uploads/bandeng.jpeg') }}" alt="Bandeng" class="preview-thumb">
        <div class="preview-info" style="flex: 1;">
          <h5>Bandeng Samudra</h5>
          <p>Bandeng segar premium dari Temanggung. Daging tebal, gurih, tanpa lumpur.</p>
          <div class="preview-bottom">
            <span class="preview-price">Rp 35.000 / ekor</span>
            <a href="#" class="btn-detail">Lihat Detail</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Image Section (Tilted Card Clean) -->
    <div class="hero-image-container">
      <div class="tilted-banner-card">
        <div class="banner-img-wrapper">
          <img src="{{ asset('uploads/bandeng.jpeg') }}" alt="Produk Bandeng">
        </div>
      </div>
    </div>
  </section>
@endsection