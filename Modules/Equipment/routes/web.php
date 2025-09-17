<?php

use Illuminate\Support\Facades\Route;
use Modules\Equipment\App\Http\Controllers\Admin\EquipmentController;

Route::middleware(['web', 'auth:admin'])->prefix('admin')->group(function () {
    Route::resource('equipments', EquipmentController::class);
});