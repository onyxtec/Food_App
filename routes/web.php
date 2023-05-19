<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

    Route::group(['middleware' => ['role:Admin']], function () {
        Route::resource('products', ProductController::class)->except('show');
        Route::post('/temp-upload', [App\Http\Controllers\ProductController::class, 'tempUpload'])->name('temp.product.upload');
        Route::delete('/temp-delete', [App\Http\Controllers\ProductController::class, 'tempDelete'])->name('temp.product.delete');
    });
});
