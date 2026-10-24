<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/products');
Auth::routes(['reset' => false, 'verify' => false]);
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::resource('products', ProductController::class)->middleware('auth');
