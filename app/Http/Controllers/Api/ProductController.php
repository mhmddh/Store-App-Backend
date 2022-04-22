<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\File;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public static function getPaginatedProducts(Request $request)
    {

        try {
            $limit = $request->limit;
            $page = $request->page;
            $param = $request->param;
            $order = $request->order;
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
            $array = Product::getResponse($products);
            if ($all_products) {
                return response()->json(
                    [
                        'pages' => $total_pages,
                        'products' => $array,
                        'nbOfItems' => $nbOfItems,
                    ]
                );
            } else {
                return response()->json([
                    'message' => 'No Data found', 'nbOfItems' => $nbOfItems,
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }



    public static function getProduct($id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found !!'
                ]);
            }
            $category = $product->category;
            $brand = $product->brand;
            $brand->image = env('API_URL').$brand->image;
            $array = [];
            foreach ($product->files as $file) {
                $array[$file->id] = env('API_URL') . $file->url;
            }

            return response()->json(
                [
                    'product' => [
                        'name' => $product->name,
                        'category' => $category['name'],
                        'category_id' => $category['id'],
                        'price' => $product->price,
                        'brand' => $brand['name'],
                        'images' => $array,
                        'brand_id' => $brand['id'],
                        'brand_image' => $brand['image'],
                    ],
                    'success' => true,
                    'message' => 'Product found successfully !!'
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
            $product->updateProduct($request);
            return response()->json('updated successfully !!');
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public static function createProduct(Request $request)
    {
        try {
            $product = Product::createProduct($request);
            return response()->json([
                "message" => "Product successfully created",
                "product_id" => $product->id,

            ]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public static function uploadFile($id, Request $request)
    {

        try {
            $product = Product::find($id);
            $product->uploadFile($product, $request);
            return response()->json([
                "success" => true,
                "message" => "File successfully uploaded",
            ]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public static function deleteFile($id)
    {
        $file = File::find($id);
        $file->delete();
        if (file_exists($file->url)) {
            unlink($file->url);
        }
        return response()->json(['status' => 'image deleted']);
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

    public static function searchProduct(Request $request)
    {

        try {
            $key = $request->key;
            $value = $request->value;
            $limit = $request->limit;
            $page = $request->page;
            $param = $request->param;
            $order = $request->order;
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

                return response()->json([
                    'message' => 'No Data found !!', 'nbOfItems' => $nbOfItems,
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public static function purchaseProduct(Request $request)
    {
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
