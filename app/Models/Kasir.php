<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Kasir extends Authenticatable
{
    use Notifiable;

    protected $table = 'kasir';
    protected $primaryKey = 'id_kasir';
    public $incrementing = false; 
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_kasir',
        'nama',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}