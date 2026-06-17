<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CurrencyController;
use App\Http\Controllers\Api\NewsletterController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ShopController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function (): void {
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

    Route::post('/currency-converter', [CurrencyController::class, 'convert']);
    Route::post('/newsletter', [NewsletterController::class, 'signup']);
});
