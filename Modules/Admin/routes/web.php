<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\App\Http\Controllers\Admin\AdminController;

Route::webSuperGroup('admin', function () {
    Route::resource('admins', AdminController::class);
});