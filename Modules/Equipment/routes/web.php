<?php

use Illuminate\Support\Facades\Route;
use Modules\Equipment\App\Http\Controllers\Admin\EquipmentController;

Route::webSuperGroup('admin', function () {
    Route::resource('equipments', EquipmentController::class);
});