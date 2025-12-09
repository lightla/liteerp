<?php

use Illuminate\Support\Facades\Route;
use Core\InvoiceOut\Http\Controllers\InvoiceOutController;

Route::prefix('api/business-access')->middleware(['business'])->group(function () {
    Route::resource('/invoice-outs', InvoiceOutController::class);
});