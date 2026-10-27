@extends('layouts.app')

@section('content')
<div style="max-width: 650px; width: 100%; margin: 0 auto;" class="pb-5">
    
    <div class="mb-4 text-center">
        <div class="mb-2">
            <span class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-20 text-success rounded-circle" style="width: 60px; height: 60px;">
                <i class="bi bi-check-lg fs-1"></i>
            </span>
        </div>
        <h2 class="fw-bold text-white mb-1" style="font-size: 1.8rem;">Pesanan Berhasil Dibuat!</h2>
        <p class="text-white-50" style="font-size: 0.9rem;">Terima kasih telah berbelanja di Bandeng Samudera.</p>
    </div>

    <div class="p-4 p-md-4 rounded-4" style="background: rgba(255, 255, 255, 0.08); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1.5px solid rgba(255, 255, 255, 0.18); box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.25);">
        
        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom border-light border-opacity-10">
            <div>
                <small class="text-white-50 d-block">Nomor Transaksi</small>
                <strong class="text-white fs-6">#{{ $pesanan->no_faktur }}</strong>
            </div>
            <div>
                @if($pesanan->status_pembayaran == 'Belum Lunas')
                    @if(!empty($pesanan->bukti_pembayaran))
                        <span class="badge bg-info text-dark px-3 py-2 rounded-pill" style="font-size: 0.75rem;">⏳ Menunggu Verifikasi Kasir</span>
                    @else
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill" style="font-size: 0.75rem;">⏳ Menunggu Pembayaran</span>
                    @endif
                @elseif($pesanan->status_pembayaran == 'Lunas')
                    <span class="badge bg-success px-3 py-2 rounded-pill" style="font-size: 0.75rem;">✅ Lunas (Diproses)</span>
                @else
                    <span class="badge bg-danger px-3 py-2 rounded-pill" style="font-size: 0.75rem;">❌ Batal</span>
                @endif
            </div>
        </div>

        <div class="mb-4">
            <div class="row g-2 mb-2">
                <div class="col-6 text-white-50" style="font-size: 0.85rem;">Metode Pemesanan:</div>
                <div class="col-6 text-end text-white fw-medium" style="font-size: 0.85rem;">{{ $pesanan->metode_pemesanan }}</div>
            </div>
            <div class="row g-2 mb-2">
                <div class="col-6 text-white-50" style="font-size: 0.85rem;">Metode Pembayaran:</div>
                <div class="col-6 text-end text-white fw-medium" style="font-size: 0.85rem;">{{ $pesanan->metode_pembayaran }}</div>
            </div>
            <div class="row g-2 mb-2">
                <div class="col-6 text-white-50" style="font-size: 0.85rem;">Waktu Pesan:</div>
                <div class="col-6 text-end text-white fw-medium" style="font-size: 0.85rem;">{{ \Carbon\Carbon::parse($pesanan->tanggal_penjualan)->translatedFormat('d M Y, H:i') }} WIB</div>
            </div>
        </div>

        <div class="p-3 rounded-3 mb-4 d-flex justify-content-between align-items-center" style="background: rgba(0, 0, 0, 0.2);">
            <span class="text-white-50 fw-semibold">Total Pembayaran:</span>
            <span class="fw-bold fs-5" style="color: #fbbf24;">Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}</span>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('pesanan.notifikasi') }}" class="btn text-white w-100 py-2 fw-semibold" style="background: linear-gradient(90deg, #00b4d8 0%, #0077b6 100%); border-radius: 12px; font-size: 0.9rem;">
                Cek Status Notifikasi <i class="bi bi-bell ms-1"></i>
            </a>
            <a href="{{ route('pesanan.index') }}" class="btn text-white w-100 py-2 fw-semibold" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 12px; font-size: 0.9rem;">
                Kembali ke Katalog
            </a>
        </div>

    </div>
</div>
@endsection