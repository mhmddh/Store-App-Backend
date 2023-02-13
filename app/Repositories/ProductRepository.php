<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Client;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function getPaginatedProducts($limit, $page, $param, $order)
    {
        $response =  [];
        if ($param == 'Date') {
            $param = 'created_at';
        }
        $all_products =  Product::all()->count();
        $total_pages = ceil($all_products / $limit);
        $products = Product::limit($limit)
            ->orderBy($param, $order)
            ->offset($limit * ($page - 1))
            ->get();
        $nb_of_items = count(Product::all());
        $array = Product::getResponse($products);
        if ($array) {
            $response = [
                'pages' => $total_pages,
                'products' => $array,
                'nbOfItems' => $nb_of_items,
            ];
        } else {
            $response = [
                'message' => 'No Data found',
                'nbOfItems' => $nb_of_items,
            ];
        }
        return $response;
    }
    public function getProductById($productId)
    {
        $response = [];
        $product = Product::find($productId);

        if (!$product) {
            $response = [
                'success' => false,
                'message' => 'Product not found !!'
            ];
        } else {
            $category = $product->category;
            $images = [];
            foreach ($product->files as $file) {
                $images[$file->id] = asset('storage/products/product' . $product->id . '/' . $file->name);
            }
            $response = [
                'product' => [
                    'name' => $product->name,
                    'category' => $category['name'],
                    'category_id' => $category['id'],
                    'price' => $product->price,
                    'brand' => $product->brand['name'],
                    'images' => $images,
                    'brand_id' => $product->brand['id'],
                    'brand_image' => asset('storage/brands') . '/' . $product->brand['image'],
                ],
                'success' => true,
                'message' => 'Product found successfully !!'
            ];
        }
        return $response;
    }

    public function updateProduct($productId, $newDetails)
    {
        $product = Product::find($productId);
        $product->updateProduct($newDetails);
        return 'Updated successfully !!';
    }

    public function createProduct($details)
    {
        $product = Product::createProduct($details);
        return [
            "message" => "Product successfully created",
            "product_id" => $product->id,

        ];
    }

    public function deleteProduct($productId)
    {
        $product = Product::find($productId);
        if ($product) {
            $product->delete();
            return ['success' => true, 'status' => 'Succesfully deleted'];
        } else {
            return ['success' => false, 'status' => 'Product Not found'];
        }
    }

    public function searchProduct($key, $value, $limit, $page, $param, $order)
    {
        $response = [];
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
        if (count($products)) {
            $array = Product::getResponse($products);
            $response = [
                'pages' => $total_pages,
                'products' => $array,
                'nbOfItems' => $nbOfItems,
            ];
        } else {
            $response = [
                'message' => 'No Data found !!', 'nbOfItems' => $nbOfItems,
            ];
        }
        return $response;
    }

    public function getClientProducts($clientID)
    {
        $response = [];
        $client = Client::where('id', $clientID)->first();
        if ($client) {
            $products = $client->products;
            if ($products) {
                return $products;
            }
            $response = [
                'message' => 'No Data found !!',
            ];
        } else {
            $response = [
                'message' => 'No Data found !!',
            ];
        }
        return $response;
    }
}
