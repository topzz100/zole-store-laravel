<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public read-only endpoints (no authentication required)
Route::apiResource('products', ProductController::class)->only(['index', 'show']);
Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);
Route::apiResource('products.variants', ProductVariantController::class)
    ->only(['index', 'show'])
    ->shallow();

// Protected endpoints (create / update / delete require auth)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Cart routes (requires authentication - each user has their own cart)
    // Manual DELETE route for singular cart (without ID parameter)
    Route::delete('cart', [CartController::class, 'destroy']);
    // apiResource for other methods (GET, POST)
    Route::apiResource('cart', CartController::class)->except([
        'update',
        'destroy' // Exclude destroy since we defined it manually above
    ]);

    // Route::apiResource('orders', OrderController::class);
    //orders
    // Create order from cart
    Route::post('/orders', [OrderController::class, 'store']);

    // Get user's orders
    Route::get('/orders', [OrderController::class, 'index']);

    // Get single order
    Route::get('/orders/{order}', [OrderController::class, 'show']);

    //addresses
    Route::get('/addresses', [AddressController::class, 'index']);
    Route::get('/addresses/{address}', [AddressController::class, 'show']);
    Route::post('/addresses', [AddressController::class, 'store']);
    Route::put('/addresses/{address}', [AddressController::class, 'update']);
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy']);

    Route::apiResource('products', ProductController::class)->except(['index', 'show']);
    Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);
    Route::apiResource('products.variants', ProductVariantController::class)
        ->except(['index', 'show'])
        ->shallow();
});

Route::get('v1/test', function () {
    return response()->json(['message' => 'API working']);
});
