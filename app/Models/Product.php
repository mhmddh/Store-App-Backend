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
        return $this->hasMany(File::class);
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
    public static function createProduct($details)
    {
        $product = new Product();
        $product->name = $details['name'];
        $product->price = $details['price'];
        $product->category_id = $details['category'];
        $product->brand_id = $details['brand'];
        $product->save();
        return $product;
    }

    public function updateProduct($newDetails)
    {
        $brand = Brand::find($newDetails['brand']);
        $category = Category::find($newDetails['category']);
        $this->brand()->associate($brand);
        $this->category()->associate($category);
        $this->update($newDetails);
        return $this;
    }

    public function uploadFile($product, $request)
    {
        foreach ($request->file('file') as $file) {
            $filemodel = new File();
            $file->store('products/product'.$product->id, 'public');
            $filemodel->product_id = $product->id;
            $filemodel->name = $file->hashName();
            $product->files()->save($filemodel);
        }
    }

    public static function getResponse($products)
    {
        $array = [];
        $i = 0;
        foreach ($products as  $product) {
            if ($product->brand->image != '' | $product->brand->image != null) {
                $product->brand->image = asset('storage/brands/' . $product->brand->image);
            }
            $array[$i]['id'] = $product->id;
            $array[$i]['name'] = $product->name;
            $array[$i]['price'] = $product->price;
            $array[$i]['brand'] = $product->brand->name;
            $array[$i]['brand_image'] = $product->brand->image;
            $array[$i]['category'] = $product->category->name;
            $array[$i]['created_at'] = $product->created_at->format('m/d/Y');
            $i++;
        }
        return $array;
    }
}
