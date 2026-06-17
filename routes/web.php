<?php

use App\Http\Controllers\CartPageController;
use App\Http\Controllers\AccessoriController;
use App\Http\Controllers\AmsController;
use App\Http\Controllers\FilamentiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginPageController;
use App\Http\Controllers\MakerSupplyController;
use App\Http\Controllers\MaterialiController;
use App\Http\Controllers\PaymentSuccessController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\ProductPageController;
use App\Http\Controllers\RegisterPageController;
use App\Http\Controllers\SaldiController;
use App\Services\AuthService;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [LoginPageController::class, 'show']);
Route::get('/register', [RegisterPageController::class, 'show']);
Route::get('/logout', function (AuthService $authService) {
    $authService->logout();

    return redirect()->route('home');
});

Route::get('/cart', [CartPageController::class, 'show']);
Route::get('/product', [ProductPageController::class, 'show']);
Route::get('/payment-success', [PaymentSuccessController::class, 'show']);

Route::get('/saldi', [SaldiController::class, 'index']);
Route::get('/3d-printer', [PrinterController::class, 'index']);
Route::get('/ams', [AmsController::class, 'index']);
Route::get('/filamenti', [FilamentiController::class, 'index']);
Route::get('/accessori', [AccessoriController::class, 'index']);
Route::get('/materiali', [MaterialiController::class, 'index']);
Route::get('/makersupply', [MakerSupplyController::class, 'index']);
