<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ItemsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\Payment\PayPalController;
use App\Http\Controllers\Payment\StripeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WebCartController;
use App\Http\Controllers\PromocodeController;
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

//render page
route::get('/', [PagesController::class, 'index'])->name('index');
route::get('/shop', [PagesController::class, 'shop'])->name('shop');
route::get('/blank', [PagesController::class, 'blank'])->name('blank');
route::get('/leaders', [PagesController::class, 'leaders'])->name('leaders');
route::get('/banlist', [PagesController::class, 'banlist'])->name('banlist');
route::get('/stats', [PagesController::class, 'stats'])->name('stats');
route::post('/getItemInfo', [ShopController::class, 'getItem'])->name('getItem');

//pm
Route::group(['middleware' => 'auth'], function () {
    route::post('/itemToCart', [WebCartController::class, 'addToCart'])->name('addToCart');
    route::get('/getCart', [WebCartController::class, 'getCart'])->name('getCart');
    Route::delete('/removeFromCart/{id}', [WebCartController::class, 'removeFromCart'])->name('removeFromCart');
    route::get('/buyAsCart', [ShopController::class, 'buyAsCart'])->name('buyAsCart');
    route::post('/buyItem', [ShopController::class, 'buyItem'])->name('buyItem');
    route::post('/promo/check', [PromocodeController::class, 'promo_check'])->name('promo_check');
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
//dashboard render + functional
Route::group(['middleware' => 'admin'], function () {
    route::get('/dashboard', [DashboardController::class, 'main'])->name('dashboard_main');
    Route::resource('items', ItemsController::class);
    Route::get('/items/show/{id}', [ItemsController::class, 'show']);
});
require __DIR__ . '/auth.php';
