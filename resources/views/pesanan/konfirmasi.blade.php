<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pesanan</title>
</head>
<body style="font-family: sans-serif; padding: 20px;">
    <h2>Berhasil Buat Pesanan! 🎉</h2>

    <div style="border: 1px solid #28a745; padding: 20px; border-radius: 8px; max-width: 400px; background-color: #f8fff9;">
        <!-- Ringkasan Nomor Faktur -->
        <h3>Ringkasan Pesanan #{{ $pesanan->no_faktur }}</h3>
        
     
        <p><strong>Status:</strong> 
            @if($pesanan->status_pembayaran == 'Belum Lunas')
                @if(!empty($pesanan->bukti_pembayaran))
                    <span style="color: #d97706; font-weight: bold;">⏳ Menunggu Verifikasi Penjual</span>
                @else
                    <span style="color: #ca8a04; font-weight: bold;">⏳ Menunggu Pembayaran</span>
                @endif
            @elseif($pesanan->status_pembayaran == 'Lunas')
                <span style="color: #15803d; font-weight: bold;">✅ Pembayaran Lunas (Diproses)</span>
            @else
                <span style="color: #b91c1c; font-weight: bold;">❌ Batal</span>
            @endif
        </p>
        
       
        <p><strong>Produk:</strong> {{ $pesanan->nama_bandeng }}</p>
        <p><strong>Jumlah:</strong> {{ $pesanan->jumlah }} pcs</p>
        <p><strong>Total Bayar:</strong> Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}</p>
        
        <hr>
        <a href="{{ route('pesanan.index') }}" style="display: inline-block; padding: 8px 12px; background: #007bff; color: white; text-decoration: none; border-radius: 4px;">Kembali ke Katalog</a>
    </div>
</body>
</html>