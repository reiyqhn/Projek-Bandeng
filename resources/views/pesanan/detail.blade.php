@extends('layouts.app')

@section('content')
<div style="max-width: 500px; margin: 30px auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
    <h2 style="margin-top: 0; color: #0f2a4a;">Konfirmasi Pesanan</h2>
    <p style="color: #666; font-size: 14px;">Masukan jumlah ekor yang diinginkan :</p>
    
    <h3 style="color: #222; margin-bottom: 5px;">{{ $produk->nama_bandeng }}</h3>
    <p style="color: #888; font-size: 13px; margin-top: 0;">Sisa Stok: {{ $produk->stok }} ekor</p>

    <!-- Form ke proses pesanan -->
    <form action="{{ route('keranjang.tambah') }}" method="POST">
        @csrf
        <input type="hidden" name="produk_id" value="{{ $produk->id_bandeng }}">

        <!-- Tombol Plus Minus Jumlah -->
        <div style="display: flex; align-items: center; justify-content: center; gap: 15px; margin: 25px 0;">
            <button type="button" onclick="ubahJumlah(-1)" style="width: 40px; height: 40px; border-radius: 50%; border: none; background: #e2e8f0; font-size: 20px; cursor: pointer; font-weight: bold; color: #333;">-</button>
            
            <input type="number" id="jumlah" name="jumlah" value="1" min="1" max="{{ $produk->stok }}" 
                   style="width: 80px; text-align: center; font-size: 18px; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px;" readonly>
            
            <button type="button" onclick="ubahJumlah(1)" style="width: 40px; height: 40px; border-radius: 50%; border: none; background: #e2e8f0; font-size: 20px; cursor: pointer; font-weight: bold; color: #333;">+</button>
        </div>

        <!-- Total Harga Otomatis -->
        <div style="text-align: center; margin-bottom: 25px; background: #f8fafc; padding: 15px; border-radius: 8px;">
            <p style="font-size: 14px; color: #64748b; margin: 0;">Total :</p>
            <h2 id="total-harga" style="color: #ea580c; margin: 5px 0;">Rp {{ number_format($produk->harga, 0, ',', '.') }}</h2>
        </div>

        <!-- Tombol Masukan Keranjang -->
        <button type="submit" style="width: 100%; padding: 12px; background: #0f2a4a; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; transition: background 0.2s;">
            Masukan Keranjang
        </button>
        
        <div style="text-align: center; margin-top: 15px;">
            <a href="{{ route('pesanan.index') }}" style="color: #64748b; text-decoration: none; font-size: 14px;">Batal / Kembali ke Beranda</a>
        </div>
    </form>
</div>

<!-- Skrip JavaScript untuk Hitung Total Otomatis -->
<script>
    const hargaSatuan = {{ $produk->harga }};
    const inputJumlah = document.getElementById('jumlah');
    const textTotal = document.getElementById('total-harga');
    const maxStok = {{ $produk->stok }};

    function ubahJumlah(val) {
        let jumlahSekarang = parseInt(inputJumlah.value) + val;
        
        // Batasi minimal 1 dan maksimal sejumlah stok produk
        if (jumlahSekarang < 1) jumlahSekarang = 1;
        if (jumlahSekarang > maxStok) jumlahSekarang = maxStok;

        inputJumlah.value = jumlahSekarang;

        // Hitung total harga baru
        let total = hargaSatuan * jumlahSekarang;

        // Format ke Rupiah
        textTotal.innerText = 'Rp ' + total.toLocaleString('id-ID');
    }
</script>
@endsection