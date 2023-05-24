<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ServerController;
use App\Http\Controllers\Api\ShopController;
/*
|-------------------------------------------------------------- ------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group(['middleware' => 'apisecurity'], function () {

    Route::prefix('cart')->group(function () {
        Route::get('items', [CartController::class, 'getAllItems']); // получить все товары в корзине
        Route::get('user/{id}', [CartController::class, 'getUserCart']); // получить корзину пользователя по его ID
        Route::delete('item/{id}', [CartController::class, 'removeItem']); // удалить товар из корзины по его ID
    });

    Route::prefix('shop')->group(function () {
        Route::get('items', [ShopController::class, 'getAllItems']); // получить все товары в магазине
        Route::post('item', [ShopController::class, 'addItem']); // добавить товар в магазин
        Route::delete('item/{id}', [ShopController::class, 'removeItem']); // удалить товар из магазина по его ID
    });

});

Route::get('/online', [ServerController::class, 'serverData']); // получить онлайн сервера
