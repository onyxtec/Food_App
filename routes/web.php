<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/image/update', [App\Http\Controllers\ProfileController::class, 'updateProfileImage'])->name('profile.image.update');
    Route::get('/profile/image/remove', [App\Http\Controllers\ProfileController::class, 'removeProfileImage'])->name('profile.image.remove');
    Route::post('/profile/name/update', [App\Http\Controllers\ProfileController::class, 'updateName'])->name('profile.name.update');
    Route::post('/profile/password/update', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');

    Route::get('/product/create', [App\Http\Controllers\ProductController::class, 'index'])->name('product.create');
    Route::get('/product/edit/{id}', [App\Http\Controllers\ProductController::class, 'editProduct'])->name('product.edit');
    Route::put('/product/update/{id}', [App\Http\Controllers\ProductController::class, 'updateProduct'])->name('product.update');
    Route::get('/product/listing', [App\Http\Controllers\ProductController::class, 'listProducts'])->name('product.listing');
    Route::post('/product/store', [App\Http\Controllers\ProductController::class, 'storeProduct'])->name('product.store');
    Route::delete('/product/{id}', [App\Http\Controllers\ProductController::class, 'destroyProduct'])->name('product.destroy');
    Route::post('/temp-upload', [App\Http\Controllers\ProductController::class, 'tempUpload'])->name('temp.product.upload');
    Route::delete('/temp-delete', [App\Http\Controllers\ProductController::class, 'tempDelete'])->name('temp.product.delete');

});

