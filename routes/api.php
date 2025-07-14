<?php

use App\Http\Controllers\Shop\Cart\AddProductController;
use App\Http\Controllers\Shop\Cart\ChangeQuantityController;
use App\Http\Controllers\Shop\Cart\DeleteItemController;
use App\Http\Controllers\Shop\Cart\GetCartItemsController;
use App\Http\Controllers\Shop\Categories\GetAllController;
use App\Http\Controllers\Shop\Orders\StoreController;
use App\Http\Controllers\Shop\Products\GetController;
use App\Http\Controllers\Shop\Products\GetPriceRangeController;
use App\Http\Controllers\Shop\Products\GetProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('/products')->name('products.')->group(function () {
    Route::get('/', GetController::class)
        ->name('get');
    Route::get('/price-range', GetPriceRangeController::class)
        ->name('get-price-range');
    Route::get('/{product}', GetProductController::class)
        ->name('get-product');
});

Route::prefix('/categories')->name('/categories')->group(function () {
    Route::get('/all', GetAllController::class)
        ->name('get-all');
});

Route::middleware(['auth:web'])->group(function () {
    Route::prefix('/cart')->name('cart.')->group(function () {
        Route::get('/', GetCartItemsController::class)
            ->name('get-cart-items');
        Route::post('/add-product', AddProductController::class)
            ->name('add-product');
        Route::post('/{cartItem}/change-quantity', ChangeQuantityController::class)
            ->name('change-quantity');
        Route::delete('/{cartItem}', DeleteItemController::class)
            ->name('delete-item');
    });

    Route::prefix('/orders')->name('orders.')->group(function () {
        Route::post('/', StoreController::class)
            ->name('store');
    });
});