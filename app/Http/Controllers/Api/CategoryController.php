<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryRepositoryInterface $categoryRepository;



    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }


    public function getPaginatedCategories(Request $request)
    {
        try {
            $limit = $request->limit;
            $page = $request->page;
            $param = $request->param;
            $order = $request->order;
            $response = $this->categoryRepository->getPaginatedCategories($limit, $page, $param, $order);
            return response()->json($response);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public function getAllCategories()
    {
        try {
            $this->categoryRepository->getAllCategories();
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }


    public function getCategoryById($id)
    {
        try {
            $response = $this->categoryRepository->getCategoryById($id);
            return $response;
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public function updateCategory($id, Request $request)
    {

        try {
            $input = $request->all();
            $response = $this->categoryRepository->updateCategory($id, $input);
            return response()->json($response);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public function createCategory(Request $request)
    {
        try {
            $input = $request->all();
            $response = $this->categoryRepository->createCategory($input);
            return response()->json($response);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public function deleteCategory($id)
    {
        try {
            $response = $this->categoryRepository->deleteCategory($id);
            return response()->json($response);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public function searchCategory(Request $request)
    {
        try {
            $key = $request->key;
            $value = $request->value;
            $limit = $request->limit;
            $page = $request->page;
            $param = $request->param;
            $order = $request->order;
            $response = $this->categoryRepository->searchCategory($key, $value, $limit, $page, $param, $order);
            return response()->json($response);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }
}
