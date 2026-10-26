@extends('layouts.app')

@section('content')
<div style="max-width: 650px; margin: 0 auto; width: 100%;">
    
    <div class="mb-4">
        <h1 class="fw-bold mb-1" style="font-size: 2.2rem; letter-spacing: 0.5px; background: linear-gradient(90deg, #ffffff 15%, #ffd1a9 50%, #f97316 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block; filter: drop-shadow(0px 2px 4px rgba(0, 0, 0, 0.3);">
            Checkout Pesanan
        </h1>
    </div>

    <div class="p-4 p-md-4 rounded-4 shadow-lg" 
         style="background: rgba(30, 45, 65, 0.45); 
                backdrop-filter: blur(12px); 
                -webkit-backdrop-filter: blur(12px); 
                border-radius: 16px; 
                border: 2px solid rgba(255, 183, 77, 0.6); 
                color: white; 
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4), inset 0 0 15px rgba(255, 167, 38, 0.15) !important;">
        
        <form action="{{ route('pesanan.prosesCheckout') }}" method="POST">
            @csrf

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #ffd1a9; font-size: 0.9rem;">
                    📍 Alamat Pengiriman :
                </label>
                <textarea name="alamat" rows="3" required 
                          style="width: 100%; padding: 12px; background: rgba(15, 28, 45, 0.6); border: 1.5px solid rgba(255, 183, 77, 0.4); border-radius: 10px; box-sizing: border-box; color: white; font-size: 0.9rem; outline: none;" 
                          placeholder="Masukkan alamat lengkap pengiriman..."></textarea>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #ffd1a9; font-size: 0.9rem;">
                    💳 Metode Pembayaran :
                </label>
                <select name="metode_pembayaran" required 
                        style="width: 100%; padding: 12px; background: rgba(15, 28, 45, 0.85); border: 1.5px solid rgba(255, 183, 77, 0.4); border-radius: 10px; color: white; font-size: 0.9rem; outline: none;">
                    <option value="QRIS" style="background: #0f1c2d; color: white;">QRIS (Scan & Bayar)</option>
                    <option value="Transfer" style="background: #0f1c2d; color: white;">Transfer Bank (BCA/BRI)</option>
                    <option value="Cash" style="background: #0f1c2d; color: white;">Cash / Bayar di Tempat (COD)</option>
                </select>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #ffd1a9; font-size: 0.9rem;">
                    🛵 Metode Pesanan :
                </label>
                <select name="metode_pesanan" required 
                        style="width: 100%; padding: 12px; background: rgba(15, 28, 45, 0.85); border: 1.5px solid rgba(255, 183, 77, 0.4); border-radius: 10px; color: white; font-size: 0.9rem; outline: none;">
                    <option value="Delivery" style="background: #0f1c2d; color: white;">Delivery (Diantar)</option>
                    <option value="Takeaway" style="background: #0f1c2d; color: white;">Takeaway (Ambil Sendiri)</option>
                    <option value="Dine-in" style="background: #0f1c2d; color: white;">Dine-in (Makan di Tempat)</option>
                </select>
            </div>

            <div style="background: rgba(15, 28, 45, 0.6); padding: 15px 20px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border: 1.5px solid rgba(255, 183, 77, 0.4);">
                <span style="font-weight: bold; color: rgba(255, 255, 255, 0.8);">Total Pembayaran:</span>
                <span style="font-size: 1.25rem; font-weight: bold; color: #ffb74d;">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center;">
                <a href="{{ route('pesanan.keranjang') }}" style="color: rgba(255, 255, 255, 0.7); text-decoration: none; font-size: 0.85rem; transition: color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255, 183, 77, 0.7)'">
                    ← Kembali ke Keranjang
                </a>
                <button type="submit" 
                        class="btn text-white fw-bold shadow-sm" 
                        style="padding: 12px 25px; background: linear-gradient(135deg, #1662f9, #abbdee); border: none; border-radius: 10px; font-size: 0.95rem; cursor: pointer; transition: filter 0.2s;" 
                        onmouseover="this.style.filter='brightness(1.1)'" 
                        onmouseout="this.style.filter='brightness(1)'">
                    Konfirmasi Bayar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection