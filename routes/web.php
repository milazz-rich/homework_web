<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'home'])->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::post('/register/verification-code', [AuthController::class, 'sendVerificationCode'])->name('register.verification-code');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/saldi', [ProductController::class, 'sales'])->name('catalog.sales');

Route::get('/product/{id}', [ProductController::class, 'show'])->whereNumber('id')->name('products.show');
Route::get('/api/products', [ProductController::class, 'apiIndex'])->name('api.products.index');
Route::get('/{catalog}', [ProductController::class, 'catalog'])
    ->whereIn('catalog', ['3d-printer', 'filamenti', 'accessori', 'makersupply', 'materiali', 'ams'])
    ->name('catalog.show');
