<?php

use Illuminate\Support\Facades\Route;
use Modules\User\App\Http\Controllers\Admin\UserController;

Route::webSuperGroup('admin', function () {
    Route::resource('users', UserController::class);
});