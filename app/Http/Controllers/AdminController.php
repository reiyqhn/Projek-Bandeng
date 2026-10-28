<?php
namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pesanan;

class AdminController extends Controller
{
    public function index()
    {
        $totalProduk = Produk::count();
        $totalPesanan = Pesanan::count();

        return view('admin.dashboard', compact(
            'totalProduk',
            'totalPesanan'
        ));
    }
}