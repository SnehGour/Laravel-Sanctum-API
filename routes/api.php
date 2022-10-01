<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
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

/* Public Routes */

// Register
Route::post('/register',[AuthController::class,'register']);

// Login
Route::post('/login',[AuthController::class,'login']);
Route::get('/products',[ProductController::class,'index']);
Route::get('products/search/{name}',[ProductController::class,'search']);




// Protected Routes
Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::get('/getAllUsers',[AuthController::class,'getAllUser']);
    Route::post('/products',[ProductController::class,'store']);
    Route::get('/logout',[AuthController::class,'logout']);
    Route::put('/products/{id}',[ProductController::class,'update']);
    Route::delete('/products/{id}',[ProductController::class,'destroy']);
});