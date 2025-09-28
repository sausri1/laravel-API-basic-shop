<?php

use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\UserAuthController;
use App\Http\Controllers\Api\V1\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



//Route::get('/profile', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::prefix('')->middleware(['throttle:api'])->group(function () {
    Route::post('signup', [UserAuthController::class, 'signup']);
    Route::post('login', [UserAuthController::class, 'login']);
    Route::apiResource('products', ProductController::class, ['only' => ['index', 'show']]);

});
Route::prefix('')->middleware(['throttle:api', 'auth:sanctum'])->group(function () {
    Route::apiResource('products', ProductController::class, ['only' => ['store', 'update', 'destroy']]);
    Route::get('logout', [UserAuthController::class, 'logout']);
    Route::get('profile', [UserAuthController::class, 'profile']);
    Route::patch('profile', [UserAuthController::class, 'update']);

    //cart
    Route::apiResource('cart', CartController::class, ['only' => ['index', 'destroy']]);
    Route::post('cart/{product}', [CartController::class, 'store']);

    //order
    Route::post('order', [OrderController::class, 'store']);
    Route::get('order', [OrderController::class, 'index']);
});
