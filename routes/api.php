<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index'])->name('products.get');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.get.single');

Route::middleware('auth:api')->group(function () {
    Route::post('/products', [ProductController::class, 'store'])->name('products.post');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.put');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.delete');
});
