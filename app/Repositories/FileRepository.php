<?php

namespace App\Repositories;

use App\Interfaces\FileRepositoryInterface;
use App\Models\File;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class FileRepository implements FileRepositoryInterface
{
    public function uploadFile($productID, $request)
    {
        $product = Product::find($productID);
        $product->uploadFile($product, $request);  
        return [
            "success" => true,
            "message" => "File successfully uploaded",
        ];
    }

    public function deleteFile($fileId)
    {
        $file = File::find($fileId);
        $file->delete();
        if (Storage::exists('public/products/product' . $file->product_id . '/' . $file->name)) {
            Storage::delete('public/products/product' . $file->product_id . '/' . $file->name);
        }
        return ['status' => 'Image deleted'];
    }
}
