<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public static function getAllCategories()
    {
        $categories = Product::all();
        return response()->json($categories);
    }

    public static function getCategoryForProduct($id){
        $product = Product::find($id);
        $category = $product->category;
        return response()->json(["id"=>$id]);
    }
}
