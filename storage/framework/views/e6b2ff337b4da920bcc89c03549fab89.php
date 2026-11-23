<?php $__env->startSection('content'); ?>
<div style="max-width: 650px; margin: 0 auto; width: 100%;">
    
    <div class="mb-4">
        <h1 class="fw-bold mb-1" style="font-size: 2.2rem; letter-spacing: 0.5px; background: linear-gradient(90deg, #ffffff 15%, #ffd1a9 50%, #f97316 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block; filter: drop-shadow(0px 2px 4px rgba(0, 0, 0, 0.3);">
            Checkout Pesanan
        </h1>
    </div>

    
    <?php if(session('error')): ?>
        <div style="background: rgba(239, 68, 68, 0.2); border: 1.5px solid #ef4444; color: #fecaca; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem;">
            ⚠️ <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="p-4 p-md-4 rounded-4 shadow-lg" 
         style="background: rgba(30, 45, 65, 0.45); 
                backdrop-filter: blur(12px); 
                -webkit-backdrop-filter: blur(12px); 
                border-radius: 16px; 
                border: 2px solid rgba(255, 183, 77, 0.6); 
                color: white; 
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4), inset 0 0 15px rgba(255, 167, 38, 0.15) !important;">
        
        <form action="<?php echo e(route('pesanan.prosesCheckout')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #ffd1a9; font-size: 0.9rem;">
                    🛵 Metode Pesanan :
                </label>
                <select id="metode_pesanan" name="metode_pesanan" required 
                        style="width: 100%; padding: 12px; background: rgba(15, 28, 45, 0.85); border: 1.5px solid rgba(255, 183, 77, 0.4); border-radius: 10px; color: white; font-size: 0.9rem; outline: none;"
                        onchange="cekMetodePesanan()">
                    <option value="Delivery" style="background: #0f1c2d; color: white;">Delivery (Diantar Kurir)</option>
                    <option value="Takeaway" style="background: #0f1c2d; color: white;">Takeaway (Ambil Sendiri ke Toko)</option>
                </select>
            </div>

            <div id="wrapper-wilayah" style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #ffd1a9; font-size: 0.9rem;">
                    📍 Wilayah Pengiriman :
                </label>
                <select id="wilayah_pengiriman" name="wilayah_pengiriman" required 
                        style="width: 100%; padding: 12px; background: rgba(15, 28, 45, 0.85); border: 1.5px solid rgba(255, 183, 77, 0.4); border-radius: 10px; color: white; font-size: 0.9rem; outline: none;" 
                        onchange="hitungTotal()">
                    <option value="" data-ongkir="0" style="background: #0f1c2d; color: white;"> Pilih Kecamatan / Wilayah Pengiriman </option>
                    
                    <!-- zona temanggung -->
                    <option value="Kec. Temanggung / Parakan / Bulu" data-ongkir="7000" style="background: #0f1c2d; color: white;">Temanggung / Parakan / Bulu (Rp 7.000)</option>
                    <option value="Kec. Kedu / Kranggan / Tlogomulyo" data-ongkir="10000" style="background: #0f1c2d; color: white;">Kedu / Kranggan / Tlogomulyo (Rp 10.000)</option>
                    <option value="Kec. Ngadirejo / Selopampang / Pringsurat" data-ongkir="15000" style="background: #0f1c2d; color: white;">Ngadirejo / Selopampang / Pringsurat (Rp 15.000)</option>
                    <option value="Kec. Candiroto / Kaloran / Jumo" data-ongkir="18000" style="background: #0f1c2d; color: white;">Candiroto / Kaloran / Jumo (Rp 18.000)</option>
                    <option value="Kec. Tretep / Bejen / Gemawang / Wonoboyo" data-ongkir="25000" style="background: #0f1c2d; color: white;">Tretep / Bejen / Gemawang / Wonoboyo (Rp 25.000)</option>

                    <!-- luar temanggung -->
                    <option value="Luar Kab. Temanggung (Kirim via J&T)" data-ongkir="20000" style="background: #0f1c2d; color: white;">Luar Kab. Temanggung via J&T (Rp 20.000)</option>
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #ffd1a9; font-size: 0.9rem;">
                    🏠 Alamat :
                </label>
                <textarea name="alamat" rows="3" required 
                          style="width: 100%; padding: 12px; background: rgba(15, 28, 45, 0.6); border: 1.5px solid rgba(255, 183, 77, 0.4); border-radius: 10px; box-sizing: border-box; color: white; font-size: 0.9rem; outline: none;" 
                          placeholder="Masukkan detail jalan, nomor rumah, RT/RW, desa/kelurahan, dll..."></textarea>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #ffd1a9; font-size: 0.9rem;">
                    💳 Metode Pembayaran :
                </label>
                <select name="metode_pembayaran" required 
                        style="width: 100%; padding: 12px; background: rgba(15, 28, 45, 0.85); border: 1.5px solid rgba(255, 183, 77, 0.4); border-radius: 10px; color: white; font-size: 0.9rem; outline: none;">
                    <option value="QRIS" style="background: #0f1c2d; color: white;">QRIS</option>
                    <option value="Transfer" style="background: #0f1c2d; color: white;">Transfer Bank</option>
                    <option value="Cash" style="background: #0f1c2d; color: white;">COD (bayar ditempat)</option>
                </select>
            </div>

            <div style="background: rgba(15, 28, 45, 0.6); padding: 15px 20px; border-radius: 10px; margin-bottom: 25px; border: 1.5px solid rgba(255, 183, 77, 0.4);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; font-size: 0.9rem; color: rgba(255, 255, 255, 0.8);">
                    <span>Subtotal Produk:</span>
                    <span>Rp <?php echo e(number_format($totalHarga, 0, ',', '.')); ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; font-size: 0.9rem; color: rgba(255, 255, 255, 0.8);">
                    <span>Ongkos Kirim:</span>
                    <span id="text-ongkir" style="color: #ffd1a9; font-weight: bold;">Rp 0</span>
                </div>
                <hr style="border-color: rgba(255, 183, 77, 0.3); margin: 8px 0;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-weight: bold; color: white;">Total Pembayaran:</span>
                    <span id="text-total" style="font-size: 1.25rem; font-weight: bold; color: #ffb74d;">Rp <?php echo e(number_format($totalHarga, 0, ',', '.')); ?></span>
                </div>
            </div>

            <input type="hidden" id="input_ongkir" name="ongkir" value="0">
            <input type="hidden" id="input_total" name="total_bayar" value="<?php echo e($totalHarga); ?>">

            <div style="display: flex; justify-content: space-between; align-items: center;">
                <a href="<?php echo e(route('pesanan.keranjang')); ?>" style="color: rgba(255, 255, 255, 0.7); text-decoration: none; font-size: 0.85rem; transition: color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255, 183, 77, 0.7)'">
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

