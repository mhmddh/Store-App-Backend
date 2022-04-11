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
    public static function getAllProducts($limit, $page, $param, $order)
    {

        try {
            if ($param == 'Date') {
                $param = 'created_at';
            }
            $all_products =  Product::all()->count();
            $total_pages = ceil($all_products / $limit);
            $products = Product::limit($limit)
                ->orderBy($param, $order)
                ->offset($limit * ($page - 1))
                ->get();

            $array = [];
            $i = 0;
            foreach ($products as  $product) {
                $brand_image = Brand::find($product['brand'])->first()->image;
                if ($brand_image != '' | $brand_image != null) {
                    $brand_image = "http://127.0.0.1:8000" . $brand_image;
                }
                $array[$i]['id'] = $product->id;
                $array[$i]['name'] = $product->name;
                $array[$i]['price'] = $product->price;
                $array[$i]['brand'] = Brand::find($product['brand'])->first()->name;
                $array[$i]['brand_image'] = $brand_image;
                $array[$i]['category'] = Category::find($product['category'])->first()->name;
                $array[$i]['created_at'] = $product->created_at->format('m/d/Y');
                $i++;
            }
            return response()->json(
                [
                    'pages' => $total_pages,
                    'products' => $array,
                ]
            );
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
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
        try {
            $product = Product::find($id);
            $input = $request->all();
            $product->update($input);
            return response()->json('updated successfully !!');
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
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
