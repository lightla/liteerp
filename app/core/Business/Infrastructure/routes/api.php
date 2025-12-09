<?php

use Core\Business\Http\Controllers\BusinessController;
use Illuminate\Support\Facades\Route;

Route::prefix('/api')->middleware(['isLogged'])->group(function () {
    Route::get('/business', [BusinessController::class, 'index']);
    Route::put('/business/{id}', [BusinessController::class, 'update']);
    Route::get('/business/{id}', [BusinessController::class, 'show']);
    Route::middleware(['IsAdmin'])->group(function () {
        Route::post('/business', [BusinessController::class, 'store']);
    });
});
