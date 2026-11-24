@extends('admin.layout')

@section('title', 'Data Pegawai - Bandeng Samudra')

@section('content')
<div class="container-fluid px-0">

    <div class="p-4 rounded-4 card-glass-admin">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h4 class="fw-bold text-white mb-1">Data Pegawai</h4>
                <p class="text-secondary small mb-0">Kelola data Kasir dan Kurir / Karyawan beserta status kerja</p>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-2">
                <form method="GET" action="{{ route('admin.pegawai.index') }}" class="d-flex flex-wrap gap-2">
                    <select name="jabatan" onchange="this.form.submit()" class="form-select form-select-sm text-white border-secondary" style="background: rgba(3, 19, 31, 0.75); border-radius: 10px; min-width: 155px;">
                        <option value="">Semua Jabatan</option>
                        <option value="Kasir" {{ ($filterJabatan ?? '') === 'Kasir' ? 'selected' : '' }}>Kasir</option>
                        <option value="Karyawan" {{ ($filterJabatan ?? '') === 'Karyawan' ? 'selected' : '' }}>Kurir / Karyawan</option>
                    </select>

                    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm text-white border-secondary" style="background: rgba(3, 19, 31, 0.75); border-radius: 10px; min-width: 145px;">
                        <option value="">Semua Status</option>
                        <option value="Aktif" {{ ($filterStatus ?? '') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Cuti" {{ ($filterStatus ?? '') === 'Cuti' ? 'selected' : '' }}>Cuti</option>
                        <option value="Tidak Aktif" {{ ($filterStatus ?? '') === 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </form>

                <a href="{{ route('admin.pegawai.create') }}" class="btn text-white fw-bold px-3 py-2" style="background: linear-gradient(90deg, #0d9488 0%, #115e59 100%); border-radius: 10px;">
                    + Tambah Pegawai
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" style="--bs-table-bg: transparent;">
                <thead>
                    <tr class="text-secondary text-uppercase" style="font-size: 0.72rem; background: rgba(15, 23, 42, 0.75);">
                        <th class="py-3 px-3 border-0 rounded-start" style="width: 55px;">No</th>
                        <th class="py-3 px-3 border-0">ID Pegawai</th>
                        <th class="py-3 px-3 border-0">Nama</th>
                        <th class="py-3 px-3 border-0">Jabatan</th>
                        <th class="py-3 px-3 border-0">Email</th>
                        <th class="py-3 px-3 border-0">No. Telp</th>
                        <th class="py-3 px-3 border-0">Username</th>
                        <th class="py-3 px-3 border-0 text-center" style="min-width: 155px;">Status</th>
                        <th class="py-3 px-3 border-0 text-end rounded-end" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pegawais as $index => $pegawai)
                        @php
                            $statusStyle = match($pegawai->status) {
                                'Aktif' => 'background-color: rgba(6, 78, 59, 0.75); color: #4ade80; border: 1px solid #166534;',
                                'Cuti' => 'background-color: rgba(120, 53, 15, 0.75); color: #fbbf24; border: 1px solid #92400e;',
                                default => 'background-color: rgba(127, 29, 29, 0.75); color: #f87171; border: 1px solid #991b1b;',
                            };
                        @endphp
                        <tr style="border-bottom: 1px solid rgba(30, 41, 59, 0.65);">
                            <td class="py-3 px-3">{{ $index + 1 }}</td>
                            <td class="py-3 px-3">
                                <span class="badge bg-info text-dark fw-bold">{{ $pegawai->id_pegawai }}</span>
                            </td>
                            <td class="py-3 px-3 fw-semibold text-white">{{ $pegawai->nama }}</td>
                            <td class="py-3 px-3">
                                @if ($pegawai->jabatan === 'Kasir')
                                    <span class="badge rounded-pill px-3 py-1" style="background: rgba(14, 116, 144, 0.45); color: #67e8f9; border: 1px solid #0891b2;">
                                        Kasir
                                    </span>
                                @else
                                    <span class="badge rounded-pill px-3 py-1" style="background: rgba(67, 56, 202, 0.45); color: #c7d2fe; border: 1px solid #4f46e5;">
                                        Kurir / Karyawan
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-3 text-light">{{ $pegawai->email ?: '-' }}</td>
                            <td class="py-3 px-3 text-light">{{ $pegawai->no_telp ?: '-' }}</td>
                            <td class="py-3 px-3" style="color: #5eead4;">{{ $pegawai->username }}</td>
                            <td class="py-3 px-3 text-center">
                                <form action="{{ route('admin.pegawai.updateStatus', $pegawai->id_pegawai) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm fw-semibold rounded-pill px-3" style="{{ $statusStyle }} cursor: pointer; min-width: 135px;">
                                        <option value="Aktif" style="background: #0f172a; color: #4ade80;" {{ $pegawai->status === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Cuti" style="background: #0f172a; color: #fbbf24;" {{ $pegawai->status === 'Cuti' ? 'selected' : '' }}>Cuti</option>
                                        <option value="Tidak Aktif" style="background: #0f172a; color: #f87171;" {{ $pegawai->status === 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                </form>
                            </td>
                            <td class="py-3 px-3 text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('admin.pegawai.edit', $pegawai->id_pegawai) }}" class="btn btn-sm btn-primary px-3">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.pegawai.destroy', $pegawai->id_pegawai) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pegawai {{ $pegawai->nama }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger px-3">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-secondary py-4">
                                Belum ada data pegawai yang sesuai filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection