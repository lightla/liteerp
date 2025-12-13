<?php

use Illuminate\Support\Facades\Route;
use Core\Overview\Http\Controllers\CreateOverviewController;

Route::prefix(strtolower('Overviews'))->group(function () {
    Route::post('/', CreateOverviewController::class)->name('Overview.create');
});