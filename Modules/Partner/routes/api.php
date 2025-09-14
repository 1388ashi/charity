<?php

use Illuminate\Support\Facades\Route;
use Modules\Partner\App\Http\Controllers\PartnerController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('partners', PartnerController::class)->names('partner');
});
