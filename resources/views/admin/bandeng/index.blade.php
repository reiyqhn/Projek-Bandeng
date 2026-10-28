
@extends('admin.layout')

@section('title', 'Data Bandeng - Projek Bandeng')

@section('content')
<div class="data-page">

    @if (session('success'))
        <div class="alert-success">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert-error">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="bandeng-list-panel" id="daftar-bandeng">
        <div class="bandeng-list-header">
            <div>
                <h2>Daftar Data Bandeng</h2>
                <p>Kelola semua data bandeng yang tersedia.</p>
            </div>

            <a href="{{ route('admin.bandeng.create') }}"
               class="btn-primary btn-add-bandeng">
                + Tambah Bandeng
            </a>
        </div>

        <div class="table-responsive bandeng-table-wrapper">
            <table class="bandeng-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Bandeng</th>
                        <th>Berat</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($produks as $produk)
                        <tr>
                            <td class="number-cell">
                                {{ $produks->firstItem() + $loop->index }}
                            </td>

                            <td>
                                @if ($produk->foto)
                                    <img
                                        src="{{ asset('uploads/bukti/' . basename($produk->foto)) }}"
                                        alt="Foto {{ $produk->nama_bandeng }}"
                                        class="product-thumbnail"
                                    >
                                @else
                                    <div class="no-photo">No Foto</div>
                                @endif
                            </td>

                            <td class="product-name">
                                {{ $produk->nama_bandeng }}
                            </td>

                            <td class="weight-cell">
                                {{ $produk->berat }}
                            </td>

                            <td class="price-cell">
                                Rp {{ number_format((float) $produk->harga, 0, ',', '.') }}
                            </td>

                            <td>
                                <span class="stock-badge {{ $produk->stok < 5 ? 'stock-low' : '' }}">
                                    {{ $produk->stok }}
                                </span>
                            </td>

                            <td class="description-cell">
                                {{ $produk->deskripsi ?: '-' }}
                            </td>

                            <td>
                                <div class="action-buttons">

                                    {{-- TOMBOL EDIT --}}
                                    <a
                                        href="{{ route('admin.bandeng.edit', ['produk' => $produk->id_bandeng]) }}"
                                        class="btn-edit"
                                    >
                                        ✏️ Edit
                                    </a>

                                    {{-- TOMBOL HAPUS --}}
                                    <form
                                        action="{{ route('admin.bandeng.destroy', $produk->id_bandeng) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data bandeng ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn-delete">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty-state">
                                <div class="empty-icon">🐟</div>
                                <strong>Belum Ada Data Bandeng</strong>
                                <p>Tambahkan produk bandeng untuk mulai mengelola inventaris.</p>

                                <a href="{{ route('admin.bandeng.create') }}"
                                   class="btn-primary">
                                    + Tambah Bandeng
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bandeng-pagination">
            {{ $produks->links() }}
        </div>
    </section>
</div>
@endsection
