<?php

use Illuminate\Support\Facades\Route;
use Core\CustomInvoiceIn\Http\Controllers\CustomInvoiceInController;

Route::prefix('/api/business-access')
    ->middleware(['business'])->group(function () {
    Route::resource('/custom-invoice-ins', CustomInvoiceInController::class);
});