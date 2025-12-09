<?php

use Illuminate\Support\Facades\Route;
use Core\PurchaseItem\Http\Controllers\PurchaseItemController;

Route::prefix('/api/business-access')->middleware(['business'])->group(function () {
    Route::resource('/purchase-items', PurchaseItemController::class);
});