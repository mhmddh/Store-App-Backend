<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public static function getAllCategories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

   
}
