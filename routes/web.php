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
    Route::get('/profile/view', [App\Http\Controllers\ProfileViewController::class, 'index'])->name('profile.view');
    Route::post('/profile/image/update', [App\Http\Controllers\ProfileViewController::class, 'update'])->name('profile.image.update');
    Route::get('/profile/image/remove', [App\Http\Controllers\ProfileViewController::class, 'remove'])->name('profile.image.remove');
    Route::post('/user/name/update/{id}', [App\Http\Controllers\ProfileViewController::class, 'updateName'])->name('user.name.update');
    Route::post('/update/password', [App\Http\Controllers\ProfileViewController::class, 'updatePassword'])->name('update.password');

});

