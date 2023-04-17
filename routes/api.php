<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CartController;
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
    Route::get('/items', [CartController::class, 'allItems']);
    Route::get('/userItem/{id}', [CartController::class, 'userItems']);
    Route::get('/removeItem/{id}', [CartController::class, 'removeItem']);
});
