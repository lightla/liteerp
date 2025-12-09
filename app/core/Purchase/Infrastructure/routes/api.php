<?php

use Illuminate\Support\Facades\Route;
use Core\Purchase\Http\Controllers\PurchaseController;

Route::prefix('/api/business-access')->middleware(['business'])->group(function () {
    Route::resource('/purchases', PurchaseController::class);
});