@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
    <h2 style="margin-top: 0; color: #0f2a4a;">Keranjang Belanja</h2>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 6px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 6px; margin-bottom: 15px;">
            {{ session('error') }}
        </div>
    @endif

    @if(empty($cart))
        <p style="color: #666; text-align: center; padding: 40px 0;">Keranjang kamu masih kosong. Yuk pilih bandeng segar di Beranda!</p>
        <div style="text-align: center;">
            <a href="{{ route('pesanan.index') }}" style="padding: 10px 20px; background: #0f2a4a; color: white; text-decoration: none; border-radius: 6px;">Lihat Beranda</a>
        </div>
    @else
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; text-align: left;">
                    <th style="padding: 12px;">Produk</th>
                    <th style="padding: 12px;">Harga Satuan</th>
                    <th style="padding: 12px;">Jumlah</th>
                    <th style="padding: 12px;">Subtotal</th>
                    <th style="padding: 12px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $totalSemua = 0; @endphp
                @foreach($cart as $id => $item)
                    @php $subtotal = $item['harga'] * $item['jumlah']; $totalSemua += $subtotal; @endphp
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 12px; font-weight: bold;">{{ $item['nama'] }}</td>
                        <td style="padding: 12px;">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                        <td style="padding: 12px;">{{ $item['jumlah'] }} ekor</td>
                        <td style="padding: 12px; color: #ea580c; font-weight: bold;">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        <td style="padding: 12px; text-align: center;">
                            <a href="{{ route('keranjang.hapus', $id) }}" style="color: #ef4444; text-decoration: none; font-size: 14px;">Hapus</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="display: flex; justify-content: space-between; align-items: center; background: #f8fafc; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <span style="font-size: 16px; font-weight: bold; color: #333;">Total Keseluruhan:</span>
            <span style="font-size: 20px; font-weight: bold; color: #ea580c;">Rp {{ number_format($totalSemua, 0, ',', '.') }}</span>
        </div>

        <div style="display: flex; justify-content: space-between;">
            <a href="{{ route('pesanan.index') }}" style="padding: 10px 20px; background: #e2e8f0; color: #333; text-decoration: none; border-radius: 6px;">Lanjut Belanja</a>
            <a href="{{ route('pesanan.checkout') }}" style="padding: 10px 20px; background: #0f2a4a; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;">Lanjut ke Checkout</a>
        </div>
    @endif
</div>
@endsection