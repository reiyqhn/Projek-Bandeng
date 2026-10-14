<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'transaksi_penjualan'; 
    protected $primaryKey = 'no_faktur';    
    public $incrementing = false;             
    protected $keyType = 'string';            
    protected $guarded = [];


}