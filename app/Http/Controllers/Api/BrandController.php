<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
                    $brand->image = asset('storage/brands/' . $brand->image);
                }
            }
            if ($all_brands) {
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

    public static function getAllBrands()
    {
        try {
            $brands = Brand::all();
            foreach ($brands as $brand) {
                $brand->image = asset('storage/brands/' . $brand->image);
            }
            return response()->json($brands);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public static function getBrand($id)
    {
        try {
            $brand = Brand::find($id);
            if (!$brand) {
                return response()->json([
                    'success' => false,
                    'message' => 'Brand not found !!'
                ]);
            }

            if ($brand->image != '' | $brand->image != null) {
                $brand->image = asset('storage/brands/' . $brand->image);
            }
            return response()->json(
                [
                    'brand' => [
                        'id' => $brand->id,
                        'name' => $brand->name,
                        'image' => $brand->image,
                    ],
                    'success' => true,
                    'message' => 'Brand found successfully !!'
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
            $request->file->store('brands', 'public');
            $brand->image = $request->file->hashName();
            $brand->save();
            return response()->json([
                "success" => true,
                "message" => "File successfully uploaded",
            ]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }
    public static function deleteBrand($id)
    {
        try {
            $brand = Brand::find($id);
            if (Storage::exists('public/' . $brand->image)) {
                Storage::delete('public/' . $brand->image);
            }
            if ($brand) {
                $brand->delete();
                return response()->json([
                    "success" => true,
                    "message" => "Brand successfully deleted",
                ]);
            }
            return response()->json([
                "success" => false,
                "message" => "Cannot find this brand",
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                "success" => false,
                "message" => $exception->getMessage(),
            ]);
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
                    $brand->image = asset('storage/brands/' . $brand->image);
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
