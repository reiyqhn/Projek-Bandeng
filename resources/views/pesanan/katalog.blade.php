@extends('layouts.app')

@section('content')
    <style>
    .custom-modal-overlay {
        display: none; 
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(13, 35, 58, 0.15); 
        backdrop-filter: blur(3px);
        -webkit-backdrop-filter: blur(3px);
        z-index: 1050;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .custom-modal-content {
        transform: scale(0.85);
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .custom-modal-overlay.active {
        display: flex;
        opacity: 1;
    }

    .custom-modal-overlay.active .custom-modal-content {
        transform: scale(1);
    }

    .btn-pesan-hidup:hover {
        transform: translateY(-2px);
        background: rgba(21, 96, 160, 0.95) !important;
        box-shadow: 0 6px 20px rgba(15, 76, 129, 0.4) !important;
    }
    </style>

    
    <div class="mb-4">
        <h1 class="fw-bold mb-1" style="font-size: 2.2rem; letter-spacing: 0.5px; background: linear-gradient(90deg, #ffffff 15%, #ffd1a9 50%, #f97316 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block; filter: drop-shadow(0px 2px 4px rgba(0, 0, 0, 0.3));">
            Bandeng Samudera
        </h1>
        <p class="text-white-50 mb-0" style="font-size: 0.9rem;">Bandeng segar premium dari Temanggung</p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger py-2 mb-4" style="font-size: 0.85rem; border-radius: 10px;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="d-flex flex-column gap-3 pb-5">
        @forelse($produks as $produk)
            <div class="p-3 p-md-3.5 rounded-4 d-flex flex-column flex-md-row align-items-center justify-content-between gap-3" 
                 style="background: rgba(255, 255, 255, 0.08); 
                        backdrop-filter: blur(16px); 
                        -webkit-backdrop-filter: blur(16px); 
                        border: 1.5px solid rgba(255, 255, 255, 0.18); 
                        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.25);
                        max-width: 820px; 
                        width: 100%;">
                
                <div style="width: 150px; height: 110px; border-radius: 14px; overflow: hidden; flex-shrink: 0;" class="shadow-sm">
                    @if(isset($produk->foto) && $produk->foto)
                        <img src="{{ asset('uploads/bukti/' . basename($produk->foto)) }}" alt="{{ $produk->nama_bandeng }}" class="w-100 h-100 object-fit-cover">
                    @else
                        <img src="{{ asset('image/Bandeng1.jpeg') }}" alt="{{ $produk->nama_bandeng }}" class="w-100 h-100 object-fit-cover">
                    @endif
                </div>

                <div class="flex-grow-1 text-center text-md-start">
                    <h4 class="fw-bold mb-1" style="font-size: 1.3rem; background: linear-gradient(90deg, #ffffff 20%, #ffd1a9 70%, #f97316 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block; filter: drop-shadow(0px 1px 2px rgba(0, 0, 0, 0.2));">
                        {{ $produk->nama_bandeng }}
                    </h4>
                    <p class="text-white-50 mb-1" style="font-size: 0.82rem; line-height: 1.4; max-width: 400px;">
                        Daging tebal, gurih, tanpa lumpur. <br>
                        Berat {{ $produk->satuan }}.
                    </p>
                    
                    <div class="mb-2" style="font-size: 0.78rem;">
                        @if($produk->stok > 0)
                            <span class="text-warning fw-medium"><i class="bi bi-box-seam me-1"></i> Stok: {{ $produk->stok }}</span>
                        @else
                            <span class="text-danger fw-bold"><i class="bi bi-x-circle me-1"></i> Stok Habis</span>
                        @endif
                    </div>

                    <div class="fw-bold" style="font-size: 1.2rem; color: #fbbf24;">
                        Rp {{ number_format($produk->harga, 0, ',', '.') }} 
                        <span class="text-white-50 fw-normal" style="font-size: 0.8rem;">/ ekor</span>
                    </div>
                </div>

                <div class="flex-shrink-0">
                    @if($produk->stok > 0)
                        <button type="button" 
                                class="btn text-white fw-medium px-4 py-2 btn-pesan-hidup" 
                                onclick="bukaModal('{{ $produk->id_bandeng }}', '{{ $produk->nama_bandeng }}', '{{ $produk->harga }}', '{{ $produk->stok }}')"
                                style="background: rgba(15, 76, 129, 0.85); 
                                        border: 1px solid rgba(255, 255, 255, 0.4); 
                                        border-radius: 10px; 
                                        font-size: 0.85rem; 
                                        backdrop-filter: blur(4px);
                                        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                                        transition: all 0.3s ease;">
                            Pesan Sekarang
                        </button>
                    @else
                        <button class="btn btn-secondary fw-medium px-4 py-2" disabled style="border-radius: 10px; font-size: 0.85rem; opacity: 0.6;">
                            Habis
                        </button>
                    @endif
                </div>

            </div>
        @empty
            <div class="p-5 text-center rounded-4" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); max-width: 820px;">
                <i class="bi bi-inbox fs-1 text-white-50 mb-2 d-block"></i>
                <h5 class="text-white fw-bold mb-1">Belum Ada Menu Bandeng</h5>
                <p class="text-white-50 mb-0" style="font-size: 0.85rem;">Produk bandeng akan segera hadir di sini.</p>
            </div>
        @endforelse
    </div>


    <div id="customModal" class="custom-modal-overlay">
        <div class="custom-modal-content p-3 position-relative shadow-lg" 
             style="background: rgba(30, 45, 65, 0.45); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border-radius: 16px; border: 2px solid rgba(255, 183, 77, 0.6); color: white; width: 100%; max-width: 350px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4), inset 0 0 15px rgba(255, 167, 38, 0.15) !important;">
            
            <button type="button" onclick="tutupModal()" class="btn-close btn-close-white position-absolute" aria-label="Close" style="top: 15px; right: 15px; font-size: 0.8rem; cursor: pointer;"></button>

            <h4 class="fw-bold text-center mb-1" style="font-family: 'Arial Black', sans-serif; font-size: 1.15rem; background: linear-gradient(90deg, #ffffff 30%, #ffb74d 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Konfirmasi Pesanan</h4>
            <p class="text-white-50 text-center mb-3" style="font-size: 0.75rem;">Masukan jumlah ekor yang diinginkan :</p>
            
            <div class="text-center mb-2">
                <h5 class="fw-bold text-white mb-1" id="modalNamaProduk" style="font-size: 0.95rem;">-</h5>
                <span class="badge px-2 py-1" id="modalStokProduk" style="background: rgba(255, 183, 77, 0.2); color: #ffb74d; font-size: 0.7rem; border-radius: 20px; border: 1px solid rgba(255, 183, 77, 0.4);">
                    Sisa Stok: 0
                </span>
            </div>

            <form action="{{ route('keranjang.tambah') }}" method="POST">
                @csrf
                <input type="hidden" name="produk_id" id="modalProdukId" value="">
                <input type="hidden" name="jumlah" id="jumlahModal" value="1">

                <div class="d-flex align-items-center justify-content-center gap-2 my-2">
                    <button type="button" onclick="ubahJumlahModal(-1)" class="btn text-white fw-bold d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; border-radius: 50%; border: 1.5px solid rgba(255, 183, 77, 0.5); background: rgba(255, 183, 77, 0.15); font-size: 15px; transition: background 0.2s;" onmouseover="this.style.background='rgba(255, 183, 77, 0.3)'" onmouseout="this.style.background='rgba(255, 183, 77, 0.15)'">-</button>
                    
                    <div class="d-flex align-items-center justify-content-center fw-bold text-white" 
                         style="width: 60px; height: 38px; background: rgba(15, 28, 45, 0.6); border: 1.5px solid rgba(255, 183, 77, 0.4); border-radius: 8px; font-size: 1rem;">
                        <span id="textJumlah">1</span>
                    </div>
                    
                    <button type="button" onclick="ubahJumlahModal(1)" class="btn text-white fw-bold d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; border-radius: 50%; border: 1.5px solid rgba(255, 183, 77, 0.5); background: rgba(255, 183, 77, 0.15); font-size: 15px; transition: background 0.2s;" onmouseover="this.style.background='rgba(255, 183, 77, 0.3)'" onmouseout="this.style.background='rgba(255, 183, 77, 0.15)'">+</button>
                </div>

                <div class="text-center my-2 py-2 px-2" style="background: rgba(15, 28, 45, 0.5); border-radius: 10px; border: 1px solid rgba(255, 183, 77, 0.3);">
                    <span class="text-white-50" style="font-size: 0.75rem;">Total :</span>
                    <h4 id="totalHargaModal" class="fw-bold mb-0" style="color: #ffb74d; font-size: 1.15rem;">Rp 0</h4>
                </div>

                <div class="text-center mt-3">
                    <button type="submit" class="btn fw-bold text-white py-2 w-100 shadow-sm" style="background: linear-gradient(135deg, #1768ea, #7dc0ea); border-radius: 8px; font-size: 0.85rem; border: 1px solid rgba(255, 255, 255, 0.4); transition: filter 0.2s;" onmouseover="this.style.filter='brightness(1.1)'" onmouseout="this.style.filter='brightness(1)'">
                        Masukan Keranjang
                    </button>
                </div>
                
                <div class="text-center mt-2">
                    <button type="button" onclick="tutupModal()" class="btn text-white-50 text-decoration-none p-0 border-0 bg-transparent" style="font-size: 0.75rem; cursor: pointer;">Batal</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        let hargaSatuanGlobal = 0;
        let maxStokGlobal = 1;

        function bukaModal(id, nama, harga, stok) {
            hargaSatuanGlobal = parseInt(harga);
            maxStokGlobal = parseInt(stok);

            document.getElementById('modalProdukId').value = id;
            document.getElementById('modalNamaProduk').innerText = nama;
            document.getElementById('modalStokProduk').innerText = 'Sisa Stok: ' + stok;
            
            document.getElementById('jumlahModal').value = 1;
            document.getElementById('textJumlah').innerText = 1;

            document.getElementById('totalHargaModal').innerText = 'Rp ' + hargaSatuanGlobal.toLocaleString('id-ID');

            const modal = document.getElementById('customModal');
            modal.style.display = 'flex';
            setTimeout(() => {
                modal.classList.add('active');
            }, 10);
        }

        function tutupModal() {
            const modal = document.getElementById('customModal');
            modal.classList.remove('active');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }

        function ubahJumlahModal(val) {
            let jumlahSekarang = parseInt(document.getElementById('jumlahModal').value) + val;
            
            if (jumlahSekarang < 1) jumlahSekarang = 1;
            if (jumlahSekarang > maxStokGlobal) jumlahSekarang = maxStokGlobal;

            document.getElementById('jumlahModal').value = jumlahSekarang;
            document.getElementById('textJumlah').innerText = jumlahSekarang;

            let total = hargaSatuanGlobal * jumlahSekarang;
            document.getElementById('totalHargaModal').innerText = 'Rp ' + total.toLocaleString('id-ID');
        }
    </script>
@endsection