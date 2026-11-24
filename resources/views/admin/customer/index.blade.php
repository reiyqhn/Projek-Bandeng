@extends('admin.layout')

@section('title', 'Data Customer - Bandeng Samudra')

@section('content')
<div class="container-fluid px-0">

    @if (session('success'))
        <div class="alert alert-success bg-success bg-opacity-25 border-0 text-white mb-4 rounded-4 p-3">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger bg-danger bg-opacity-25 border-0 text-white mb-4 rounded-4 p-3">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="card p-4 rounded-4 border border-secondary" style="background: rgba(11, 25, 44, 0.88); border-color: rgba(13, 202, 240, 0.25) !important;">
        <div class="mb-4">
            <h4 class="fw-bold text-white mb-1">Data Customer</h4>
            <p class="text-secondary small mb-0">Daftar seluruh akun customer yang terdaftar di sistem</p>
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" style="--bs-table-bg: transparent;">
                <thead>
                    <tr class="text-secondary border-bottom border-secondary">
                        <th style="width: 55px;">No</th>
                        <th>ID Customer</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. Telp</th>
                        <th>Alamat</th>
                        <th>Username</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $index => $customer)
                        <tr class="border-bottom border-secondary border-opacity-25">
                            <td>{{ $index + 1 }}</td>
                            <td><span class="badge bg-info text-dark fw-bold">{{ $customer->id_customer }}</span></td>
                            <td class="fw-semibold text-white">{{ $customer->nama }}</td>
                            <td class="text-light">{{ $customer->email ?: '-' }}</td>
                            <td class="text-light">{{ $customer->no_telp ?? '-' }}</td>
                            <td class="text-secondary small" style="max-width: 240px;">{{ $customer->alamat ?? '-' }}</td>
                            <td class="text-info">{{ $customer->username }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-secondary py-4">
                                Belum ada data customer di database.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection