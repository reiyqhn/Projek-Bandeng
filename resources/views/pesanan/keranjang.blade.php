@extends('layouts.app')

@section('content')
<div style="max-width: 820px; width: 100%;">
    
    <div class="mb-4">
        <h1 class="fw-bold mb-1" style="font-size: 2.2rem; letter-spacing: 0.5px; background: linear-gradient(90deg, #ffffff 15%, #ffd1a9 50%, #f97316 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block; filter: drop-shadow(0px 2px 4px rgba(0, 0, 0, 0.3);">
            Keranjang Anda
        </h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success py-2 mb-4" style="font-size: 0.85rem; border-radius: 10px; background: rgba(25, 135, 84, 0.2); border: 1px solid rgba(25, 135, 84, 0.4); color: #fff;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger py-2 mb-4" style="font-size: 0.85rem; border-radius: 10px; background: rgba(220, 53, 69, 0.2); border: 1px solid rgba(220, 53, 69, 0.4); color: #fff;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        </div>
    @endif

    @if(empty($cart))
        <div class="p-5 text-center rounded-4" style="background: rgba(255, 255, 255, 0.05); border: 1.5px solid rgba(255, 255, 255, 0.15); backdrop-filter: blur(16px); max-width: 820px;">
            <i class="bi bi-cart-x fs-1 text-white-50 mb-2 d-block"></i>
            <h5 class="text-white fw-bold mb-1">Keranjang Kamu Masih Kosong</h5>
            <p class="text-white-50 mb-3" style="font-size: 0.85rem;">Yuk pilih bandeng segar pilihan di Beranda!</p>
            <a href="{{ route('pesanan.index') }}" class="btn text-white fw-medium px-4 py-2" style="background: rgba(15, 76, 129, 0.85); border: 1px solid rgba(255, 255, 255, 0.4); border-radius: 10px; font-size: 0.85rem;">
                Lihat Beranda
            </a>
        </div>
    @else
        <div class="d-flex flex-column gap-3 pb-4">
            @php $totalSemua = 0; @endphp
            @foreach($cart as $id => $item)
                @php 
                    $subtotal = $item['harga'] * $item['jumlah']; 
                    $totalSemua += $subtotal; 
                @endphp
                
                <div class="p-3 rounded-4 d-flex align-items-center justify-content-between gap-3" 
                     style="background: rgba(255, 255, 255, 0.08); 
                            backdrop-filter: blur(16px); 
                            -webkit-backdrop-filter: blur(16px); 
                            border: 1.5px solid rgba(255, 255, 255, 0.18); 
                            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.25);">
                    
                    <div style="width: 120px; height: 90px; border-radius: 12px; overflow: hidden; flex-shrink: 0;" class="shadow-sm">
                        <img src="{{ isset($item['gambar']) ? asset('image/' . $item['gambar']) : asset('image/Bandeng1.jpeg') }}" alt="{{ $item['nama'] }}" class="w-100 h-100 object-fit-cover">
                    </div>

                    <div class="flex-grow-1">
                        <h5 class="fw-bold mb-1" style="font-size: 1.15rem; background: linear-gradient(90deg, #ffffff 20%, #ffd1a9 70%, #f97316 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block;">
                            {{ $item['nama'] }}
                        </h5>
                        <p class="text-white-50 mb-0" style="font-size: 0.85rem;">
                            Rp {{ number_format($item['harga'], 0, ',', '.') }} <span class="text-warning">x {{ $item['jumlah'] }}</span>
                        </p>
                    </div>

                    <div class="flex-shrink-0">
                        <a href="{{ route('keranjang.hapus', $id) }}" 
                           class="btn btn-danger btn-sm px-3 py-2 fw-medium shadow-sm d-flex align-items-center gap-1" 
                           style="border-radius: 10px; font-size: 0.8rem; background: rgba(220, 53, 69, 0.85); border: 1px solid rgba(255, 255, 255, 0.3);">
                            <i class="bi bi-trash-fill"></i> Hapus
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="p-3 rounded-4 mb-3 d-flex justify-content-between align-items-center" 
             style="background: rgba(22, 53, 77, 0.7); backdrop-filter: blur(12px); border: 1.5px solid rgba(255, 255, 255, 0.2); max-width: 820px;">
            <span class="text-white fw-bold" style="font-size: 1rem;">Total :</span>
            <span class="fw-bold" style="font-size: 1.3rem; color: #fbbf24;">Rp {{ number_format($totalSemua, 0, ',', '.') }}</span>
        </div>

        <div class="d-flex flex-column flex-md-row gap-2" style="max-width: 820px;">
            <a href="{{ route('pesanan.index') }}" class="btn text-white py-2 w-100 fw-medium shadow-sm" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 10px; font-size: 0.85rem;">
                Lanjut Belanja
            </a>
            <a href="{{ route('pesanan.checkout') }}" class="btn fw-bold text-white py-2 w-100 shadow-sm" style="background: linear-gradient(135deg, #0f2a4a, #1a436e); border-radius: 10px; font-size: 0.85rem; border: 1px solid rgba(255, 255, 255, 0.4);">
                Lanjut ke CheckOut
            </a>
        </div>
    @endif
</div>
@endsection