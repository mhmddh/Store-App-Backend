<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Client;
use App\Models\ClientProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public static function getAllProducts()
    {
        $products = Product::all();
        return response()->json($products);
        $array = [];
        $i = 0;
        foreach ($products as  $product) {
            $array[$i]['id'] = $product->id;
            $array[$i]['name'] = $product->name;
            $array[$i]['price'] = $product->price;
            $array[$i]['product_image'] = $product->image;
            $array[$i]['brand'] = Brand::find($product['brand'])->first()->name;
            $array[$i]['brand_image'] = Brand::find($product['brand'])->first()->image;
            $array[$i]['category'] = Category::find($product['category'])->first()->name;
            $i++;
        }
        return response()->json($array);
    }

    public static function purchaseProduct(Request $request)
    {
        try {
            ClientProduct::purchase($request);
            return response()->json(['status' => 'success']);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public static function getProductsHistory($client_id)
    {
        $client = Client::where('id', $client_id)->first();
        $products = $client->products;
        return response()->json($products);
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

    public static function updateProduct($id, Request $request)
    {
        $product = Product::find($id);
        $input = $request->all();
        try {
            $product->update($input);
            return response()->json('updated successfully !!');
        } catch (\Throwable $th) {
            return response()->json('cannot update');
        }
    }

    public static function createProduct(Request $request)
    {
        try {
            Product::create($request);
            return response('product created succesfully');
        } catch (\Throwable $th) {
            return response('failed to update');
        }
    }

    public static function deleteProduct($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return response()->json(['status' => 'succesfully deleted']);
        }
        return response()->json(['status' => 'failed']);
    }
}
