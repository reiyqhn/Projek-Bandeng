<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminProfileController extends Controller
{
    private function currentAdmin(): ?Admin
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin && session('role') === 'admin' && session('user_id')) {
            $admin = Admin::where('id_admin', session('user_id'))->first();
        }

        return $admin;
    }

    public function edit()
    {
        $admin = $this->currentAdmin();

        if (!$admin) {
            return redirect()->route('login')->withErrors([
                'username' => 'Silakan login sebagai Admin terlebih dahulu.',
            ]);
        }

        return view('admin.profil', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = $this->currentAdmin();

        if (!$admin) {
            return redirect()->route('login')->withErrors([
                'username' => 'Silakan login sebagai Admin terlebih dahulu.',
            ]);
        }

        $validated = $request->validate([
            'nama'     => ['required', 'string', 'max:100'],
            'username' => [
                'required',
                'string',
                'max:100',
                Rule::unique('admin', 'username')->ignore($admin->id_admin, 'id_admin'),
            ],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'nama.required'          => 'Nama admin wajib diisi.',
            'username.required'      => 'Username wajib diisi.',
            'username.unique'        => 'Username sudah digunakan oleh admin lain.',
            'password.min'           => 'Password baru minimal 6 karakter.',
            'password.confirmed'     => 'Konfirmasi password baru tidak cocok.',
        ]);

        $admin->nama = $validated['nama'];
        $admin->username = $validated['username'];

        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }

        $admin->save();

        session([
            'role'       => 'admin',
            'user_id'    => $admin->id_admin,
            'nama_admin' => $admin->nama,
        ]);

        return redirect()->route('admin.profil')
            ->with('success', 'Profil admin berhasil diperbarui!');
    }
}