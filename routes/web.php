<?php

use App\Http\Controllers\OfficeBoyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TimeSettingController;
use App\Http\Controllers\EmployeeController;


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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/image/update', [App\Http\Controllers\ProfileController::class, 'updateProfileImage'])->name('profile.image.update');
    Route::get('/profile/image/remove', [App\Http\Controllers\ProfileController::class, 'removeProfileImage'])->name('profile.image.remove');
    Route::post('/profile/name/update', [App\Http\Controllers\ProfileController::class, 'updateName'])->name('profile.name.update');
    Route::post('/profile/password/update', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');

    Route::group(['middleware' => ['role:Admin']], function () {
        Route::resource('products', ProductController::class)->except('show');

        Route::post('/temp-upload', [ProductController::class, 'tempUpload'])->name('temp.product.upload');
        Route::delete('/temp-delete', [ProductController::class, 'tempDelete'])->name('temp.product.delete');

        Route::resource('office-boys', OfficeBoyController::class)->except('show');

        Route::get('time-settings', [TimeSettingController::class, 'index'])->name('time-settings.index');
        Route::put('time-settings', [TimeSettingController::class, 'update'])->name('time-settings.update');

        Route::get('employees', [EmployeeController::class, 'index'])->name('employees.index');
        Route::put('employees/{id}/balance', [EmployeeController::class, 'updateBalance'])->name('employees.balance.update');

    });

    Route::group(['middleware' => ['role:Employee']], function () {
        Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::get('/cart/{id}/add', [CartController::class, 'add'])->name('cart.add');
        Route::post('/cart/{id}/remove', [CartController::class, 'remove'])->name('cart.remove');
        Route::put('/cart/{id}/update', [CartController::class, 'update'])->name('cart.update');

        Route::get('order', [OrderController::class, 'store'])->name('order.store');
    });

    Route::group(['middleware' => ['role:Office Boy']], function () {
        Route::post('order', [OrderController::class, 'update'])->name('order.update');
        Route::get('order/{id}', [OrderController::class, 'show'])->name('order.show');
    });
});
