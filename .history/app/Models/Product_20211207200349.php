<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'price',
        'category_id',
        'brand_id',
        'image'
    ];
    //Relations :
    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    //services:
    public function create($request){
        $product = new Product();
        $product->name =$request->get('')
    }
}
