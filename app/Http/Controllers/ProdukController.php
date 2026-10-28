<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProdukController extends Controller
{
    // MENAMPILKAN DATA BANDENG
    public function index()
    {
        $produks = Produk::paginate(5);

        return view('admin.bandeng.index', compact('produks'));
    }

    // HALAMAN TAMBAH BANDENG
    public function create()
    {
        return view('admin.bandeng.create');
    }

    // MENYIMPAN BANDENG BARU
    public function store(Request $request)
    {
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

    // MEMBUKA HALAMAN EDIT BANDENG
    public function edit($id)
    {
        $produk = Produk::where('id_bandeng', $id)->firstOrFail();
        return view('admin.bandeng.edit', compact('produk'));
    }

    // MENYIMPAN PERUBAHAN BANDENG
    public function update(Request $request, $id)
    {
        $produk = Produk::where('id_bandeng', $id)->firstOrFail();

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

            // Hapus foto lama jika ada
            if ($produk->foto) {
                $fotoLama = $folder . DIRECTORY_SEPARATOR . basename($produk->foto);

                if (File::exists($fotoLama)) {
                    File::delete($fotoLama);
                }
            }

            // Simpan foto baru
            $foto = $request->file('foto');
            $namaFoto = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();

            $foto->move($folder, $namaFoto);

            $data['foto'] = $namaFoto;
        }

        $produk->update($data);

        return redirect()
            ->route('admin.bandeng.index')
            ->with('success', 'Data bandeng berhasil diperbarui.');
    }

    // MENGHAPUS BANDENG
    public function destroy($id)
    {
        $produk = Produk::where('id_bandeng', $id)->firstOrFail();

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
    }
}