<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'categories';


    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
