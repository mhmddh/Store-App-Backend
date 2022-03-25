<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public static function getAllBrands()
    {
        $brands = ProducBrt::all();
        return response()->json($brands);
    }
}
