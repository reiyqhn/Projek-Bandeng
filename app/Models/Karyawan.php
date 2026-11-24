<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Karyawan extends Authenticatable
{
    use Notifiable;

    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_karyawan',
        'nama',
        'email',
        'no_telp',
        'username',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
    ];
}