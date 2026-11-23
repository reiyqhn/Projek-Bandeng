<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerProfileController extends Controller
{
    public function edit()
    {
        $customer = Auth::user();
        return view('pesanan.profil', compact('customer'));
    }

    public function update(Request $request)
    {
        $customer = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('customer', 'email')->ignore($customer->id_customer, 'id_customer'),
            ],
            'no_telp' => 'nullable|string|max:25',
            'alamat' => 'nullable|string|max:255',
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('customer', 'username')->ignore($customer->id_customer, 'id_customer'),
            ],
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah dipakai akun lain.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username ini sudah dipakai akun lain.',
            'password.min' => 'Password baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $dataUpdate = [
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'username' => $request->username,
        ];

        if ($request->filled('password')) {
            $dataUpdate['password'] = Hash::make($request->password);
        }

        DB::table('customer')
            ->where('id_customer', $customer->id_customer)
            ->update($dataUpdate);

        return redirect()->route('customer.profil')->with('success', 'Profil berhasil diperbarui!');
    }
}