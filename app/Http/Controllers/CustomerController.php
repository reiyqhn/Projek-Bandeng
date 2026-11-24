<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = DB::table('customer')->orderBy('id_customer', 'asc')->get();
        return view('admin.customer.index', compact('customers'));
    }
}