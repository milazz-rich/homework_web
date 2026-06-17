<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () { return view('welcome'); });
Route::get('/register', function () { return view('welcome'); });

Route::get('/cart', function () { return view('welcome'); });
Route::get('/product', function () { return view('welcome'); });
Route::get('/payment-success', function () { return view('welcome'); });

Route::get('/saldi', function () { return view('welcome'); });
Route::get('/3d-printer', function () { return view('welcome'); });
Route::get('/ams', function () { return view('welcome'); });
Route::get('/filamenti', function () { return view('welcome'); });
Route::get('/accessori', function () { return view('welcome'); });
Route::get('/materiali', function () { return view('welcome'); });
Route::get('/makersupply', function () { return view('welcome'); });

Route::prefix('api')->group(function (): void {
    Route::get('/products', [ProductController::class, 'index']);

    Route::get('/cart', [ShopController::class, 'cartIndex']);
    Route::post('/cart', [ShopController::class, 'cartStore']);
    Route::delete('/cart', [ShopController::class, 'cartDestroy']);

    Route::post('/checkout', [ShopController::class, 'createCheckoutSession']);
    Route::post('/checkout/buy-now', [ShopController::class, 'createBuyNowCheckoutSession']);

    Route::post('/send-verification-code', [AuthController::class, 'sendVerificationCode']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout']);
});

Route::post('/checkout/buy-now', [ShopController::class, 'createBuyNowCheckoutSession']);
