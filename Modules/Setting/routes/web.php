<?php

use Illuminate\Support\Facades\Route;
use Modules\Setting\App\Http\Controllers\Admin\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::webSuperGroup('admin', function () {
    Route::get('settings', [SettingController::class, 'index'])
        ->name('settings.index');
    Route::post('settings/{group}', [SettingController::class, 'store'])
        ->name('settings.store');
    Route::get('settings/{setting}', [SettingController::class, 'edit'])
        ->name('settings.edit');
    Route::patch('settings', [SettingController::class, 'update'])
        ->name('settings.update');
    Route::delete('settings', [SettingController::class, 'destroy'])
        ->name('settings.destroy');
    Route::delete('/settings/{setting}/file', [SettingController::class, 'deleteFile'])
        ->name('settings.deleteFile');
});
