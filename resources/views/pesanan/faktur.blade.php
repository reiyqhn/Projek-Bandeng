@extends('layouts.app')

@section('title', 'Faktur Penjualan #' . $faktur->no_faktur)

@section('content')
<div style="max-width: 820px; width: 100%; margin: 0 auto;" class="pb-5">

    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <a href="{{ route('pesanan.notifikasi') }}" class="btn btn-sm text-white px-3 py-2" style="background: rgba(255, 255, 255, 0.12); border: 1px solid rgba(255, 255, 255, 0.25); border-radius: 10px;">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>

        <button type="button" onclick="window.print()" class="btn btn-sm text-white fw-semibold px-4 py-2" style="background: linear-gradient(90deg, #00b4d8 0%, #0077b6 100%); border-radius: 10px;">
            <i class="bi bi-printer me-1"></i> Cetak Faktur
        </button>
    </div>

    <div id="area-faktur-customer" class="p-4 p-md-5 rounded-4 text-white"
         style="background: rgba(15, 28, 46, 0.85);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border: 1.5px solid rgba(56, 189, 248, 0.35);
                box-shadow: 0 12px 36px rgba(0, 0, 0, 0.4);">

        <!-- HEADER FAKTUR -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-start border-bottom border-light border-opacity-15 pb-4 mb-4 gap-3">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('image/Logo_Bandeng.png') }}" alt="Logo Bandeng Samudera" style="width: 56px; height: auto;">
                <div>
                    <h3 class="fw-bold mb-0 text-white" style="letter-spacing: 0.5px;">Bandeng Samudera</h3>
                    <small class="text-white-50">Temanggung, Jawa Tengah</small>
                </div>
            </div>

            <div class="text-sm-end">
                <h5 class="fw-bold text-uppercase mb-1" style="letter-spacing: 1.5px; color: #38bdf8;">FAKTUR PENJUALAN</h5>
                <div class="small text-white-50">No : <strong class="text-info">{{ $faktur->no_faktur }}</strong></div>
                <div class="small text-white-50">Tanggal : <strong class="text-white">{{ \Carbon\Carbon::parse($faktur->tgl_cetak_faktur ?? $faktur->tanggal_penjualan)->format('d/m/Y H:i') }} WIB</strong></div>
            </div>
        </div>

        <!-- DATA CUSTOMER -->
        <div class="p-3 p-md-4 rounded-3 mb-4" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12);">
            <div class="text-uppercase fw-bold text-white-50 mb-2" style="font-size: 0.72rem; letter-spacing: 1px;">Data Customer</div>
            <div class="row g-2 small">
                <div class="col-sm-6">
                    <span class="text-white-50">Nama :</span>
                    <strong class="text-white ms-1">{{ $faktur->nama_customer }}</strong>
                </div>
                <div class="col-sm-6">
                    <span class="text-white-50">Metode Pesanan :</span>
                    <strong class="text-white ms-1">{{ $faktur->metode_pemesanan ?? 'Delivery' }}</strong>
                </div>
                <div class="col-sm-6">
                    <span class="text-white-50">Pembayaran :</span>
                    <strong class="text-white ms-1">{{ $faktur->metode_pembayaran }}</strong>
                </div>
                <div class="col-sm-6">
                    <span class="text-white-50">Status :</span>
                    <span class="badge bg-success ms-1">{{ $faktur->status_pembayaran }}</span>
                </div>
                @if(($faktur->metode_pemesanan ?? 'Delivery') === 'Delivery' && !empty($faktur->alamat_customer))
                <div class="col-12 mt-1">
                    <span class="text-white-50">Alamat Tujuan :</span>
                    <strong class="text-white ms-1">{{ $faktur->alamat_customer }}</strong>
                </div>
                @endif
            </div>
        </div>

        <!-- TABEL DETAIL PESANAN -->
        <div class="mb-4">
            <div class="text-uppercase fw-bold text-white-50 mb-2" style="font-size: 0.72rem; letter-spacing: 1px;">Detail Pesanan</div>
            <div class="table-responsive">
                <table class="table table-dark table-borderless align-middle mb-0" style="--bs-table-bg: transparent;">
                    <thead style="background: rgba(255, 255, 255, 0.08); font-size: 0.75rem; text-transform: uppercase;">
                        <tr>
                            <th class="py-2.5 px-3 rounded-start" style="width: 55px;">No</th>
                            <th class="py-2.5 px-3">Produk</th>
                            <th class="py-2.5 px-3">Jumlah</th>
                            <th class="py-2.5 px-3">Harga</th>
                            <th class="py-2.5 px-3 text-end rounded-end">Total</th>
                        </tr>
                    </thead>
                    <tbody class="small" style="border-top: 1px solid rgba(255, 255, 255, 0.12);">
                        @foreach($details as $idx => $det)
                        <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                            <td class="py-3 px-3 text-white-50">{{ $idx + 1 }}</td>
                            <td class="py-3 px-3 fw-semibold text-white">{{ $det->nama_bandeng }}</td>
                            <td class="py-3 px-3">{{ $det->jumlah }} Porsi / Kg</td>
                            <td class="py-3 px-3">Rp {{ number_format($det->harga_item, 0, ',', '.') }}</td>
                            <td class="py-3 px-3 text-end fw-semibold text-white">Rp {{ number_format($det->jumlah * $det->harga_item, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach

                        @if(($faktur->ongkir ?? 0) > 0)
                        <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                            <td class="py-3 px-3 text-white-50">-</td>
                            <td class="py-3 px-3 text-info fw-semibold" colspan="3">Ongkos Kirim</td>
                            <td class="py-3 px-3 text-end fw-semibold text-white">Rp {{ number_format($faktur->ongkir, 0, ',', '.') }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TOTAL PEMBAYARAN -->
        <div class="d-flex justify-content-end pt-2">
            <div class="px-4 py-3 rounded-3 text-end" style="background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(251, 191, 36, 0.4);">
                <small class="text-uppercase text-white-50 d-block" style="font-size: 0.7rem; letter-spacing: 1px;">Total Pembayaran</small>
                <span class="fw-bold fs-4" style="color: #fbbf24;">Rp {{ number_format($faktur->subtotal, 0, ',', '.') }}</span>
            </div>
        </div>

    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    #area-faktur-customer, #area-faktur-customer * {
        visibility: visible;
    }
    #area-faktur-customer {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        background: #ffffff !important;
        color: #111827 !important;
        border: none !important;
        box-shadow: none !important;
        padding: 24px !important;
    }
    #area-faktur-customer .text-white,
    #area-faktur-customer .text-white-50,
    #area-faktur-customer strong,
    #area-faktur-customer td,
    #area-faktur-customer th {
        color: #111827 !important;
    }
    .no-print {
        display: none !important;
    }
}
</style>
@endsection