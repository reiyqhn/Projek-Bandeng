<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    private array $daftarSatuan = ['kg', 'pack', 'pcs', 'ekor'];

    public function index()
    {
        $produks = DB::table('bandeng')->orderBy('id_bandeng', 'asc')->get();
        return view('admin.bandeng.index', compact('produks'));
    }

    public function create()
    {
        $last = DB::table('bandeng')->orderBy('id_bandeng', 'desc')->first();
        $nextNum = $last ? ((int) substr($last->id_bandeng, 2)) + 1 : 1;
        $randomId = 'BD' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);
        $daftarSatuan = $this->daftarSatuan;

        return view('admin.bandeng.create', compact('randomId', 'daftarSatuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_bandeng'   => 'required|string|max:20|unique:bandeng,id_bandeng',
            'nama_bandeng' => 'required|string|max:150',
            'stok'         => 'required|integer|min:0',
            'harga'        => 'required|numeric|min:0',
            'satuan'       => 'required|string|in:kg,pack,pcs,ekor',
            'deskripsi'    => 'nullable|string',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $fotoName = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fotoName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/bandeng'), $fotoName);
        }

        DB::table('bandeng')->insert([
            'id_bandeng'   => trim($request->input('id_bandeng')),
            'nama_bandeng' => trim($request->input('nama_bandeng')),
            'stok'         => (int) $request->input('stok'),
            'harga'        => (float) $request->input('harga'),
            'satuan'       => trim($request->input('satuan')),
            'deskripsi'    => $request->input('deskripsi'),
            'foto'         => $fotoName,
        ]);

        return redirect()->route('admin.bandeng.index')->with('success', 'Data bandeng berhasil ditambahkan ke database!');
    }

    public function editDirect()
    {
        $produk = DB::table('bandeng')->orderBy('id_bandeng', 'asc')->first();

        if (!$produk) {
            return redirect()->route('admin.bandeng.create')->with('error', 'Belum ada data bandeng untuk diedit. Silakan input data dulu.');
        }

        $daftarSatuan = $this->daftarSatuan;
        return view('admin.bandeng.edit', compact('produk', 'daftarSatuan'));
    }

    public function edit($id)
    {
        $produk = DB::table('bandeng')->where('id_bandeng', $id)->first();

        if (!$produk) {
            return redirect()->route('admin.bandeng.index')->with('error', 'Data bandeng tidak ditemukan.');
        }

        $daftarSatuan = $this->daftarSatuan;
        return view('admin.bandeng.edit', compact('produk', 'daftarSatuan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_bandeng' => 'required|string|max:150',
            'stok'         => 'required|integer|min:0',
            'harga'        => 'required|numeric|min:0',
            'satuan'       => 'required|string|in:kg,pack,pcs,ekor',
            'deskripsi'    => 'nullable|string',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $produk = DB::table('bandeng')->where('id_bandeng', $id)->first();

        if (!$produk) {
            return redirect()->route('admin.bandeng.index')->with('error', 'Data bandeng tidak ditemukan.');
        }

        $fotoName = $produk->foto;
        if ($request->hasFile('foto')) {
            if ($fotoName && file_exists(public_path('uploads/bandeng/' . $fotoName))) {
                @unlink(public_path('uploads/bandeng/' . $fotoName));
            }
            $file = $request->file('foto');
            $fotoName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/bandeng'), $fotoName);
        }

        DB::table('bandeng')->where('id_bandeng', $id)->update([
            'nama_bandeng' => trim($request->input('nama_bandeng')),
            'stok'         => (int) $request->input('stok'),
            'harga'        => (float) $request->input('harga'),
            'satuan'       => trim($request->input('satuan')),
            'deskripsi'    => $request->input('deskripsi'),
            'foto'         => $fotoName,
        ]);

        return redirect()->route('admin.bandeng.index')->with('success', 'Data bandeng berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $produk = DB::table('bandeng')->where('id_bandeng', $id)->first();

        if ($produk && $produk->foto && file_exists(public_path('uploads/bandeng/' . $produk->foto))) {
            @unlink(public_path('uploads/bandeng/' . $produk->foto));
        }

        DB::table('bandeng')->where('id_bandeng', $id)->delete();

        return redirect()->route('admin.bandeng.index')->with('success', 'Data bandeng berhasil dihapus.');
    }
}