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
        if ($request->hasFile('image')) {
            $image      = $request->file('image');
            $fileName   = time() . '.' . $image->getClientOriginalExtension();

            

            $img->stream(); // <-- Key point

            //dd();
            Storage::disk('local')->put('images/1/smalls' . '/' . $fileName, $img, 'public');
        }
        $brand->image = $request->file('image');
        $brand->save();
    }
}
