<?php

use App\Http\Controllers\Admin\CheckoutController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\OrderController;
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

Route::middleware(['auth'])->group(function () {
    Route::get('/order/success', [OrderController::class, "success"])->name('order.success');
    Route::get('/order/{camp:slug}', [OrderController::class, "create"])->name("order.create");
    Route::post('/order/{id}', [OrderController::class, "store"])->name('order.store');
    Route::resource('/order', OrderController::class)->except(['create', 'store']);

    Route::get('dashboard', [HomeController::class, "index"])->name("dashboard");

    Route::name('admin.')->prefix('admin/dashboard')->middleware(['ensureUserRole:admin'])->group(function () {
        Route::get('/', [AdminDashboardController::class, "index"])->name('dashboard');
        Route::post('/checkout/{order}', [CheckoutController::class, "update"])->name('checkout.update');
    });

    Route::name('user.')->prefix('user/dashboard')->group(function () {
        Route::get('/', [DashboardController::class, "index"])->name("dashboard")->middleware('ensureUserRole:user');
    });
});

Route::get('/auth/google/redirect',  [UserController::class, "handleGoogleLogin"])->name('login.user.google');

Route::get('/auth/google/callback', [UserController::class, "handleGoogleLoginRedirect"]);

require __DIR__ . '/auth.php';
