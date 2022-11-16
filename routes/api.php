<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
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

// Route::post('/test', function(Request $request){
//     $pieces = explode(",", $request->productId);
//     print_r($pieces);
// });



Route::get('/products',[ProductController::class, 'index']);
Route::post('/create-customer', [CustomerController::class, 'store']);
Route::get('/customer-list', [CustomerController::class, 'index']);
Route::delete('/make-customer-inactive/{id}',[CustomerController::class, 'destroy']);
Route::put('/make-customer-active/{id}',[CustomerController::class, 'restore']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
