
<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\urlShortening;
use App\Http\Controllers\UrlTableController;

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

Route::get('/register', function () {
    return view('register');
});

Route::get('/login', function () {
    return view('shortening');
})->middleware(['auth', 'verified'])->name('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/shortening', function () {
        return view('shortening');
    });
    Route::get('/url_table', [UrlTableController::class, 'urlTable'])->name('url_table');
    Route::post('/shortening', [urlShortening::class, 'shorten'])->name('shorten');
    Route::get('/{shortCode}', [urlShortening::class, 'redirectToOriginalUrl']);
    Route::delete('/url_table/{id}', [UrlTableController::class, 'deleteUrl'])->name('url_table.delete');
});


require __DIR__.'/auth.php';
