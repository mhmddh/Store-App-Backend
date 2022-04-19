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

    Route::post('/user/{id}/change-password', [UserController::class, 'changePassword'])->name('change-password');

    //Product Apis :

    Route::get('/products', [ProductController::class, 'getPaginatedProducts'])->name('products');

    Route::post('/purchase', [ProductController::class, 'purchaseProduct'])->name('purchase');

    Route::post('/create-product', [ProductController::class, 'createProduct'])->name('create-product');

    Route::get('/products-history/{id}', [ProductController::class, 'getProductsHistory'])->name('products-history');

    Route::delete('/delete-product/{id}', [ProductController::class, 'deleteProduct'])->name('delete-product');

    Route::get('/edit-product/{id}', [ProductController::class, 'getProduct'])->name('edit-product');

    Route::put('/update-product/{id}', [ProductController::class, 'updateProduct'])->name('update-product');

    Route::get('/search-product', [ProductController::class, 'searchProduct'])->name('search-product');

    Route::post('/upload-product-files/{id}', [ProductController::class, 'uploadFile'])->name('upload-product-files');

    Route::delete('/delete-product-file/{id}', [ProductController::class, 'deleteFile'])->name('delete-file');

    //Category Apis :

    Route::get('/categories', [CategoryController::class, 'getPaginatedCategories'])->name('categories');

    Route::get('/all-categories', [CategoryController::class, 'getAllCategories'])->name('all-categories');


    Route::post('/create-category', [CategoryController::class, 'createCategory'])->name('create-category');

    Route::delete('/delete-category/{id}', [CategoryController::class, 'deleteCategory'])->name('delete-category');

    Route::get('/edit-category/{id}', [CategoryController::class, 'getCategory'])->name('edit-category');

    Route::put('/update-category/{id}', [CategoryController::class, 'updateCategory'])->name('update-category');

    Route::get('/search-category', [CategoryController::class, 'searchCategory'])->name('search-catehory');

    //Brand Apis :

    Route::get('/brands', [BrandController::class, 'getPaginatedBrands'])->name('brands');

    Route::get('/all-brands', [BrandController::class, 'getAllBrands'])->name('all-brands');


    Route::post('/create-brand', [BrandController::class, 'createBrand'])->name('create-brand');

    Route::delete('/delete-brand/{id}', [BrandController::class, 'deleteBrand'])->name('delete-brand');

    Route::get('/edit-brand/{id}', [BrandController::class, 'getBrand'])->name('edit-brand');

    Route::put('/update-brand/{id}', [BrandController::class, 'updateBrand'])->name('update-brand');

    Route::post('/upload-brand-file/{id}', [BrandController::class, 'uploadFile'])->name('upload-brand-logo');

    Route::get('/search-brand', [BrandController::class, 'searchBrand'])->name('search-brand');
});
