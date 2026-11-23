<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    // Menampilkan daftar pegawai dari tabel 'karyawan'
    public function index()
    {
        $pegawais = DB::table('karyawan')->orderBy('id_karyawan', 'asc')->get();
        return view('admin.pegawai.index', compact('pegawais'));
    }

    // Menampilkan form tambah pegawai dengan ID otomatis (KR001, KR002, dst.)
    public function create()
    {
        $last = DB::table('karyawan')->orderBy('id_karyawan', 'desc')->first();
        $nextNum = $last ? ((int) substr($last->id_karyawan, 2)) + 1 : 1;
        $nextId = 'KR' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

        return view('admin.pegawai.create', compact('nextId'));
    }

    // Menyimpan data pegawai baru ke tabel 'karyawan'
    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|string|max:20|unique:karyawan,id_karyawan',
            'nama'        => 'required|string|max:150',
            'email'       => 'required|email|max:150',
            'no_telp'     => 'required|string|max:25',
            'username'    => 'required|string|max:100|unique:karyawan,username',
            'password'    => 'required|string|min:4|max:255',
        ]);

        // Catatan: jika login/sistem lama Anda mengecek password plain text atau hash,
        // sesuaikan bagian password di bawah ini. Umumnya Hash::make() direkomendasikan.
        DB::table('karyawan')->insert([
            'id_karyawan' => $request->input('id_karyawan'),
            'nama'        => $request->input('nama'),
            'email'       => $request->input('email'),
            'no_telp'     => $request->input('no_telp'),
            'username'    => $request->input('username'),
            'password'    => Hash::make($request->input('password')),
        ]);

        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan ke database!');
    }

    // Menampilkan form edit pegawai berdasarkan id_karyawan
    public function edit($id)
    {
        $pegawai = DB::table('karyawan')->where('id_karyawan', $id)->first();

        if (!$pegawai) {
            return redirect()->route('admin.pegawai.index')->with('error', 'Data pegawai tidak ditemukan.');
        }

        return view('admin.pegawai.edit', compact('pegawai'));
    }

    // Memperbarui data pegawai di tabel 'karyawan'
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'     => 'required|string|max:150',
            'email'    => 'required|email|max:150',
            'no_telp'  => 'required|string|max:25',
            'username' => 'required|string|max:100|unique:karyawan,username,' . $id . ',id_karyawan',
            'password' => 'nullable|string|min:4|max:255',
        ]);

        $pegawai = DB::table('karyawan')->where('id_karyawan', $id)->first();

        if (!$pegawai) {
            return redirect()->route('admin.pegawai.index')->with('error', 'Data pegawai tidak ditemukan.');
        }

        $dataUpdate = [
            'nama'     => $request->input('nama'),
            'email'    => $request->input('email'),
            'no_telp'  => $request->input('no_telp'),
            'username' => $request->input('username'),
        ];

        // Password hanya diupdate jika kolom password diisi
        if ($request->filled('password')) {
            $dataUpdate['password'] = Hash::make($request->input('password'));
        }

        DB::table('karyawan')->where('id_karyawan', $id)->update($dataUpdate);

        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil diperbarui!');
    }

    // Menghapus data pegawai berdasarkan id_karyawan
    public function destroy($id)
    {
        DB::table('karyawan')->where('id_karyawan', $id)->delete();

        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil dihapus.');
    }
}