<script>
    const subtotalAwal = <?php echo e($totalHarga); ?>;

    function hitungTotal() {
        const selectWilayah = document.getElementById('wilayah_pengiriman');
        const selectedOption = selectWilayah.options[selectWilayah.selectedIndex];
        
        const ongkir = parseInt(selectedOption.getAttribute('data-ongkir')) || 0;
        updateFinal(ongkir);
    }

    function cekMetodePesanan() {
        const metodePesanan = document.getElementById('metode_pesanan').value;
        const selectWilayah = document.getElementById('wilayah_pengiriman');

        if (metodePesanan === 'Takeaway') {
            selectWilayah.value = "";
            selectWilayah.required = false;
            document.getElementById('wrapper-wilayah').style.display = 'none';
            updateFinal(0);
        } else {
            document.getElementById('wrapper-wilayah').style.display = 'block';
            selectWilayah.required = true;
            hitungTotal();
        }
    }

    function updateFinal(ongkir) {
        const totalKeseluruhan = subtotalAwal + ongkir;

        document.getElementById('text-ongkir').innerText = 'Rp ' + ongkir.toLocaleString('id-ID');
        document.getElementById('text-total').innerText = 'Rp ' + totalKeseluruhan.toLocaleString('id-ID');

        document.getElementById('input_ongkir').value = ongkir;
        document.getElementById('input_total').value = totalKeseluruhan;
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Projek-Bandeng\resources\views/pesanan/checkout.blade.php ENDPATH**/ ?>