<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductSpecificationController;
use App\Http\Controllers\Api\ShoppingCartController;

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

Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('categories', [CategoryController::class, 'index']);
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{slug}', [ProductController::class, 'getProductsBySlug']);

Route::post('/specification/add', [ProductSpecificationController::class, 'store']);
Route::delete('/specification/delete', [ProductSpecificationController::class, 'destroy']);

Route::post('/cart/add', [ShoppingCartController::class, 'store']);
Route::put('/cart/update/quantity', [ShoppingCartController::class, 'updateQuantity']);
Route::delete('/cart/delete', [ShoppingCartController::class, 'destroy']);