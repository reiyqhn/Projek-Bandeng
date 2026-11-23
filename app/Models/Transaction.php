<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transaksi_penjualan'; 
    protected $primaryKey = 'no_faktur';      
    public $incrementing = false;             
    protected $keyType = 'string';
    public $timestamps = false;               

    protected $fillable = [
        'no_faktur',
        'id_customer',
        'id_kasir',
        'tanggal_penjualan',
        'tgl_cetak_faktur',
        'metode_pembayaran',
        'status_pembayaran',
        'metode_pemesanan',
        'subtotal',
        'kembalian',
        'bukti_pembayaran'
    ];

    // Relasi ke tabel customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }
}