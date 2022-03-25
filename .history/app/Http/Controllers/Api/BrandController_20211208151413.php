<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public static function getAllBrands()
    {
        $brands = Brand::all();
        return response()->json($brands);
    }

    public static function getBrand($id)
    {
        $brand = Brand::find($id);
       
        return response()->json(
            [
                'id' => $category->id,
                'name' => $category->name,
            ]
        );
    }

    public static function updateCategory($id,Request $request){
        $category = Category::find($id);
        $input = $request->all();
        try {
            $category->update($input);
            return response()->json('updated successfully !!');

        } catch (\Throwable $th) {
            return response()->json('cannot update');
        }

       

    }

    public static function createCategory(Request $request)
    {
        try {
            Category::create($request);
            return response('category created succesfully');
        } catch (\Throwable $th) {
            return response('failed to update');
        }
    }

    public static function deleteCategory($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return response()->json(['status' => 'succesfully deleted']);
        }
        return response()->json(['status' => 'failed']);
    }
}
