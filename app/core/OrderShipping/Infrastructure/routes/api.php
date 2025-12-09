<?php

use Illuminate\Support\Facades\Route;
use Core\Ordershipping\Http\Controllers\OrderShippingController;

Route::prefix('/api/business-access')->middleware(['business'])->group(function () {
    Route::resource('/order-shippings', OrderShippingController::class);
});