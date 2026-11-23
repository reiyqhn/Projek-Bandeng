<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Karyawan extends Authenticatable
{
    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_karyawan',
        'nama_karyawan',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}