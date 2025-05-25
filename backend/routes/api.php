<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SizeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('admin/login', [AuthController::class, 'authenticate']);

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {
    /** Categories All Api Routes */
    Route::resource('categories', CategoryController::class);
    /** Categories All Api Routes */
    Route::resource('brands', BrandController::class);
    /** Sizes All Api Routes */
    Route::resource('sizes', SizeController::class);
    /** Products All Api Routes */
    Route::resource('products', ProductController::class);
});
