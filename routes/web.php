<?php

use App\Http\Controllers\Admin\Auth\LogInController as AuthLogInController;
use App\Http\Controllers\Admin\Auth\LogOutController as AuthLogOutController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Shop\Auth\LogInController;
use App\Http\Controllers\Shop\Auth\LogOutController;
use App\Http\Controllers\Shop\Auth\SignUpController;
use Illuminate\Support\Facades\Route;

Route::post('/login', LogInController::class)
    ->name('login');
Route::post('/sign-up', SignUpController::class)
    ->name('sign-up');
Route::post('/logout', LogOutController::class)
    ->name('logout');

Route::post('/admin/login', AuthLogInController::class)
    ->name('admin.login');
Route::post('/admin/logout', AuthLogOutController::class)
    ->name('admin.logout');

Route::get('/{any}', IndexController::class)
    ->where('any', '^(?!api|admin-api).*$')
    ->name('index');
