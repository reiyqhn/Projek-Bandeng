@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 20px auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
    
    <h2 style="color: #0f2a4a; margin-top: 0; margin-bottom: 20px;">Checkout Pesanan</h2>

  
    <form action="{{ route('pesanan.prosesCheckout') }}" method="POST">
        @csrf

     
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #334155;">📍 Alamat Pengiriman :</label>
            <textarea name="alamat" rows="3" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box;" placeholder="Masukkan alamat lengkap pengiriman...">Jl. Samudera No 1, Sleman</textarea>
        </div>

       
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #334155;">💳 Metode Pembayaran :</label>
            <select name="metode_pembayaran" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; background: white;">
                <option value="QRIS">QRIS (Scan & Bayar)</option>
                <option value="Transfer">Transfer Bank (BCA/BRI)</option>
                <option value="Cash">Cash / Bayar di Tempat (COD)</option>
            </select>
        </div>

       
       
         <div style="margin-bottom: 25px;">
            <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #334155;">🛵 Metode Pesanan :</label>
            <select name="metode_pesanan" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; background: white;">
                <option value="Delivery">Delivery (Diantar)</option>
                <option value="Takeaway">Takeaway (Ambil Sendiri)</option>
                <option value="Dine-in">Dine-in (Makan di Tempat)</option>
            </select>
        </div>

    
        <div style="background: #f8fafc; padding: 15px 20px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border: 1px solid #e2e8f0;">
            <span style="font-weight: bold; color: #475569;">Total Pembayaran:</span>
            <span style="font-size: 20px; font-weight: bold; color: #ea580c;">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
        </div>

       
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <a href="{{ route('pesanan.keranjang') }}" style="color: #64748b; text-decoration: none; font-size: 14px;">Kembali ke Keranjang</a>
            <button type="submit" style="padding: 12px 25px; background: #0f2a4a; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer;">
                Konfirmasi Bayar
            </button>
        </div>
    </form>
</div>
@endsection