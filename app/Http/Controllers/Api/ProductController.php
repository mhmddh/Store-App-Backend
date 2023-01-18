<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    private ProductRepositoryInterface $productRepository;


    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }


    public function getPaginatedProducts(Request $request): JsonResponse
    {

        try {
            $limit = $request->limit;
            $page = $request->page;
            $param = $request->param;
            $order = $request->order;
            $response = $this->productRepository->getPaginatedProducts($limit, $page, $param, $order);
            return response()->json($response);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }



    public function getProductById($id): JsonResponse
    {
        try {
            $response = $this->productRepository->getProductById($id);
            return response()->json($response);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public function updateProduct($id, Request $request): JsonResponse
    {
        try {
            $input = $request->all();
            $response = $this->productRepository->updateProduct($id, $input);

            return response()->json($response);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public function createProduct(Request $request): JsonResponse
    {
        try {
            $input = $request->all();
            $response = $this->productRepository->createProduct($input);
            return response()->json($response);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }


    public function deleteProduct($id): JsonResponse
    {
        try {
            $response = $this->productRepository->deleteProduct($id);
            return response()->json($response);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public function searchProduct(Request $request): JsonResponse
    {

        try {
            $key = $request->key;
            $value = $request->value;
            $limit = $request->limit;
            $page = $request->page;
            $param = $request->param;
            $order = $request->order;
            $response = $this->productRepository->searchProduct($key, $value, $limit, $page, $param, $order);
            return response()->json($response);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public function getClientProducts($client_id): JsonResponse
    {
        try {
            $response = $this->productRepository->getClientProducts($client_id);
            return response()->json($response);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }
}
