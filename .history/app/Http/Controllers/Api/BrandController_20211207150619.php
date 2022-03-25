<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public static function getAllBrands()
    {
        $brands = Product::all();
        return response()->json($brands);
    }

    public static function getBrandForProduct($id)
}
