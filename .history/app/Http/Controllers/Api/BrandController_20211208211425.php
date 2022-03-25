<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public static function getAllBrands()
    {
        $brands = Brand::all();
        return response()->json($brands);
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
        if ($request->hasFile('image')) {
            $fileName = time().'_'.$req->file->getClientOriginalName();
            $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');

            $fileModel->name = time().'_'.$req->file->getClientOriginalName();
            $fileModel->file_path = '/storage/' . $filePath;
            $fileModel->save();
        }
        return response($request);
        // Brand::create($request);
        // return response('brand created succesfully');

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
