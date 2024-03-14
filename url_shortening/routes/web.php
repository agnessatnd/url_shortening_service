<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\urlShortening;

// lingi lühendammise vaade
Route::get('/', function () {
    return view('shortening');
});

Route::post('/shortening', [urlShortening::class, 'shorten'])->name('shorten');
Route::get('/{shortCode}', [urlShortening::class, 'redirectToOriginalUrl']);
