<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/services', function () { return view('services'); });
Route::get('/portfolio', function () { return view('portfolio'); });
Route::get('/products', function () { return view('products'); });
Route::get('/about', function () { return view('about'); });
Route::get('/careers', function () { return view('careers'); });
Route::get('/contact', function () { return view('contact'); });
Route::get('/blog', function () { return view('blog'); });
Route::get('/request-quote', function () { return view('request-quote'); });
