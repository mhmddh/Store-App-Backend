<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public static function getPaginatedCategories(Request $request)
    {
        try {
            $limit = $request->limit;
            $page = $request->page;
            $param = $request->param;
            $order = $request->order;
            if ($param == 'Date') $param = 'created_at';
            $all_categories =  Category::all()->count();
            $total_pages = ceil($all_categories / $limit);
            $categories = Category::limit($limit)
                ->orderBy($param, $order)
                ->offset($limit * ($page - 1))
                ->get();
            $nbOfItems = count(Category::all());
            if ($all_categories) {
                return response()->json(
                    [
                        'pages' => $total_pages,
                        'categories' => $categories,
                        'nbOfItems' => $nbOfItems,
                        'message' => $nbOfItems.' results !!'
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
            if(!$category){
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Category not found !!',
                    ]
                );
            }
            return response()->json(
                [
                    'category'=>[
                        'id' => $category->id,
                        'name' => $category->name,
                    ],
                    'success' => true,
                    'message' => 'Category found successfully !!',
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

    public static function searchCategory(Request $request)
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
            $categories = Category::where($key, 'LIKE', '%' . $value . '%')
                ->limit($limit)
                ->orderBy($param, $order)
                ->offset($limit * ($page - 1))
                ->get();
            $all_categories = Category::where($key, 'LIKE', '%' . $value . '%')->get();
            $nbOfItems = count($all_categories);
            $total_pages = ceil(count($categories) / $limit);
            if(count($categories)){
                return response()->json(
                    [
                        'pages' => $total_pages,
                        'categories' => $categories,
                        'nbOfItems' => $nbOfItems
                    ]
                );
            }else{
                return response()->json([
                    'message' => 'No Data found !!', 'nbOfItems' => $nbOfItems,
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }
}
