<?php

use Illuminate\Support\Facades\Route;
use Core\PriceList\Http\Controllers\PriceListController;

Route::prefix('/api/business-access')->middleware(['business'])->group(function () {
    Route::resource('/price-lists', PriceListController::class);
});