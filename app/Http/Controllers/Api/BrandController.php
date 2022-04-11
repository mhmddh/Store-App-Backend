<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public static function getPaginatedBrands($limit, $page, $param, $order)
    {
        try {
            if ($param == 'Date') $param = 'created_at';
            if ($limit == 0 && $page == 0) {
                $brands = Brand::all();
                return response()->json($brands);
            } else {
                $all_brands =  Brand::all()->count();
                $total_pages = ceil($all_brands / $limit);
                $brands = Brand::limit($limit)
                    ->orderBy($param, $order)
                    ->offset($limit * ($page - 1))
                    ->get();

                foreach ($brands as $brand) {
                    if ($brand->image != '' | $brand->image != null) {
                        $brand->image = "http://127.0.0.1:8000" . $brand->image;
                    }
                }

                return response()->json(
                    [
                        'pages' => $total_pages,
                        'brands' => $brands,
                    ]
                );
            }
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public static function getAllBrands(){
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
        $brand = Brand::find($id);
        $input = $request->all();
        try {
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
                "message" => "File successfully uploaded",
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
        $brand = Brand::find($id);
        if ($brand) {
            $brand->delete();
            return response()->json('succesfully deleted');
        }
        return response()->json('failed');
    }
}
