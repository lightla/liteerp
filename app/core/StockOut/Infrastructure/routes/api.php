<?php

use Illuminate\Support\Facades\Route;
use Core\StockOut\Http\Controllers\StockOutController;

Route::prefix('/api/business-access/stocks')->middleware(['business'])->group(function () {
    Route::resource('/outs', StockOutController::class);
});