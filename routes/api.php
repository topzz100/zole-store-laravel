<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource('products', ProductController::class);
Route::apiResource('products.variants', ProductVariantController::class)->shallow();
Route::apiResource('categories', CategoryController::class);

Route::get('v1/test', function () {
    return response()->json(['message' => 'API working']);
});
