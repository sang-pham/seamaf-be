<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Laravel\Passport\Http\Controllers\AccessTokenController;

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

Route::middleware('auth:api')->get('/user-info', [AuthController::class, 'index']);

Route::group(['middleware' => ['auth:api', 'is-admin']], function() {
    Route::get('/products', [ProductController::class, 'index']);
    
    Route::get('/users', [UserController::class, 'index']);

    Route::delete('/user/{userId}', [UserController::class, 'delete']);

    Route::put('/user/{userId}', [UserController::class, 'update']);

    Route::post('/products', [ProductController::class, 'create']);

    Route::delete('/products/{productId}', [ProductController::class, 'delete']);

    Route::put('/products/{productId}', [ProductController::class, 'update']);

    Route::post('/categories', [CategoryController::class, 'create']);

    Route::put('/categories/{categoryId}', [CategoryController::class, 'update']);

    Route::delete('/categories/{categoryId}', [CategoryController::class, 'delete']);

    // Route::get('/info', [])
});

Route::post('login', [AccessTokenController::class, 'issueToken'])->middleware(['api-login', 'throttle']);

Route::post('/signup', [AuthController::class, 'register']);

Route::get('/categories', [CategoryController::class, 'index']);

Route::get('/category/{categoryId}', [ProductController::class, 'getProductsByCategory']);

Route::get('/products/search', [ProductController::class, 'searchProducts']);

Route::get('/products/top', [ProductController::class, 'getTopProducts']);

Route::get('/products/latest', [ProductController::class, 'getLatestProducts']);

Route::get('/products/{productId}', [ProductController::class, 'getProductById']);