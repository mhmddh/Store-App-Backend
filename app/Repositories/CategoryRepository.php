<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;


class CategoryRepository implements CategoryRepositoryInterface
{
    public function getPaginatedCategories($limit, $page, $param, $order)
    {
        $response = [];
        if ($param == 'Date') $param = 'created_at';
        $all_categories =  Category::all()->count();
        $total_pages = ceil($all_categories / $limit);
        $categories = Category::limit($limit)
            ->orderBy($param, $order)
            ->offset($limit * ($page - 1))
            ->get();
        $nbOfItems = count(Category::all());
        if ($all_categories) {
            $response =
                [
                    'pages' => $total_pages,
                    'categories' => $categories,
                    'nbOfItems' => $nbOfItems,
                    'message' => $nbOfItems . ' results !!'
                ];
        } else {
            $response =
                [
                    'message' => 'No Data found', 'nbOfItems' => $nbOfItems,
                ];
        }
        return $response;
    }
    public function getAllCategories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function getCategoryById($categoryId)
    {
        $response = [];
        $category = Category::find($categoryId);
        if (!$category) {
            $response =
                [
                    'success' => false,
                    'message' => 'Category not found !!',
                ];
        } else {
            $response =
                [
                    'category' => [
                        'id' => $category->id,
                        'name' => $category->name,
                    ],
                    'success' => true,
                    'message' => 'Category found successfully !!',
                ];
        }

        return $response;
    }


    public function updateCategory($categoryId, array $newDetails)
    {
        $category = Category::find($categoryId);
        $category->update($newDetails);
        return 'Updated successfully !!';
    }
    public function createCategory(array $details)
    {
        Category::create($details);
        return 'Category created succesfully';
    }

    public function deleteCategory($categoryId)
    {
        $category = Category::find($categoryId);
        if ($category) {
            $category->delete();
            return 'Succesfully deleted';
        } else {
            return 'Category Not Found';
        }
    }

    public function searchCategory($key, $value, $limit, $page, $param, $order)
    {
        $response = [];
        if ($param == 'Date') {
            $param = 'created_at';
        }
        $categories = Category::where($key, 'LIKE', '%' . $value . '%')
            ->limit($limit)
            ->orderBy($param, $order)
            ->offset($limit * ($page - 1))
            ->get();
        $all_categories = Category::where($key, 'LIKE', '%' . $value . '%')->get();
        $nbOfItems = count($all_categories);
        $total_pages = ceil(count($categories) / $limit);
        if (count($categories)) {
            $response =
                [
                    'pages' => $total_pages,
                    'categories' => $categories,
                    'nbOfItems' => $nbOfItems
                ];
        } else {
            $response = [
                'message' => 'No Data found !!', 'nbOfItems' => $nbOfItems,
            ];
        }
        return $response;
    }
}
