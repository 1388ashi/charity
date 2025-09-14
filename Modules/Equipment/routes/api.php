<?php

use Illuminate\Support\Facades\Route;
use Modules\Equipment\App\Http\Controllers\EquipmentController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('equipment', EquipmentController::class)->names('equipment');
});
