<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class FakturOnlineController extends Controller
{
    public function faktur(){
        $fakturs = Transaction::where('status_pembayaran', 'Lunas')->get();

        return view('dashboard.kasir.faktur_online', compact('fakturs'));
    }
}