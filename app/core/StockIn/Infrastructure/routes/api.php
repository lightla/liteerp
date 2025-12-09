<?php

use Illuminate\Support\Facades\Route;
use Core\StockIn\Http\Controllers\StockInController;

Route::prefix('/api/business-access/stocks')->middleware(['business'])->group(function () {
    Route::resource('/ins', StockInController::class);
});