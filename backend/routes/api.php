<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogOutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login',    [LoginController::class, 'login']);

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'user',
], function () {
    Route::get('/', [AuthController::class, 'user']);
    Route::post('/logout', [LogOutController::class, 'logOut']);
});

Route::apiResource('products', ProductController::class);
Route::apiResource('categories', CategoryController::class);

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'orders',
], function () {
    Route::post('/{order}/products', [OrderProductController::class, 'store']);
    Route::post('/{order}', [OrderController::class, 'store']);
    Route::get('/', [OrderController::class, 'index']);
    Route::get('/{order}', [OrderController::class, 'show']);
    Route::delete('/{order}', [OrderController::class, 'destroy']);

});

