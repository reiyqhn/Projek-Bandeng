<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dikirim extends Model
{
    protected $table = 'dikirim';
    protected $primaryKey = 'no_pengiriman';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false; // Karena tabel dikirim tidak ada kolom created_at/updated_at

    protected $fillable = [
        'no_pengiriman',
        'no_faktur',
        'id_karyawan',
        'alamat_pengiriman',
        'bukti_pengiriman',
        'status_pengiriman',
    ];

    // Hubungan ke Transaksi Penjualan
    public function transaksi()
    {
        // Catatan: Jika temanmu pakai Transaction.php, ganti Pesanan::class jadi Transaction::class
        return $this->belongsTo(Transaction::class, 'no_faktur', 'no_faktur');
    }

    // Hubungan ke Karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }
}