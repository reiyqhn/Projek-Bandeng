<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    // Menampilkan daftar customer dari tabel 'customer'
    public function index()
    {
        $customers = DB::table('customer')->orderBy('id_customer', 'asc')->get();
        return view('admin.customer.index', compact('customers'));
    }

    // Menampilkan form tambah customer dengan ID otomatis (CUS001, CUS002, dst.)
    public function create()
    {
        $lastCus = DB::table('customer')
            ->where('id_customer', 'like', 'CUS%')
            ->orderBy('id_customer', 'desc')
            ->first();

        if ($lastCus) {
            $num = (int) substr($lastCus->id_customer, 3);
            $nextId = 'CUS' . str_pad($num + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $totalRows = DB::table('customer')->count() + 1;
            $nextId = 'CUS' . str_pad($totalRows, 3, '0', STR_PAD_LEFT);
        }

        return view('admin.customer.create', compact('nextId'));
    }

    // Menyimpan data customer baru ke tabel 'customer'
    public function store(Request $request)
    {
        $request->validate([
            'id_customer' => 'required|string|max:30|unique:customer,id_customer',
            'nama'        => 'required|string|max:150',
            'email'       => 'required|email|max:150',
            'no_telp'     => 'nullable|string|max:25',
            'alamat'      => 'nullable|string',
            'username'    => 'required|string|max:100|unique:customer,username',
            'password'    => 'required|string|min:4|max:255',
        ]);

        DB::table('customer')->insert([
            'id_customer' => $request->input('id_customer'),
            'nama'        => $request->input('nama'),
            'email'       => $request->input('email'),
            'no_telp'     => $request->input('no_telp'),
            'alamat'      => $request->input('alamat'),
            'username'    => $request->input('username'),
            'password'    => Hash::make($request->input('password')),
        ]);

        return redirect()->route('admin.customer.index')->with('success', 'Data customer berhasil ditambahkan ke database!');
    }

    // Menampilkan form edit customer berdasarkan id_customer
    public function edit($id)
    {
        $customer = DB::table('customer')->where('id_customer', $id)->first();

        if (!$customer) {
            return redirect()->route('admin.customer.index')->with('error', 'Data customer tidak ditemukan.');
        }

        return view('admin.customer.edit', compact('customer'));
    }

    // Memperbarui data customer di tabel 'customer'
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'     => 'required|string|max:150',
            'email'    => 'required|email|max:150',
            'no_telp'  => 'nullable|string|max:25',
            'alamat'   => 'nullable|string',
            'username' => 'required|string|max:100|unique:customer,username,' . $id . ',id_customer',
            'password' => 'nullable|string|min:4|max:255',
        ]);

        $customer = DB::table('customer')->where('id_customer', $id)->first();

        if (!$customer) {
            return redirect()->route('admin.customer.index')->with('error', 'Data customer tidak ditemukan.');
        }

        $dataUpdate = [
            'nama'     => $request->input('nama'),
            'email'    => $request->input('email'),
            'no_telp'  => $request->input('no_telp'),
            'alamat'   => $request->input('alamat'),
            'username' => $request->input('username'),
        ];

        if ($request->filled('password')) {
            $dataUpdate['password'] = Hash::make($request->input('password'));
        }

        DB::table('customer')->where('id_customer', $id)->update($dataUpdate);

        return redirect()->route('admin.customer.index')->with('success', 'Data customer berhasil diperbarui!');
    }

    // Menghapus data customer berdasarkan id_customer
    public function destroy($id)
    {
        DB::table('customer')->where('id_customer', $id)->delete();

        return redirect()->route('admin.customer.index')->with('success', 'Data customer berhasil dihapus.');
    }
}