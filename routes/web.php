<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ItemsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\Payment\PayPalController;
use App\Http\Controllers\Payment\StripeController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


route::get('/', [PagesController::class, 'index'])->name('index');
route::get('/shop', [PagesController::class, 'shop'])->name('shop');

route::post('/getItemInfo', [ShopController::class, 'getItem'])->name('getItem');

Route::group(['middleware' => 'auth'], function () {
   route::post('/buyItem', [ShopController::class, 'buyItem'])->name('buyItem');
});

Route::controller(PayPalController::class)
    ->prefix('payment/paypal/')
    ->group(function () {
        Route::post('redirect', 'handlePayment')->name('make.payment');
        Route::get('payment-success', 'paymentSuccess')->name('success.payment');
    });

Route::controller(StripeController::class)
    ->prefix('payment/stripe/')
    ->group(function () {
        Route::post('redirect', 'redirect')->name('stripe.redirect');
        Route::get('success', 'success')->name('stripe.success');
        Route::post('webhook', 'webhook')->name('stripe.webhook');
    });

require __DIR__ . '/auth.php';
