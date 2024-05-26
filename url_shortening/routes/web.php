<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UrlTable;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\urlShortening;
use App\Http\Controllers\UrlTabler;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\ConfirmablePasswordController;

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

Route::get('/verify-email', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::post('/verify-email/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->intended('/shortening');
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
    ->middleware('auth')
    ->name('password.confirm');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'confirm'])
    ->middleware('auth');

Route::get('/register', function () {
    return view('register');
});

Route::get('/login', function () {
    return view('login');
})->middleware(['auth', 'verified'])->name('auth');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::middleware(['auth'])->group(function () {
    Route::get('/shortening', function () {
        return view('shortening');
    })->name('shortening');
    
    Route::get('/url_table', [UrlTable::class, 'urlTable'])->name('url_table');
    Route::delete('/url_table/{id}', [UrlTable::class, 'deleteUrl'])->name('url_table.delete');
    Route::get('/edit_url/{id}', [UrlTable::class, 'editUrl'])->name('edit_url');
    Route::post('/update_custom_link/{id}', [UrlTable::class, 'editUrlData']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/generate-shortened-url', [urlShortening::class, 'shorten'])->name('shorten');
    Route::post('/shortening', [urlShortening::class, 'saveShortenedUrl'])->name('saveShortenedUrl');
    Route::post('/delete-selected-rows', [UrlTable::class, 'deleteSelectedRows']);
});

Route::get('/{shortCode}', [urlShortening::class, 'redirectToOriginalUrl']);


require __DIR__.'/auth.php';
