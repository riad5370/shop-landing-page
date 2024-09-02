<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;


Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('details/{slug}', [FrontendController::class, 'details'])->name('details');
Route::post('/review/store',[FrontendController::class,'reviewStore'])->name('review.store');

Route::get('/checkout',[CheckoutController::class,'checkoutShow'])->name('checkout.show');
Route::post('checkout-add', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/checkout/store',[CheckoutController::class,'store'])->name('checkout.store');
Route::get('/order/success/{abc}',[FrontendController::class,'orderSuccess'])->name('order.success');

Route::get('cart', [CartController::class, 'cart'])->name('cart');
Route::post('/add/cart',[CartController::class,'cartStore'])->name('add.cart');
Route::get('cart-remove/{id}', [CartController::class, 'cartRemove'])->name('cart.remove');
Route::post('cart-update', [CartController::class, 'cartUpdate'])->name('cart.update');



Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    //order
    Route::get('/orders',[OrderController::class,'orders'])->name('orders');
    Route::get('/orders/details/{id}',[OrderController::class,'ordersDetails'])->name('order.details');
    Route::post('/order/status',[OrderController::class,'orderStatus'])->name('order.status');
    Route::get('/order-delete/{id}',[OrderController::class,'orderDelete'])->name('delete.orders');

    Route::resource('products', ProductController::class);

});

require __DIR__.'/auth.php';
