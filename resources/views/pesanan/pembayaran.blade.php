@extends('layouts.app')

@section('content')
<div style="max-width: 650px; margin: 0 auto; width: 100%;">
    
    <div class="mb-4 text-center">
        <h1 class="fw-bold mb-1" style="font-size: 2.2rem; letter-spacing: 0.5px; background: linear-gradient(90deg, #ffffff 15%, #ffd1a9 50%, #f97316 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block; filter: drop-shadow(0px 2px 4px rgba(0, 0, 0, 0.3);">
            Instruksi Pembayaran
        </h1>
        <p class="text-white-50 mb-0" style="font-size: 0.9rem;">Nomor Transaksi: <strong class="text-white">{{ $pesanan->no_faktur }}</strong></p>
    </div>

    <div class="p-4 p-md-4 rounded-4 shadow-lg" 
         style="background: rgba(30, 45, 65, 0.45); 
                backdrop-filter: blur(12px); 
                -webkit-backdrop-filter: blur(12px); 
                border-radius: 16px; 
                border: 2px solid rgba(255, 183, 77, 0.6); 
                color: white; 
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4), inset 0 0 15px rgba(255, 167, 38, 0.15) !important;">
        
        <div style="background: rgba(255, 152, 0, 0.15); border: 1.5px solid rgba(255, 183, 77, 0.4); padding: 15px; border-radius: 10px; margin-bottom: 20px; text-align: center;">
            <p style="margin: 0; font-size: 0.85rem; color: #ffd1a9; font-weight: bold;">Selesaikan Pembayaran Dalam Waktu:</p>
            <div id="timer" style="font-size: 1.8rem; font-weight: bold; color: #ffb74d; margin-top: 5px;">10:00</div>
        </div>

        <div style="background: rgba(15, 28, 45, 0.6); padding: 20px; border-radius: 10px; margin-bottom: 25px; border: 1.5px solid rgba(255, 183, 77, 0.4); text-align: center;">
            <p style="margin-top: 0; font-size: 0.85rem; color: rgba(255, 255, 255, 0.7);">Total Pembayaran:</p>
            <h3 style="color: #ffb74d; margin: 5px 0 20px 0; font-weight: bold;">Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}</h3>

            @if($pesanan->metode_pembayaran == 'QRIS')
                <p style="font-weight: bold; color: #ffd1a9; margin-bottom: 12px; font-size: 0.9rem;">Silakan Scan QRIS Di Bawah Ini:</p>
                
                <div style="background: white; padding: 15px; display: inline-block; border-radius: 10px; border: 1.5px solid rgba(255, 183, 77, 0.6);">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=BANDENG_SAMUDERA_PAYMENT" alt="QRIS Bandeng Samudera" style="width: 170px; height: 170px;">
                </div>
                <p style="font-size: 0.78rem; color: rgba(255, 255, 255, 0.6); margin-top: 12px;">Mendukung All E-Wallet (GoPay, OVO, ShopeePay, DANA, BCA, Mandiri, dll)</p>

            @elseif($pesanan->metode_pembayaran == 'Transfer')
                <p style="font-weight: bold; color: #ffd1a9; margin-bottom: 10px; text-align: left; font-size: 0.9rem;">Transfer Ke Rekening Bank Berikut:</p>
                <div style="background: rgba(15, 28, 45, 0.85); padding: 15px; border-radius: 8px; border: 1px solid rgba(255, 183, 77, 0.3); text-align: left;">
                    <p style="margin: 5px 0; color: rgba(255, 255, 255, 0.8); font-size: 0.85rem;"><strong>Bank:</strong> BCA</p>
                    <p style="margin: 5px 0; color: rgba(255, 255, 255, 0.8); font-size: 0.85rem;"><strong>No. Rekening:</strong> <span style="font-size: 1.1rem; font-weight: bold; color: #ffb74d;">1234 5678 90</span></p>
                    <p style="margin: 5px 0; color: rgba(255, 255, 255, 0.8); font-size: 0.85rem;"><strong>Atas Nama:</strong> Bandeng Samudera</p>
                </div>

            @else
                <p style="font-weight: bold; color: #ffd1a9;">Metode Pembayaran: Cash / COD</p>
                <p style="font-size: 0.85rem; color: rgba(255, 255, 255, 0.7);">Silakan siapkan uang tunai saat pengiriman / pengambilan barang.</p>
            @endif
        </div>

        <form action="{{ route('pesanan.uploadBukti', $pesanan->no_faktur) }}" method="POST" enctype="multipart/form-data" style="text-align: left;">
            @csrf
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #ffd1a9; font-size: 0.9rem;">
                    📸 Upload Bukti Transfer / Scan :
                </label>
                <input type="file" name="bukti_bayar" required 
                       style="width: 100%; padding: 10px; border: 1.5px solid rgba(255, 183, 77, 0.4); border-radius: 8px; background: rgba(15, 28, 45, 0.6); color: white; font-size: 0.85rem;">
                <small style="color: rgba(255, 255, 255, 0.6); display: block; margin-top: 5px; font-size: 0.75rem;">Format: JPG, JPEG, PNG (Maksimal 2MB)</small>
            </div>

            <button type="submit" 
                    class="btn text-white fw-bold shadow-sm w-100" 
                    style="padding: 12px; background: linear-gradient(135deg, #f97316, #fbbf24); border: none; border-radius: 10px; font-size: 0.95rem; cursor: pointer; transition: filter 0.2s;" 
                    onmouseover="this.style.filter='brightness(1.1)'" 
                    onmouseout="this.style.filter='brightness(1)'">
                Kirim Bukti Pembayaran
            </button>
        </form>
    </div>
