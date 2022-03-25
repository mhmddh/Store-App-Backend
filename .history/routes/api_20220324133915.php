<?php

use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



//Product Apis :

Route::get('/products', [ProductController::class, 'getAllProducts'])->name('products');

Route::post('/purchase', [ProductController::class, 'purchaseProduct'])->name('purchase');

Route::post('/create-product', [ProductController::class, 'createProduct'])->name('create-product');

Route::get('/products-history/{id}', [ProductController::class, 'getProductsHistory'])->name('products-history');

Route::delete('/delete-product/{id}', [ProductController::class, 'deleteProduct'])->name('delete-product');

Route::get('/edit-product/{id}', [ProductController::class, 'getProduct'])->name('edit-product');

Route::put('/update-product/{id}', [ProductController::class, 'updateProduct'])->name('update-product');

//Category Apis :

Route::get('/categories', [CategoryController::class, 'getAllCategories'])->name('categories');

Route::post('/create-category', [CategoryController::class, 'createCategory'])->name('create-category');

Route::delete('/delete-category/{id}', [CategoryController::class, 'deleteCategory'])->name('delete-category');

Route::get('/edit-category/{id}', [CategoryController::class, 'getCategory'])->name('edit-category');

Route::put('/update-category/{id}', [CategoryController::class, 'updateCategory'])->name('update-category');

//Brand Apis :

Route::get('/brands', [BrandController::class, 'getAllBrands'])->name('brands');

Route::post('/create-brand', [BrandController::class, 'createBrand'])->name('create-brand');

Route::delete('/delete-brand/{id}', [BrandController::class, 'deleteBrand'])->name('delete-brand');

Route::get('/edit-brand/{id}', [BrandController::class, 'getBrand'])->name('edit-brand');

Route::put('/update-brand/{id}', [BrandController::class, 'updateBrand'])->name('update-brand');

