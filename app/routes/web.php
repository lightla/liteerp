<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('dashboard')->group(function () {
    Route::get('/', 'App\Http\Controllers\FE\DashboardController@index');
    Route::get('/{slug}', 'App\Http\Controllers\FE\DashboardController@index');
});
