<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'bandeng';       
    protected $primaryKey = 'id_bandeng'; 
    public $incrementing = false;       
    protected $keyType = 'string'; 
    public $timestamps = false;    
    protected $guarded = [];
}