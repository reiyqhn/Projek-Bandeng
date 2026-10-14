@extends('layouts.app')

@section('content')
    <h2>Bandeng Samudera</h2>
    <p style="color: #666; margin-bottom: 20px;">Bandeng segar premium dari Temanggung</p>

    @if(session('error'))
        <div style="color: red; margin-bottom: 15px;">{{ session('error') }}</div>
    @endif

    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
        @foreach($produks as $produk)
            <div style="border: 1px solid #ddd; padding: 20px; border-radius: 12px; width: 220px; background-color: white; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                <h3 style="margin-top: 0;">{{ $produk->nama_bandeng }}</h3>
                <p style="color: #ff6b00; font-weight: bold; font-size: 18px; margin: 10px 0;">
                    Rp {{ number_format($produk->harga, 0, ',', '.') }} <span style="font-size: 12px; color: #888;">/ ekor</span>
                </p>
                <p style="font-size: 14px; color: #555;">Stok: {{ $produk->stok }}</p>
                
                <a href="{{ route('pesanan.show', $produk->id_bandeng) }}" 
                   style="display: block; text-align: center; padding: 10px; background: #007bff; color: white; text-decoration: none; border-radius: 6px; margin-top: 15px;">
                   Pesan Sekarang
                </a>
            </div>
        @endforeach
    </div>
@endsection