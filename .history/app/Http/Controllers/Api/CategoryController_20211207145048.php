<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public static function getAllCategories()
    {
        $categories = Product::all();
        return response()->json($products);
    }
}
