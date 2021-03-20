<?php

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

Route::redirect('/', '/home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/products/search', [App\Http\Controllers\ProductController::class, 'search'])->name('products.search');
Route::resource('products', App\Http\Controllers\ProductController::class)->middleware('auth');


Route::get('/add-to-cart/{product}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add')->middleware('auth');
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index')->middleware('auth');
Route::get('/cart/destory/{product}', [App\Http\Controllers\CartController::class, 'destory'])->name('cart.destory')->middleware('auth');
Route::get('/cart/update/{product}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update')->middleware('auth');
Route::get('/cart/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout')->middleware('auth');
Route::get('/cart/apply-coupon', [App\Http\Controllers\CartController::class, 'applyCoupon'])->name('cart.coupon')->middleware('auth');



Route::get('paypal/checkout/{order}', [App\Http\Controllers\PayPalController::class, 'getExpressCheckout'])->name('paypal.checkout')->middleware('auth');
Route::get('paypal/checkout-success/{order}', [App\Http\Controllers\PayPalController::class, 'getExpressCheckoutSuccess'])->name('paypal.success')->middleware('auth');
Route::get('paypal/checkout-cancel', [App\Http\Controllers\PayPalController::class, 'cancelPage'])->name('paypal.cancel')->middleware('auth');



Route::get('ecpay/checkout/{order}', [App\Http\Controllers\ECPayController::class, 'getECPayCheckout'])->name('ecpay.checkout')->middleware('auth');
Route::post('ecpay/listenPayResult/{order}', [App\Http\Controllers\ECPayController::class, 'listenPayResult'])->name('ecpay.listenPayResult')->middleware('auth');
Route::post('ecpay/checkout-success/{order}', [App\Http\Controllers\ECPayController::class, 'getECPayCheckoutSuccess'])->name('ecpay.success')->middleware('auth');


Route::resource('orders', App\Http\Controllers\OrderController::class)->middleware('auth');
// Route::post('/success', [App\Http\Controllers\OrderController::class, 'success'])->name('order.success')->middleware('auth');
Route::get('/redirectFromECpay', [App\Http\Controllers\OrderController::class, 'redirectFromECpay'])->name('order.redirectFromECpay')->middleware('auth');

Route::resource('shops', App\Http\Controllers\ShopController::class)->middleware('auth');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
	Route::get('/order/pay/{suborder}', [App\Http\Controllers\SubOrderController::class, 'pay'])->name('order.pay');
});

Route::group(['prefix' => 'seller', 'middleware' => 'auth', 'as' => 'seller.', 'namespace' => 'App\Http\Controllers\Seller'], function(){
	Route::redirect('/', 'seller/orders');
	Route::resource('/orders', 'OrderController');
	Route::get('/orders/delivered/{suborder}',  'OrderController@markDelivered')->name('order.delivered');
});


