<?php

use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;

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

// Login API:

Route::post('login', [App\Http\Controllers\API\AuthController::class, 'login'])->name('login');


Route::middleware(['auth:sanctum'])->group(function () {
    //User API:
    Route::get('/user/{id}', [UserController::class, 'getUserDetails'])->name('user-details');

    Route::put('/update-user/{id}', [UserController::class, 'updateUser'])->name('update-user');

    Route::get('/change-password/{id}', [UserController::class, 'changePassword'])->name('change-password');

    //Product Apis :

    Route::get('/products/{limit}/{page}/{param?}/{order?}', [ProductController::class, 'getPaginatedProducts'])->name('products');

    Route::post('/purchase', [ProductController::class, 'purchaseProduct'])->name('purchase');

    Route::post('/create-product', [ProductController::class, 'createProduct'])->name('create-product');

    Route::get('/products-history/{id}', [ProductController::class, 'getProductsHistory'])->name('products-history');

    Route::delete('/delete-product/{id}', [ProductController::class, 'deleteProduct'])->name('delete-product');

    Route::get('/edit-product/{id}', [ProductController::class, 'getProduct'])->name('edit-product');

    Route::put('/update-product/{id}', [ProductController::class, 'updateProduct'])->name('update-product');

    //Category Apis :

    Route::get('/categories/{limit}/{page}/{param?}/{order}', [CategoryController::class, 'getPaginatedCategories'])->name('categories');

    Route::get('/categories', [CategoryController::class, 'getAllCategories'])->name('categories');


    Route::post('/create-category', [CategoryController::class, 'createCategory'])->name('create-category');

    Route::delete('/delete-category/{id}', [CategoryController::class, 'deleteCategory'])->name('delete-category');

    Route::get('/edit-category/{id}', [CategoryController::class, 'getCategory'])->name('edit-category');

    Route::put('/update-category/{id}', [CategoryController::class, 'updateCategory'])->name('update-category');

    //Brand Apis :

    Route::get('/brands/{limi}/{page}/{param?}/{order?}', [BrandController::class, 'getPaginatedBrands'])->name('brands');

    Route::get('/brands', [BrandController::class, 'getAllBrands'])->name('brands');


    Route::post('/create-brand', [BrandController::class, 'createBrand'])->name('create-brand');

    Route::delete('/delete-brand/{id}', [BrandController::class, 'deleteBrand'])->name('delete-brand');

    Route::get('/edit-brand/{id}', [BrandController::class, 'getBrand'])->name('edit-brand');

    Route::put('/update-brand/{id}', [BrandController::class, 'updateBrand'])->name('update-brand');

    Route::post('/upload-brand-file/{id}', [BrandController::class, 'uploadFile'])->name('upload-brand-logo');
});
