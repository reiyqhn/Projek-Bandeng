<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KasirProfileController extends Controller
{
    public function edit()
    {
        $idKasir = Auth::guard('kasir')->user()?->id_kasir ?? session('user_id');

        if (!$idKasir) {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Kasir terlebih dahulu.');
        }

        $kasir = DB::table('kasir')->where('id_kasir', $idKasir)->first();
        if (!$kasir) {
            return redirect()->route('login')->with('error', 'Data kasir tidak ditemukan.');
        }

        return view('dashboard.kasir.profile', compact('kasir'));
    }

    public function update(Request $request)
    {
        $id = Auth::guard('kasir')->user()?->id_kasir ?? session('user_id');

        if (!$id) {
            return redirect()->route('login')->with('error', 'Sesi tidak valid.');
        }

        $request->validate([
            'nama'     => 'required|string|max:100',
            'username' => 'required|string|max:100|unique:kasir,username,' . $id . ',id_kasir',
            'email'    => 'nullable|email|max:100',
            'no_telp'  => 'nullable|string|max:20',
            'alamat'   => 'nullable|string|max:100',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $dataUpdate = [
            'nama'     => $request->input('nama'),
            'username' => $request->input('username'),
            'email'    => $request->input('email'),
            'no_telp'  => $request->input('no_telp'),
            'alamat'   => $request->input('alamat'),
        ];

        if ($request->filled('password')) {
            $dataUpdate['password'] = Hash::make($request->input('password'));
        }

        DB::table('kasir')->where('id_kasir', $id)->update($dataUpdate);
        session(['nama_kasir' => $request->input('nama')]);

        return redirect()->route('kasir.profil')->with('success', 'Profil kasir berhasil diperbarui!');
    }
}