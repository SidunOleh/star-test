<?php

use App\Http\Controllers\Admin\Categories\DeleteController as CategoriesDeleteController;
use App\Http\Controllers\Admin\Categories\GetController as CategoriesGetController;
use App\Http\Controllers\Admin\Categories\StoreController as CategoriesStoreController;
use App\Http\Controllers\Admin\Categories\UpdateController as CategoriesUpdateController;
use App\Http\Controllers\Admin\Images\UploadController;
use App\Http\Controllers\Admin\Orders\GetController;
use App\Http\Controllers\Admin\Products\DeleteController;
use App\Http\Controllers\Admin\Products\GetController as ProductsGetController;
use App\Http\Controllers\Admin\Products\StoreController;
use App\Http\Controllers\Admin\Products\UpdateController;
use App\Http\Controllers\Shop\Categories\GetAllController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:admin'])->group(function () {
    Route::prefix('/products')->name('products.')->group(function () {
        Route::get('/', ProductsGetController::class)
            ->name('get');
        Route::post('/', StoreController::class)
            ->name('store');
        Route::post('/{product}', UpdateController::class)
            ->name('update');
        Route::delete('/{product}', DeleteController::class)
            ->name('delete');
    });

    Route::prefix('/categories')->name('categories.')->group(function () {
        Route::get('/', CategoriesGetController::class)
            ->name('get');
        Route::get('/all', GetAllController::class)
            ->name('get-all');
        Route::post('/', CategoriesStoreController::class)
            ->name('store');
        Route::post('/{category}', CategoriesUpdateController::class)
            ->name('update');
        Route::delete('/{category}', CategoriesDeleteController::class)
            ->name('delete');
    });

    Route::prefix('/orders')->name('orders.')->group(function () {
        Route::get('/', GetController::class)
            ->name('get');
    });

    Route::prefix('/images')->name('images.')->group(function () {
        Route::post('/', UploadController::class)
            ->name('upload');
    });
});