<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('welcome'); });
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/services', function () { return view('services'); });
Route::get('/portfolio', function () { return view('portfolio'); });

use App\Http\Controllers\PageController;

// Catch-all route for dynamic pages
Route::get('/{slug}', [PageController::class, 'show'])->where('slug', '.*');
