<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public static function getPaginatedCategories($limit, $page, $param, $order)
    {
        try {
            if ($param == 'Date') $param = 'created_at';
            $all_categories =  Category::all()->count();
            $total_pages = ceil($all_categories / $limit);
            $categories = Category::limit($limit)
                ->orderBy($param, $order)
                ->offset($limit * ($page - 1))
                ->get();
            $nbOfItems = count(Product::all());
            return response()->json(
                [
                    'pages' => $total_pages,
                    'categories' => $categories,
                    'nbOfItems' => $nbOfItems

                ]
            );
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public static function getAllCategories()
    {
        try {
            $categories = Category::all();
            return response()->json($categories);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }


    public static function getCategory($id)
    {
        try {
            $category = Category::find($id);

            return response()->json(
                [
                    'id' => $category->id,
                    'name' => $category->name,
                ]
            );
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public static function updateCategory($id, Request $request)
    {

        try {
            $category = Category::find($id);
            $input = $request->all();
            $category->update($input);
            return response()->json('updated successfully !!');
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public static function createCategory(Request $request)
    {
        try {
            Category::create($request);
            return response('category created succesfully');
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public static function deleteCategory($id)
    {
        try {
            $category = Category::find($id);
            if ($category) {
                $category->delete();
                return response()->json(['status' => 'succesfully deleted']);
            }
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public static function searchCategory($key, $value, $limit, $page, $param, $order)
    {
        try {
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
            return response()->json(
                [
                    'pages' => $total_pages,
                    'categories' => $categories,
                    'nbOfItems' => $nbOfItems

                ]
            );
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }
}
