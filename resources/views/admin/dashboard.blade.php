@extends('admin.layout')

@section('title', 'Dashboard - Bandeng Samudra')

@section('content')
@php
    $urlLaporan = \Illuminate\Support\Facades\Route::has('admin.laporan.index')
        ? route('admin.laporan.index')
        : url('/admin/laporan');
@endphp

<div class="container-fluid px-0">

    <!-- 4 Kartu Statistik -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card p-4 rounded-4 border border-secondary h-100" style="background: rgba(11, 25, 44, 0.88);">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-secondary small mb-2">Total Produk Bandeng</div>
                        <div class="text-info fw-bold fs-2">{{ $totalProduk ?? 0 }}</div>
                    </div>
                    <div class="fs-2">🐟</div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card p-4 rounded-4 border border-secondary h-100" style="background: rgba(11, 25, 44, 0.88);">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-secondary small mb-2">Total Pesanan</div>
                        <div class="text-success fw-bold fs-2">{{ $totalPesanan ?? 0 }}</div>
                    </div>
                    <div class="fs-2">🛒</div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card p-4 rounded-4 border border-secondary h-100" style="background: rgba(11, 25, 44, 0.88);">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-secondary small mb-2">Pendapatan Bulan Ini</div>
                        <div class="text-warning fw-bold fs-3">Rp {{ number_format($pendapatanBulanIni ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <div class="fs-2">💰</div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card p-4 rounded-4 border border-secondary h-100" style="background: rgba(11, 25, 44, 0.88);">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-secondary small mb-2">Total Customer</div>
                        <div class="text-primary fw-bold fs-2">{{ $totalCustomer ?? 0 }}</div>
                    </div>
                    <div class="fs-2">👥</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Transaksi Penjualan Terbaru -->
    <div class="card p-4 rounded-4 border border-secondary" style="background: rgba(11, 25, 44, 0.88); border-color: rgba(13, 202, 240, 0.25) !important;">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <h5 class="fw-bold text-white mb-0">
                <i class="fa-solid fa-clock-rotate-left text-info me-2"></i>Transaksi Penjualan Terbaru
            </h5>
            <a href="{{ $urlLaporan }}" class="btn btn-outline-info btn-sm px-3">
                Lihat Semua Laporan
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" style="--bs-table-bg: transparent;">
                <thead>
                    <tr class="text-secondary border-bottom border-secondary">
                        <th style="width: 60px;">No</th>
                        <th>Tanggal</th>
                        <th>Invoice</th>
                        <th>Customer</th>
                        <th>Total Harga</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksiTerbaru ?? [] as $index => $trx)
                        <tr class="border-bottom border-secondary border-opacity-25">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ !empty($trx->tanggal_penjualan) ? date('d-m-Y', strtotime($trx->tanggal_penjualan)) : '-' }}</td>
                            <td class="text-info fw-semibold">{{ $trx->no_faktur ?? '-' }}</td>
                            <td class="text-white">{{ $trx->nama_customer ?? '-' }}</td>
                            <td class="text-light fw-semibold">Rp {{ number_format($trx->total_harga ?? 0, 0, ',', '.') }}</td>
                            <td class="text-center">
                                @php $status = $trx->status_pembayaran ?? '-'; @endphp
                                <span class="badge {{ $status == 'Lunas' ? 'bg-success' : ($status == 'Batal' ? 'bg-danger' : 'bg-warning text-dark') }} px-3 py-1">
                                    {{ $status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-secondary py-4">
                                Belum ada data transaksi penjualan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection