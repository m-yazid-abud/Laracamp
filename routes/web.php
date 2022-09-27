<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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


Route::get('/checkout', function () {
    return view('pages.front.checkout');
})->name('checkout');

Route::post('/success-checkout', function () {
    return view('pages.front.success-checkout');
})->name('success-checkout');

Route::get(
    "/dashboard",
    fn () => view('dashboard')
)->middleware(['auth'])->name('dashboard');

Route::get('/auth/google/redirect',  [UserController::class, "handleGoogleLogin"])->name('login.user.google');

Route::get('/auth/google/callback', [UserController::class, "handleGoogleLoginRedirect"]);

require __DIR__ . '/auth.php';
