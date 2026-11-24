<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KaryawanProfileController extends Controller
{
    public function edit()
    {
        $idKaryawan = Auth::guard('karyawan')->user()?->id_karyawan ?? session('user_id');

        if (!$idKaryawan) {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Kurir terlebih dahulu.');
        }

        $karyawan = DB::table('karyawan')->where('id_karyawan', $idKaryawan)->first();
        if (!$karyawan) {
            return redirect()->route('login')->with('error', 'Data kurir tidak ditemukan.');
        }

        return view('karyawan.profil', compact('karyawan'));
    }

    public function update(Request $request)
    {
        $id = Auth::guard('karyawan')->user()?->id_karyawan ?? session('user_id');

        if (!$id) {
            return redirect()->route('login')->with('error', 'Sesi tidak valid.');
        }

        $request->validate([
            'nama'     => 'required|string|max:100',
            'username' => 'required|string|max:100|unique:karyawan,username,' . $id . ',id_karyawan',
            'email'    => 'nullable|email|max:100',
            'no_telp'  => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $dataUpdate = [
            'nama'     => $request->input('nama'),
            'username' => $request->input('username'),
            'email'    => $request->input('email'),
            'no_telp'  => $request->input('no_telp'),
        ];

        if ($request->filled('password')) {
            $dataUpdate['password'] = Hash::make($request->input('password'));
        }

        DB::table('karyawan')->where('id_karyawan', $id)->update($dataUpdate);
        session(['nama_karyawan' => $request->input('nama')]);

        return redirect()->route('karyawan.profil')->with('success', 'Profil kurir berhasil diperbarui!');
    }
}