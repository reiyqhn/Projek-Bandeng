<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function processRegister(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'username' => 'required|string|max:100|unique:customer,username',
            'email'    => 'required|email|max:100|unique:customer,email',
            'password' => 'required|min:6',
        ]);

        $idUnik = 'CUST-' . strtoupper(Str::random(5));

        Customer::create([
            'id_customer' => $idUnik,
            'nama'        => $request->nama,
            'username'    => $request->username,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'no_telp'     => null,
            'alamat'      => null,
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function processLogin(Request $request){
        $request->validate([
            'username' => 'required|string',
            'password' => 'required',
            'role'     => 'required|in:customer,admin,kasir,karyawan',
        ]);

        $username = $request->username;
        $password = $request->password;
        $role     = $request->role;

        $user = null;

        if ($role == 'admin') {
            $user = \App\Models\Admin::where('username', $username)->first();
        } elseif ($role == 'kasir') {
            $user = \App\Models\Kasir::where('username', $username)->first();
        } elseif ($role == 'karyawan') {
            $user = \App\Models\Karyawan::where('username', $username)->first();
        } elseif ($role == 'customer') {
            $user = \App\Models\Customer::where('username', $username)->first();
        }

        if ($user && Hash::check($password, $user->password)) {
            
            Auth::login($user);
            $request->session()->regenerate();

            if ($role == 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang Admin!');
            } elseif ($role == 'kasir') {
                // Simpan nama kasir ke session agar mudah dipanggil di layout
                session(['nama_kasir' => $user->nama]);
                
                return redirect()->route('kasir.dashboard')->with('success', 'Selamat datang Kasir!');
            } elseif ($role == 'karyawan') {
                return redirect()->route('karyawan.dashboard')->with('success', 'Selamat datang Karyawan!');
            } else {
                return redirect()->route('pesanan.index')->with('success', 'Selamat datang kembali!');
            }
        }

        return back()->withErrors([
            'username' => 'Username, password, atau pilihan role tidak sesuai!',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah keluar.');
    }
}