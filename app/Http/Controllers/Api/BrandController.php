<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public static function getAllBrands($limit, $page)
    {
        if ($limit == 0 && $page == 0) {
            $brands = Brand::all();
            return response()->json($brands);
        } else {
            $all_brands =  Brand::all()->count();
            $total_pages = ceil($all_brands / $limit);
            $brands = Brand::limit($limit)
                ->orderBy('created_at', 'DESC')
                ->offset($limit * ($page - 1))
                ->get();

            return response()->json(
                [
                    'pages' => $total_pages,
                    'brands' => $brands,
                ]
            );
        }
    }

    public static function getBrand($id)
    {
        $brand = Brand::find($id);

        return response()->json(
            [
                'id' => $brand->id,
                'name' => $brand->name,
            ]
        );
    }

    public static function updateBrand($id, Request $request)
    {
        $brand = Brand::find($id);
        $input = $request->all();
        try {
            $brand->update($input);
            return response()->json('updated successfully !!');
        } catch (\Throwable $th) {
            return response()->json('cannot update');
        }
    }

    public static function createBrand(Request $request)
    {
        try {
            Brand::create($request);
            return response('brand created succesfully');
        } catch (\Throwable $th) {
            return response('failed to create');
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
