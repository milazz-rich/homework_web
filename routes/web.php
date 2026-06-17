<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

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
