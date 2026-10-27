@extends('layouts.app')

@section('content')
<div style="max-width: 820px; width: 100%; margin: 0 auto;">
    
    <div class="mb-4">
        <h1 class="fw-bold mb-1" style="font-size: 2.2rem; letter-spacing: 0.5px; background: linear-gradient(90deg, #ffffff 15%, #ffd1a9 50%, #f97316 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block; filter: drop-shadow(0px 2px 4px rgba(0, 0, 0, 0.3);">
            Riwayat Pesanan
        </h1>
        <p class="text-white-50 mb-0" style="font-size: 0.9rem;">Semua catatan transaksi belanja kamu tersimpan di sini</p>
    </div>

    <div class="d-flex flex-column gap-3 pb-5">
        @forelse($riwayatPesanan as $item)
            <div class="p-3 p-md-4 rounded-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 text-white" 
                 style="background: rgba(255, 255, 255, 0.08); 
                        backdrop-filter: blur(16px); 
                        -webkit-backdrop-filter: blur(16px); 
                        border: 1.5px solid rgba(255, 255, 255, 0.18); 
                        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.25);">
                
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                        <strong style="font-size: 1.05rem;">Pesanan #{{ $item->no_faktur }}</strong>
                        
                        @if($item->status_pembayaran == 'Belum Lunas')
                            @if($item->bukti_pembayaran)
                                <span class="badge bg-info text-dark" style="font-size: 0.7rem; border-radius: 20px; padding: 5px 10px;">Menunggu Konfirmasi</span>
                            @else
                                <span class="badge bg-warning text-dark" style="font-size: 0.7rem; border-radius: 20px; padding: 5px 10px;">Belum Lunas</span>
                            @endif
                        @elseif($item->status_pembayaran == 'Batal')
                            <span class="badge bg-danger" style="font-size: 0.7rem; border-radius: 20px; padding: 5px 10px;">Batal</span>
                        @else
                            <span class="badge bg-success" style="font-size: 0.7rem; border-radius: 20px; padding: 5px 10px;">Lunas</span>
                        @endif
                    </div>
                    
                    <small class="text-white-50" style="font-size: 0.78rem;">
                        <i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($item->tanggal_penjualan)->translatedFormat('d F Y, H:i') }} WIB
                    </small>
                </div>

                <div class="text-md-end d-flex flex-column align-items-md-end gap-2">
                    <span class="fw-bold" style="font-size: 1.15rem; color: #fbbf24;">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </span>

                    <button type="button" class="btn btn-sm text-white fw-semibold px-3 py-1.5" 
                            data-bs-toggle="modal" 
                            data-bs-target="#modalDetail-{{ str_replace(['-', ' '], '', $item->no_faktur) }}"
                            style="background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 10px; font-size: 0.8rem;">
                        <i class="bi bi-eye me-1"></i> Lihat Detail
                    </button>
                </div>
            </div>

            <div class="modal fade" id="modalDetail-{{ str_replace(['-', ' '], '', $item->no_faktur) }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content text-white" style="background: #0f2b48; border: 1.5px solid rgba(255, 255, 255, 0.2); border-radius: 20px;">
                        <div class="modal-header border-bottom border-light border-opacity-15">
                            <h5 class="modal-title fw-bold fs-6">Rincian Belanja #{{ $item->no_faktur }}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <small class="text-white-50 d-block">Waktu Transaksi</small>
                                <span class="fw-medium">{{ \Carbon\Carbon::parse($item->tanggal_penjualan)->translatedFormat('d F Y, H:i') }} WIB</span>
                            </div>

                            <label class="text-white-50 small mb-2">Daftar Produk yang Dibeli:</label>
                            <div class="d-flex flex-column gap-2 mb-3">
                                @foreach($item->details as $det)
                                    <div class="p-2.5 rounded-3 d-flex justify-content-between align-items-center" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
                                        <div>
                                            <div class="fw-semibold text-white" style="font-size: 0.9rem;">{{ $det->nama_bandeng }}</div>
                                            <small class="text-white-50">{{ $det->jumlah }} pcs x Rp {{ number_format($det->harga_item, 0, ',', '.') }}</small>
                                        </div>
                                        <div class="fw-bold text-warning" style="font-size: 0.9rem;">
                                            Rp {{ number_format($det->jumlah * $det->harga_item, 0, ',', '.') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="p-3 rounded-3 d-flex justify-content-between align-items-center" style="background: rgba(0, 0, 0, 0.25);">
                                <span class="text-white-50 fw-semibold">Total Keseluruhan:</span>
                                <span class="fw-bold fs-5 text-warning">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="modal-footer border-top border-light border-opacity-15">
                            <button type="button" class="btn btn-sm btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Tutup</button>
                            @if($item->status_pembayaran == 'Lunas')
                                <a href="{{ route('pesanan.konfirmasi', $item->no_faktur) }}" class="btn btn-sm text-white px-4 rounded-pill" style="background: linear-gradient(90deg, #00b4d8 0%, #0077b6 100%);">
                                    Lihat Faktur
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        @empty
            <div class="p-5 text-center rounded-4" style="background: rgba(255, 255, 255, 0.05); border: 1.5px solid rgba(255, 255, 255, 0.15); backdrop-filter: blur(16px);">
                <i class="bi bi-receipt fs-1 text-white-50 mb-2 d-block"></i>
                <h5 class="text-white fw-bold mb-1">Belum Ada Riwayat</h5>
                <p class="text-white-50 mb-0" style="font-size: 0.85rem;">Kamu belum memiliki riwayat transaksi belanja.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection