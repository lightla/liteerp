<?php

use Illuminate\Support\Facades\Route;
use Core\Order\Http\Controllers\OrderController;

Route::prefix('/api/business-access')->middleware(['business'])->group(function () {
    Route::resource('/orders', OrderController::class);
});