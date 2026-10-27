<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer'; 
    protected $primaryKey = 'id_customer';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_customer',
        'nama',
        'email',
        'no_telp',
        'alamat',
        'username',
        'password'
    ];
}