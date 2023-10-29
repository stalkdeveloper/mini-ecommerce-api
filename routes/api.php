<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
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

Route::get('/product', [ProductController::class, 'index']);
Route::post('/store-product', [ProductController::class, 'store']);
Route::post('/edit-product/{id}', [ProductController::class, 'getOneProduct']);
Route::post('/update-product', [ProductController::class, 'updateProduct']);
Route::post('/delete-product/{id}', [ProductController::class, 'deleteProduct']);
Route::post('/search-product',[ProductController::class,'searchProduct']);

/*  */
Route::post('/orders-create',[OrderController::class,'create']);
Route::post('/get-order',[OrderController::class,'GetOrder']);
