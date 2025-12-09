<?php

use Illuminate\Support\Facades\Route;
use Core\Shipping\Http\Controllers\ShippingController;

Route::prefix('/api/business-access')->middleware(['business'])->group(function () {
    Route::resource('/shippings', ShippingController::class);
});