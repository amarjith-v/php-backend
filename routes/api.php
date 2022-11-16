<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
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

Route::group(['prefix' => 'user'], function () {
    // Public routes
    Route::post('/login', [UserController::class,'login']);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    //for customer
    Route::get('/profile',[UserController::class,'profile']);
    Route::post('/place/order',[OrderController::class,'placeOrder']);
    Route::get('/view/status',[OrderController::class,'viewOrder']);

    //for delivery
    Route::get('/orders',[OrderController::class,'orderList']);
    Route::post('/order/update-status',[OrderController::class,'updateStatus']);

});
