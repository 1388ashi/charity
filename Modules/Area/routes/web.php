<?php

use Illuminate\Support\Facades\Route;
use Modules\Area\App\Http\Controllers\Admin\CityController as AdminCityController;
use Modules\Area\App\Http\Controllers\User\CityController as UserCityController;
use Modules\Area\App\Http\Controllers\Admin\ProvinceController;

Route::middleware(['web', 'auth:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/cities/management/{province_id?}', [AdminCityController::class, 'index'])->name('cities.index');
    Route::resource('cities', AdminCityController::class)->except('index');
    Route::get('/cities-management', [AdminCityController::class, 'management'])->name('cities-management');
    Route::resource('provinces', ProvinceController::class);
});
Route::middleware(['web', 'auth:user'])->name('user.')->prefix('user')->group(function () {
    Route::get('/cities-management', [UserCityController::class, 'management'])->name('cities-management');
    Route::get('/cities/management/{province_id}', [UserCityController::class, 'index'])->name('cities.index');
    Route::resource('cities', UserCityController::class)->except('index');
});
Route::get('/cities/{province}', [AdminCityController::class, 'getByProvince'])->name('get-cities');