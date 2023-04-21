<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ServerController;
use App\Http\Controllers\Api\ShopController;
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
Route::group(['middleware' => 'apisecurity'], function () {

    Route::get('/cart/items', [CartController::class, 'items']); // get all items
    Route::get('/cart/userItem/{id}', [CartController::class, 'add']); // get user cart by steamid
    Route::get('/cart/removeItem/{id}', [CartController::class, 'remove']); // remove item from cart by ID
    Route::get('/shop/items', [ShopController::class, 'items']); // get all items
    Route::post('/shop/addItem/', [ShopController::class, 'add']); // add item to SHOP
    Route::get('/shop/removeItem/{id}', [ShopController::class, 'remove']); // remove item from cart by ID
});

Route::get('/online', [ServerController::class, 'serverData']); // get server online
