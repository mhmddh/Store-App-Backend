<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientProduct extends Model
{
    use HasFactory;

    protected $table = 'client-product';


    protected $fillable = [
        'client_id',
        'product_id',
        'quantity',
    ];

    public static function purchase($request){

    }
}
