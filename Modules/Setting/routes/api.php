<?php

use Illuminate\Support\Facades\Route;
use Modules\Setting\App\Http\Controllers\Front\SettingController;

Route::prefix('front')->name('front')->group(function() {
    Route::get('/settings', [SettingController::class,'index']);
});
