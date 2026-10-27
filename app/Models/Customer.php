<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

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
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}