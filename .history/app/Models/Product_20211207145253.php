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
        'image'
    ];

    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }

    public function category()
    {
        return $this->has(Client::class);
    }

}
