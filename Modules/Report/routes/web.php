<?php

use Illuminate\Support\Facades\Route;
use Modules\Report\App\Http\Controllers\Admin\ReportController as AdminReportController;
use Modules\Report\App\Http\Controllers\User\ReportController as UserReportController;

Route::middleware(['web', 'auth:admin'])->prefix('admin')->group(function () {
    Route::get('/reports/partners-aggregate', [AdminReportController::class, 'partnersDetail'])->name('reports.partners-aggregate');
    Route::get('/reports/partners-aggregate-cities/{province}', [AdminReportController::class, 'partnersDetailCity'])->name('reports.partners-aggregate-cities');
    Route::get('/reports/partners-aggregate-list/{city}', [AdminReportController::class, 'partnersDetailList'])->name('reports.partners-aggregate-list');
});
Route::middleware(['web', 'auth:user'])->prefix('user')->group(function () {
    Route::get('/reports/partners-aggregate', [UserReportController::class, 'management'])->name('reports.partners-aggregate');
    Route::get('/reports/partners-aggregate-cities/{province}', [UserReportController::class, 'partnersDetailCity'])->name('reports.partners-aggregate-cities');
    Route::get('/reports/partners-aggregate-list/{city}', [UserReportController::class, 'partnersDetailList'])->name('reports.partners-aggregate-list');
});