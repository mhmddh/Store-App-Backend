<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'price',
        'category_id',
        'brand_id',
    ];
    //Relations :
    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }

    public function files()
    {
        return $this->belongsToMany(File::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    //services:
    public function create($request)
    {
        $product = new Product();
        $product->name = $request->get('name');
        $product->price = $request->get('price');
        $product->category_id = $request->get('category');
        $product->brand_id = $request->get('brand');
        $product->save();
        return $product;
    }

    public function uploadFile($id, $request)
    {
        foreach ($request->file('file') as $file) {
            $filemodel = new File();
            $filename = $file->getClientOriginalName();
            $file->storeAs('public/products/product' . $id, $filename);
            $filemodel->name = $filename;
            $filemodel->model = 'product';
            $filemodel->parameter = $id;
            $filemodel->url = 'storage/products/product' . $id . '/' . $filename;
            $filemodel->save();
        }
        $this->save();
    }

    public static function getResponseArray($products)
    {
        $array = [];
        $i = 0;
        foreach ($products as  $product) {
            $brand_image = Brand::find($product['brand'])->first()->image;
            if ($brand_image != '' | $brand_image != null) {
                $brand_image = "http://127.0.0.1:8000" . $brand_image;
            }
            $array[$i]['id'] = $product->id;
            $array[$i]['name'] = $product->name;
            $array[$i]['price'] = $product->price;
            $array[$i]['brand'] = Brand::find($product['brand'])->first()->name;
            $array[$i]['brand_image'] = $brand_image;
            $array[$i]['category'] = Category::find($product['category'])->first()->name;
            $array[$i]['created_at'] = $product->created_at->format('m/d/Y');
            $i++;
        }
        return $array;
    }
}
