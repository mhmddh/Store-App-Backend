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
        $client_id = $request->get('client_id');
        $product_id = $request->get('product_id');
        $quantity = $request->get('quantity');

        $model = self
    }
}
