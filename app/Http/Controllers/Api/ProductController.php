<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Client;
use App\Models\ClientProduct;
use App\Models\Product;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public static function getPaginatedProducts($limit, $page, $param, $order)
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
            $nbOfItems = count(Product::all());
            $array = Product::getResponseArray($products);
            return response()->json(
                [
                    'pages' => $total_pages,
                    'products' => $array,
                    'nbOfItems' => $nbOfItems,
                ]
            );
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }



    public static function getProduct($id)
    {
        try {
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
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
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
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public static function deleteProduct($id)
    {
        try {
            $product = Product::find($id);
            if ($product) {
                $product->delete();
                return response()->json(['status' => 'succesfully deleted']);
            }
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public static function searchProduct($key, $value, $limit, $page, $param, $order)
    {
        if ($param == 'Date') {
            $param = 'created_at';
        }
        $products = Product::where($key, 'LIKE', '%' . $value . '%')
            ->limit($limit)
            ->orderBy($param, $order)
            ->offset($limit * ($page - 1))
            ->get();
        $all_products = Product::where($key, 'LIKE', '%' . $value . '%')->get();
        $nbOfItems = count($all_products);

        $total_pages = ceil(count($all_products) / $limit);
        // return response()->json(count($products));
        if (count($products)) {
            $array = Product::getResponseArray($products);
            return response()->json(
                [
                    'pages' => $total_pages,
                    'products' => $array,
                    'nbOfItems' => $nbOfItems,
                ]
            );
        } else {

            return response()->json(['Result' => 'No Data found'], 404);
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
        try {
            $client = Client::where('id', $client_id)->first();
            $products = $client->products;
            return response()->json($products);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }
}
