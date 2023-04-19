<?php
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Payment\QiwiController;
use App\Http\Controllers\Payment\PayPalController;
use Inertia\Inertia;

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
route::get('/blank', [PagesController::class, 'blank'])->name('blank');



route::post('/getItemInfo', [ShopController::class, 'getItem'])->name('getItem');
route::post('/buyItem', [ShopController::class, 'buyItem'])->name('buyItem');

Route::controller(QiwiController::class)
    ->prefix('payment/qiwi/')
    ->group(function () {
        Route::post('handler', 'qiwiHandler')->name('qiwi.handler');
        Route::post('redirect', 'qiwiRedirect')->name('qiwi.redirect');
    });

Route::controller(PayPalController::class)
    ->prefix('payment/paypal/')
    ->group(function () {
        Route::post('redirect', 'handlePayment')->name('make.payment');
        Route::get('cancel-payment', 'paymentCancel')->name('cancel.payment');
        Route::get('payment-success', 'paymentSuccess')->name('success.payment');
    });


require __DIR__.'/auth.php';
