<?php

use Illuminate\Support\Facades\Route;
use Core\InvoiceIn\Http\Controllers\InvoiceInController;

Route::prefix('/api/business-access')->middleware(['business'])->group(function () {
    Route::resource('/invoice-ins', InvoiceInController::class);
});