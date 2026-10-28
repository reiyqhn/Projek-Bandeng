<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProdukController extends Controller
{
    public function index(){
        $produks = Produk::paginate(5);

        return view('admin.bandeng.index', compact('produks'));
    }

    public function create(){
        return view('admin.bandeng.create');
    }

    public function store(Request $request){
        $request->validate([
            'nama_bandeng' => 'required|string|max:255',
            'satuan'       => 'required|string|max:100',
            'harga'        => 'required|numeric|min:0',
            'stok'         => 'required|integer|min:0',
            'deskripsi'    => 'nullable|string',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'nama_bandeng',
            'satuan',
            'harga',
            'stok',
            'deskripsi',
        ]);

        $lastBandeng = Produk::orderBy('id_bandeng', 'desc')->first();
        $nextNumber = $lastBandeng ? (int) substr($lastBandeng->id_bandeng, 2) + 1 : 1;
        $data['id_bandeng'] = 'BD' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        if ($request->hasFile('foto')) {
            $folder = public_path('uploads/bukti');

            if (!File::exists($folder)) {
                File::makeDirectory($folder, 0755, true);
            }

            $foto = $request->file('foto');
            $namaFoto = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();

            $foto->move($folder, $namaFoto);

            $data['foto'] = $namaFoto;
        }

        Produk::create($data);

        return redirect()
            ->route('admin.bandeng.index')
            ->with('success', 'Data bandeng berhasil ditambahkan.');
    }

    public function edit($produk){
        $produk = Produk::where('id_bandeng', $produk)->firstOrFail();
        return view('admin.bandeng.edit', compact('produk'));
    }

    public function update(Request $request, $produk){
        $itemProduk = Produk::where('id_bandeng', $produk)->firstOrFail();

        $request->validate([
            'nama_bandeng' => 'required|string|max:255',
            'satuan'       => 'required|string|max:100',
            'harga'        => 'required|numeric|min:0',
            'stok'         => 'required|integer|min:0',
            'deskripsi'    => 'nullable|string',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'nama_bandeng',
            'satuan',
            'harga',
            'stok',
            'deskripsi',
        ]);

        if ($request->hasFile('foto')) {
            $folder = public_path('uploads/bukti');

            if (!File::exists($folder)) {
                File::makeDirectory($folder, 0755, true);
            }

            if ($itemProduk->foto) {
                $fotoLama = $folder . DIRECTORY_SEPARATOR . basename($itemProduk->foto);

                if (File::exists($fotoLama)) {
                    File::delete($fotoLama);
                }
            }

            $foto = $request->file('foto');
            $namaFoto = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();

            $foto->move($folder, $namaFoto);

            $data['foto'] = $namaFoto;
        }

        $itemProduk->update($data);

        return redirect()
            ->route('admin.bandeng.index')
            ->with('success', 'Data bandeng berhasil diperbarui.');
    }

    public function destroy($id){
        $produk = Produk::where('id_bandeng', $id)->firstOrFail();

        try {
            if (method_exists($produk, 'detailPenjualan') && $produk->detailPenjualan()->count() > 0) {
                return redirect()->back()->with('error', 'Produk tidak dapat dihapus karena sudah memiliki riwayat transaksi!');
            }

            if ($produk->foto) {
                $fotoLama = public_path(
                    'uploads/bukti/' . basename($produk->foto)
                );

                if (File::exists($fotoLama)) {
                    File::delete($fotoLama);
                }
            }

            $produk->delete();

            return redirect()
                ->route('admin.bandeng.index')
                ->with('success', 'Data bandeng berhasil dihapus.');
                
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()
                ->route('admin.bandeng.index')
                ->with('error', 'Gagal menghapus! Produk ini masih terikat dengan data riwayat transaksi.');
        }
    }
}