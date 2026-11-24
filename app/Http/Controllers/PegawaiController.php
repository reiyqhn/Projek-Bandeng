<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $filterJabatan = $request->input('jabatan');
        $filterStatus = $request->input('status');

        $dataKasir = DB::table('kasir')->get()->map(function ($item) {
            return (object) [
                'id_pegawai' => $item->id_kasir,
                'nama'       => $item->nama,
                'email'      => $item->email ?? '-',
                'no_telp'    => $item->no_telp ?? '-',
                'alamat'     => $item->alamat ?? '-',
                'username'   => $item->username,
                'jabatan'    => 'Kasir',
                'status'     => $item->status ?? 'Aktif',
            ];
        });

        $dataKaryawan = DB::table('karyawan')->get()->map(function ($item) {
            return (object) [
                'id_pegawai' => $item->id_karyawan,
                'nama'       => $item->nama,
                'email'      => $item->email ?? '-',
                'no_telp'    => $item->no_telp ?? '-',
                'alamat'     => '-',
                'username'   => $item->username,
                'jabatan'    => 'Kurir / Karyawan',
                'status'     => $item->status ?? 'Aktif',
            ];
        });

        $pegawais = $dataKasir->concat($dataKaryawan)->values();

        if ($filterJabatan === 'Kasir') {
            $pegawais = $pegawais->where('jabatan', 'Kasir')->values();
        } elseif ($filterJabatan === 'Karyawan') {
            $pegawais = $pegawais->where('jabatan', 'Kurir / Karyawan')->values();
        }

        if (in_array($filterStatus, ['Aktif', 'Cuti', 'Tidak Aktif'])) {
            $pegawais = $pegawais->where('status', $filterStatus)->values();
        }

        return view('admin.pegawai.index', compact('pegawais', 'filterJabatan', 'filterStatus'));
    }

    public function create()
    {
        $lastKasir = DB::table('kasir')->where('id_kasir', 'like', 'KS%')->orderBy('id_kasir', 'desc')->first();
        $nextNumKasir = $lastKasir ? ((int) substr($lastKasir->id_kasir, 2)) + 1 : 1;
        $nextIdKasir = 'KS' . str_pad($nextNumKasir, 3, '0', STR_PAD_LEFT);

        $lastKaryawan = DB::table('karyawan')->where('id_karyawan', 'like', 'KR%')->orderBy('id_karyawan', 'desc')->first();
        $nextNumKaryawan = $lastKaryawan ? ((int) substr($lastKaryawan->id_karyawan, 2)) + 1 : 1;
        $nextIdKaryawan = 'KR' . str_pad($nextNumKaryawan, 3, '0', STR_PAD_LEFT);

        return view('admin.pegawai.create', compact('nextIdKasir', 'nextIdKaryawan'));
    }

    public function store(Request $request)
    {
        $jabatan = $request->input('jabatan');

        $request->validate([
            'jabatan'    => 'required|in:kasir,karyawan',
            'id_pegawai' => [
                'required',
                'string',
                'max:100',
                $jabatan === 'kasir' ? 'unique:kasir,id_kasir' : 'unique:karyawan,id_karyawan',
            ],
            'nama'       => 'required|string|max:100',
            'email'      => 'nullable|email|max:100',
            'no_telp'    => 'nullable|string|max:20',
            'alamat'     => 'nullable|string|max:100',
            'username'   => [
                'required',
                'string',
                'max:100',
                $jabatan === 'kasir' ? 'unique:kasir,username' : 'unique:karyawan,username',
            ],
            'password'   => 'required|string|min:4|max:100',
            'status'     => 'required|in:Aktif,Cuti,Tidak Aktif',
        ]);

        if ($jabatan === 'kasir') {
            DB::table('kasir')->insert([
                'id_kasir' => $request->input('id_pegawai'),
                'nama'     => $request->input('nama'),
                'alamat'   => $request->input('alamat'),
                'email'    => $request->input('email'),
                'no_telp'  => $request->input('no_telp'),
                'username' => $request->input('username'),
                'password' => Hash::make($request->input('password')),
                'status'   => $request->input('status'),
            ]);
        } else {
            DB::table('karyawan')->insert([
                'id_karyawan' => $request->input('id_pegawai'),
                'nama'        => $request->input('nama'),
                'email'       => $request->input('email'),
                'no_telp'     => $request->input('no_telp'),
                'username'    => $request->input('username'),
                'password'    => Hash::make($request->input('password')),
                'status'      => $request->input('status'),
            ]);
        }

        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan ke database!');
    }

    public function edit($id)
    {
        $kasir = DB::table('kasir')->where('id_kasir', $id)->first();
        if ($kasir) {
            $pegawai = (object) [
                'id_pegawai' => $kasir->id_kasir,
                'nama'       => $kasir->nama,
                'email'      => $kasir->email,
                'no_telp'    => $kasir->no_telp,
                'alamat'     => $kasir->alamat,
                'username'   => $kasir->username,
                'jabatan'    => 'kasir',
                'status'     => $kasir->status ?? 'Aktif',
            ];
            return view('admin.pegawai.edit', compact('pegawai'));
        }

        $karyawan = DB::table('karyawan')->where('id_karyawan', $id)->first();
        if ($karyawan) {
            $pegawai = (object) [
                'id_pegawai' => $karyawan->id_karyawan,
                'nama'       => $karyawan->nama,
                'email'      => $karyawan->email,
                'no_telp'    => $karyawan->no_telp,
                'alamat'     => null,
                'username'   => $karyawan->username,
                'jabatan'    => 'karyawan',
                'status'     => $karyawan->status ?? 'Aktif',
            ];
            return view('admin.pegawai.edit', compact('pegawai'));
        }

        return redirect()->route('admin.pegawai.index')->with('error', 'Data pegawai tidak ditemukan.');
    }

    public function update(Request $request, $id)
    {
        $kasir = DB::table('kasir')->where('id_kasir', $id)->first();
        $karyawan = !$kasir ? DB::table('karyawan')->where('id_karyawan', $id)->first() : null;

        if (!$kasir && !$karyawan) {
            return redirect()->route('admin.pegawai.index')->with('error', 'Data pegawai tidak ditemukan.');
        }

        $isKasir = (bool) $kasir;

        $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'nullable|email|max:100',
            'no_telp'  => 'nullable|string|max:20',
            'alamat'   => 'nullable|string|max:100',
            'username' => [
                'required',
                'string',
                'max:100',
                $isKasir
                    ? 'unique:kasir,username,' . $id . ',id_kasir'
                    : 'unique:karyawan,username,' . $id . ',id_karyawan',
            ],
            'password' => 'nullable|string|min:4|max:100',
            'status'   => 'required|in:Aktif,Cuti,Tidak Aktif',
        ]);

        $dataUpdate = [
            'nama'     => $request->input('nama'),
            'email'    => $request->input('email'),
            'no_telp'  => $request->input('no_telp'),
            'username' => $request->input('username'),
            'status'   => $request->input('status'),
        ];

        if ($isKasir) {
            $dataUpdate['alamat'] = $request->input('alamat');
        }

        if ($request->filled('password')) {
            $dataUpdate['password'] = Hash::make($request->input('password'));
        }

        if ($isKasir) {
            DB::table('kasir')->where('id_kasir', $id)->update($dataUpdate);
        } else {
            DB::table('karyawan')->where('id_karyawan', $id)->update($dataUpdate);
        }

        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil diperbarui!');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Aktif,Cuti,Tidak Aktif',
        ]);

        $kasir = DB::table('kasir')->where('id_kasir', $id)->first();
        if ($kasir) {
            DB::table('kasir')->where('id_kasir', $id)->update([
                'status' => $request->input('status'),
            ]);
            return back()->with('success', 'Status ' . $kasir->nama . ' diubah menjadi ' . $request->input('status') . '.');
        }

        $karyawan = DB::table('karyawan')->where('id_karyawan', $id)->first();
        if ($karyawan) {
            DB::table('karyawan')->where('id_karyawan', $id)->update([
                'status' => $request->input('status'),
            ]);
            return back()->with('success', 'Status ' . $karyawan->nama . ' diubah menjadi ' . $request->input('status') . '.');
        }

        return back()->with('error', 'Data pegawai tidak ditemukan.');
    }

    public function destroy($id)
    {
        $deletedKasir = DB::table('kasir')->where('id_kasir', $id)->delete();
        if (!$deletedKasir) {
            DB::table('karyawan')->where('id_karyawan', $id)->delete();
        }

        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil dihapus.');
    }
}