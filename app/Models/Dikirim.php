<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dikirim extends Model
{
    protected $table = 'dikirim';
    protected $primaryKey = 'no_pengiriman';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false; 

    protected $fillable = [
        'no_pengiriman',
        'no_faktur',
        'id_karyawan',
        'alamat_pengiriman',
        'wilayah',
        'bukti_pengiriman',
        'status_pengiriman',
    ];

    public static function daftarWilayah(): array
    {
        return [
            'Temanggung / Parakan / Bulu (Rp 7.000)',
            'Kedu / Kranggan / Tlogomulyo (Rp 10.000)',
            'Ngadirejo / Selopampang / Pringsurat (Rp 15.000)',
            'Candiroto / Kaloran / Jumo (Rp 18.000)',
            'Tretep / Bejen / Gemawang / Wonoboyo (Rp 25.000)',
            'Luar Kab. Temanggung via J&T (Rp 20.000)',
        ];
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaction::class, 'no_faktur', 'no_faktur');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }
}