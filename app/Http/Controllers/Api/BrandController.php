<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public static function getPaginatedBrands(Request $request)
    {
        try {
            $limit = $request->limit;
            $page = $request->page;
            $param = $request->param;
            $order = $request->order;
            if ($param == 'Date') $param = 'created_at';
            $all_brands =  Brand::all()->count();
            $total_pages = ceil($all_brands / $limit);
            $brands = Brand::limit($limit)
                ->orderBy($param, $order)
                ->offset($limit * ($page - 1))
                ->get();
            $nbOfItems = count(Brand::all());
            foreach ($brands as $brand) {
                if ($brand->image != '' | $brand->image != null) {
                    $brand->image = "http://127.0.0.1:8000" . $brand->image;
                }
            }
            if($all_brands){
                return response()->json(
                    [
                        'pages' => $total_pages,
                        'brands' => $brands,
                        'nbOfItems' => $nbOfItems
                    ]
                );
            }else{
                return response()->json([
                    'message' => 'No Data found', 'nbOfItems' => $nbOfItems,
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public static function getAllBrands()
    {
        try {
            $brands = Brand::all();
            return response()->json($brands);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public static function getBrand($id)
    {
        try {
            $brand = Brand::find($id);
            if ($brand->image != '' | $brand->image != null) {
                $brand->image = "http://127.0.0.1:8000" . $brand->image;
            }
            return response()->json(
                [
                    'id' => $brand->id,
                    'name' => $brand->name,
                    'image' => $brand->image,
                ]
            );
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public static function updateBrand($id, Request $request)
    {
        try {
            $brand = Brand::find($id);
            $input = $request->all();
            $brand->update($input);
            return response()->json('updated successfully !!');
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public static function createBrand(Request $request)
    {
        try {
            $brand = Brand::create($request);
            return response()->json([
                "message" => "Brand successfully created",
                "brand_id" => $brand->id
            ]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }
    public static function uploadFile($id, Request $request)
    {
        try {
            $brand = Brand::find($id);
            $file = $request->file('file');
            $extension = $file->extension();
            $filename = "brand" . $id . "." . $extension;
            $request->file('file')->storeAs("public", $filename);
            $brand->image = "/storage/" . $filename;
            $brand->save();
            return response()->json([
                "success" => true,
                "message" => "File successfully uploaded",
                "file" => $file
            ]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }
    public static function deleteBrand($id)
    {
        try {
            $brand = Brand::find($id);
            if ($brand) {
                $brand->delete();
                return response()->json('succesfully deleted');
            }
            return response()->json('failed');
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public static function searchBrand(Request $request)
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
            $brands = Brand::where($key, 'LIKE', '%' . $value . '%')
                ->limit($limit)
                ->orderBy($param, $order)
                ->offset($limit * ($page - 1))
                ->get();

            foreach ($brands as $brand) {
                if ($brand->image != '' | $brand->image != null) {
                    $brand->image = "http://127.0.0.1:8000" . $brand->image;
                }
            }

            $all_brands = Brand::where($key, 'LIKE', '%' . $value . '%')->get();
            $nbOfItems = count($all_brands);
            $total_pages = ceil(count($brands) / $limit);
            if (count($brands)) {
                return response()->json(
                    [
                        'pages' => $total_pages,
                        'brands' => $brands,
                        'nbOfItems' => $nbOfItems
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
}
