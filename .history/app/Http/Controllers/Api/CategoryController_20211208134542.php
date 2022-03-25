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

    public static function getProduct($id)
    {
        $product = Product::find($id);
        $category = $product->category;
        $brand = $product->brand;
        return response()->json(
            [
                'name' => $product->name,
                'image' => $product->image,
                'category' => $category['name'],
                'category_id' => $category['id'],
                'price' => $product->price,
                'brand' => $brand['name'],
                'brand_id' => $brand['id'],
                'brand_image' => $brand['image'],

            ]
        );
    }

    public static function updateProduct($id,Request $request){
        $product = Product::find($id);
        $input = $request->all();
        try {
            $product->update($input);
            return response()->json('updated successfully !!');

        } catch (\Throwable $th) {
            return response()->json('cannot update');
        }

       

    }

    public static function createCategorry(Request $request)
    {
        try {
            Product::create($request);
            return response('product created succesfully');
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
