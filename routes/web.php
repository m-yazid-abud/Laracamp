<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('pages.front.index');
})->name('index');

Route::get('/login', function () {
    return view('pages.front.login');
})->name('login');

Route::get('/checkout', function () {
    return view('pages.front.checkout');
})->name('checkout');

Route::post('/success-checkout', function () {
    return view('pages.front.success-checkout');
})->name('success-checkout');