</div>

<div class="modal fade" id="modalExpired" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-white text-center p-4" style="background: rgba(15, 43, 72, 0.95); backdrop-filter: blur(20px); border: 1.5px solid rgba(255, 107, 107, 0.5); border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.6);">
            <div class="mb-3">
                <span class="d-inline-flex align-items-center justify-content-center bg-danger bg-opacity-25 text-danger rounded-circle" style="width: 75px; height: 75px;">
                    <i class="bi bi-clock-history fs-2"></i>
                </span>
            </div>
            <h4 class="fw-bold text-white mb-2" style="letter-spacing: 0.5px;">Waktu Pembayaran Habis!</h4>
            <p class="text-white-50 mb-4" style="font-size: 0.9rem; line-height: 1.5;">
                Batas waktu pembayaran 10 menit telah berakhir. Pesanan ini otomatis dibatalkan oleh sistem dan produk dikembalikan ke keranjang.
            </p>
            <button type="button" id="btnTutupExpired" class="btn text-white w-100 py-2.5 fw-semibold rounded-pill shadow" style="background: linear-gradient(135deg, #ef4444, #dc2626); font-size: 0.95rem; border: none;">
                Mengerti, Kembali ke Notifikasi
            </button>
        </div>
    </div>
</div>

<script>
    const tanggalPesanStr = "{{ str_replace(' ', 'T', $pesanan->tanggal_penjualan) }}";
    const waktuPesanTimestamp = new Date(tanggalPesanStr).getTime();
    
    const waktuValid = isNaN(waktuPesanTimestamp) ? new Date().getTime() : waktuPesanTimestamp;
    const batasExpired = waktuValid + (10 * 60 * 1000); // 10 menit

    let noFaktur = "{{ $pesanan->no_faktur }}";
    const displayTimer = document.getElementById('timer');
    let modalExpiredElement = document.getElementById('modalExpired');
    
    let myModal = null;
    if (modalExpiredElement && typeof bootstrap !== 'undefined') {
        myModal = new bootstrap.Modal(modalExpiredElement, {
            backdrop: 'static',
            keyboard: false
        });
    }

    function updateTimer() {
        const sekarang = new Date().getTime();
        const sisaWaktu = Math.floor((batasExpired - sekarang) / 1000);

        if (sisaWaktu <= 0) {
            clearInterval(countdownInterval);
            if (displayTimer) displayTimer.innerText = "00:00";
            
            fetch(`/pesanan/expired/${noFaktur}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(() => {
                if (myModal) {
                    myModal.show();
                } else {
                    window.location.href = "{{ route('pesanan.notifikasi') }}";
                }
            });
            return false;
        } else {
            let menit = Math.floor(sisaWaktu / 60);
            let detik = sisaWaktu % 60;

            menit = menit < 10 ? '0' + menit : menit;
            detik = detik < 10 ? '0' + detik : detik;

            if (displayTimer) {
                displayTimer.innerText = `${menit}:${detik}`;
            }
            return true;
        }
    }

    updateTimer();

    const countdownInterval = setInterval(() => {
        let lanjut = updateTimer();
        if (!lanjut) clearInterval(countdownInterval);
    }, 1000);

    const btnTutup = document.getElementById('btnTutupExpired');
    if (btnTutup) {
        btnTutup.addEventListener('click', function() {
            if (myModal) myModal.hide();
            window.location.href = "{{ route('pesanan.notifikasi') }}";
        });
    }
</script>
@endsection