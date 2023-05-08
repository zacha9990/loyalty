<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\MerchantAuthController;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Merchant\DashboardController as MerchantDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\RedemptionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [CustomerAuthController::class, 'showLoginForm']);

Route::prefix('merchant')->group(function () {
    Route::get('login', [MerchantAuthController::class, 'showLoginForm'])->name('merchant.login');
    Route::post('logout', [MerchantAuthController::class, 'logout'])->name('merchant.logout');
    Route::post('login', [MerchantAuthController::class, 'login'])->name('merchant.post-login');
    Route::get('register', [MerchantAuthController::class, 'showRegistrationForm'])->name('merchant.register');
    Route::post('register', [MerchantAuthController::class, 'register']);
    Route::get('dashboard', [MerchantDashboardController::class, 'index'])->name('merchant.dashboard');
});

Route::prefix('admin')->group(function(){
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.post-login');

    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');


    Route::prefix('customer')->group(function(){
        Route::get('list', [CustomerController::class, 'list'])->name('admin.customer.list');

    });

    Route::resource('customer', CustomerController::class)->names([
        'index'   => 'admin.customer.index',
        'create'  => 'admin.customer.create',
        'store'   => 'admin.customer.store',
        'show'    => 'admin.customer.show',
        'edit'    => 'admin.customer.edit',
        'update'  => 'admin.customer.update',
        'destroy' => 'admin.customer.destroy',
    ]);

    Route::prefix('merchant')->group(function(){
        Route::get('list', [MerchantController::class, 'list'])->name('admin.merchant.list');

    });

    Route::resource('merchant', MerchantController::class)->middleware('auth:admin')->names([
        'index'   => 'admin.merchant.index',
        'create'  => 'admin.merchant.create',
        'store'   => 'admin.merchant.store',
        'show'    => 'admin.merchant.show',
        'edit'    => 'admin.merchant.edit',
        'update'  => 'admin.merchant.update',
        'destroy' => 'admin.merchant.destroy',
    ]);


});

Route::prefix('customer')->group(function () {
    Route::get('login', [CustomerAuthController::class, 'showLoginForm'])->name('customer.login');
    Route::post('logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');
    Route::post('login', [CustomerAuthController::class, 'login'])->name('customer.post-login');
    Route::get('register', [CustomerAuthController::class, 'showRegistrationForm'])->name('customer.register');
    Route::post('register', [CustomerAuthController::class, 'register'])->name('customer.post-register');

    Route::prefix('coupon')->group(function () {
        Route::get('/', [RedemptionController::class, 'index'])->name('customer.coupons');
        Route::get('convert', [RedemptionController::class, 'convertForm'])->name('customer.show_convert_form');
        Route::post('convert', [RedemptionController::class, 'convertProcess'])->name('customer.process_convert');
        Route::get('list', [RedemptionController::class, 'list'])->name('customer.coupons.list');
    });

    Route::get('dashboard', [DashboardController::class, 'index'])->name('customer.dashboard');
});

Route::middleware(['auth:customer,merchant'])->group(function () {
    Route::get('qrcode/{id}', [QrCodeController::class, 'scan'])->name('qrcode');
});
