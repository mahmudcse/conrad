<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;

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


Route::get('/products',[ProductController::class, 'index']);
Route::post('/create-customer', [CustomerController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);


Route::get('/customer-list', [CustomerController::class, 'index']);
Route::delete('/make-customer-inactive/{id}',[CustomerController::class, 'destroy']);
Route::put('/make-customer-active/{id}',[CustomerController::class, 'restore']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/update-customer/{id}', [CustomerController::class, 'update']);

    Route::get('/my-orders', [OrderController::class, 'index']);
    Route::get('/order-details/{id}', [OrderController::class, 'show']);
    Route::post('/place-order', [OrderController::class, 'store']);

    Route::post('/logout', [AuthController::class, 'logout']);
});


