@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 20px auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); text-align: center;">
    
    <h2 style="color: #0f2a4a; margin-top: 0;">Instruksi Pembayaran</h2>
    <p style="color: #64748b; font-size: 14px; margin-bottom: 5px;">Nomor Transaksi: <strong>{{ $pesanan->no_faktur }}</strong></p>

    <!-- BOX TIMER 10 MENIT -->
    <div style="background: #fff7ed; border: 1px solid #fdba74; padding: 15px; border-radius: 8px; margin: 20px 0;">
        <p style="margin: 0; font-size: 14px; color: #c2410c; font-weight: bold;">Selesaikan Pembayaran Dalam Waktu:</p>
        <div id="timer" style="font-size: 28px; font-weight: bold; color: #ea580c; margin-top: 5px;">10:00</div>
    </div>

    <!-- BOX DETAIL METODE PEMBAYARAN -->
    <div style="background: #f8fafc; padding: 20px; border-radius: 8px; margin-bottom: 25px; border: 1px solid #e2e8f0;">
        <p style="margin-top: 0; font-size: 14px; color: #475569;">Total Pembayaran:</p>
        <h2 style="color: #ea580c; margin: 5px 0 20px 0;">Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}</h2>

        @if($pesanan->metode_pembayaran == 'QRIS')
            <p style="font-weight: bold; color: #0f2a4a; margin-bottom: 10px;">Silakan Scan QRIS Di Bawah Ini:</p>
            <!-- Gambar QRIS (Bisa diganti dengan gambar QRIS milikmu di public/images/qris.png) -->
            <div style="background: white; padding: 15px; display: inline-block; border-radius: 8px; border: 1px solid #cbd5e1;">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=BANDENG_SAMUDERA_PAYMENT" alt="QRIS Bandeng Samudera" style="width: 180px; height: 180px;">
            </div>
            <p style="font-size: 13px; color: #64748b; margin-top: 10px;">Mendukung All E-Wallet (GoPay, OVO, ShopeePay, DANA, BCA, Mandiri, dll)</p>

        @elseif($pesanan->metode_pembayaran == 'Transfer')
            <p style="font-weight: bold; color: #0f2a4a; margin-bottom: 10px;">Transfer Ke Rekening Bank Berikut:</p>
            <div style="background: white; padding: 15px; border-radius: 8px; border: 1px solid #cbd5e1; text-align: left;">
                <p style="margin: 5px 0; color: #334155;"><strong>Bank:</strong> BCA</p>
                <p style="margin: 5px 0; color: #334155;"><strong>No. Rekening:</strong> <span style="font-size: 18px; font-weight: bold; color: #0f2a4a;">1234 5678 90</span></p>
                <p style="margin: 5px 0; color: #334155;"><strong>Atas Nama:</strong> Bandeng Samudera</p>
            </div>

        @else
            <p style="font-weight: bold; color: #0f2a4a;">Metode Pembayaran: Cash / COD</p>
            <p style="font-size: 14px; color: #64748b;">Silakan siapkan uang tunai saat pengiriman / pengambilan barang.</p>
        @endif
    </div>

    <!-- FORM UPLOAD BUKTI PEMBAYARAN -->
    <form action="{{ route('pesanan.uploadBukti', $pesanan->no_faktur) }}" method="POST" enctype="multipart/form-data" style="text-align: left;">
        @csrf
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #334155;">📸 Upload Bukti Transfer / Scan :</label>
            <input type="file" name="bukti_bayar" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; background: #f8fafc;">
            <small style="color: #64748b; display: block; margin-top: 4px;">Format: JPG, JPEG, PNG (Maksimal 2MB)</small>
        </div>

        <button type="submit" style="width: 100%; padding: 12px; background: #0f2a4a; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer;">
            Kirim Bukti Pembayaran
        </button>
    </form>
</div>

<!-- SCRIPT TIMER COUNTDOWN 10 MENIT -->
<script>
    let waktu = 600; // 10 menit dalam detik
    const displayTimer = document.getElementById('timer');

    const countdown = setInterval(() => {
        let menit = Math.floor(waktu / 60);
        let detik = waktu % 60;

        menit = menit < 10 ? '0' + menit : menit;
        detik = detik < 10 ? '0' + detik : detik;

        displayTimer.innerText = `${menit}:${detik}`;

        if (waktu <= 0) {
            clearInterval(countdown);
            alert('Waktu pembayaran telah habis! Silakan lakukan pemesanan ulang.');
            window.location.href = "{{ route('pesanan.index') }}";
        }
        waktu--;
    }, 1000);
</script>
@endsection