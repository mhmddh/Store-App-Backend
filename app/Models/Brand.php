<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Brand extends Model
{
    use HasFactory;


    protected $table = 'brands';

    protected $fillable = [
        'name',
        'image',
    ];

    public function create($request)
    {
        $brand = new Brand();
        $brand->name = $request->get('name');
        $brand->image = '';
        $brand->save();
        return $brand;
    }
}
