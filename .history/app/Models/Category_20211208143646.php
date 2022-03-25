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
        $category = new Category();
        $category->name =$request->get('name');
        $category->price =$request->get('price');
        $category->image ='url';
        $category->category_id =$request->get('category');
        $category->brand_id =$request->get('brand');
        $category->save();
    }
}
