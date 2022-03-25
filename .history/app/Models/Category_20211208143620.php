<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
    ];

    public function create($request){
        $product = new Category();
        $product->name =$request->get('name');
        $product->price =$request->get('price');
        $product->image ='url';
        $product->category_id =$request->get('category');
        $product->brand_id =$request->get('brand');
        $product->save();
    }
}
