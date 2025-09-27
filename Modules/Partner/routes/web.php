<?php

use Illuminate\Support\Facades\Route;
use Modules\Partner\App\Http\Controllers\Admin\PartnerController as AdminPartnerController;
use Modules\Partner\App\Http\Controllers\Front\PartnerController as FrontPartnerController;
use Modules\Partner\App\Http\Controllers\User\PartnerController as UserPartnerController;

Route::prefix('/')->name('front.')->group(function() {
    Route::get('partners/create', [FrontPartnerController::class,'create'])->name('partners.create');
    Route::post('partners/store', [FrontPartnerController::class,'store'])->name('partners.store');
});
Route::middleware(['web', 'auth:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::resource('partners', AdminPartnerController::class)->except(['create','store','destroy']);
    // Route::get('partners/{partnerGroup}/print', [AdminPartnerController::class,'print'])->name('partners.print');
});
Route::middleware(['web', 'auth:user'])->name('user.')->prefix('user')->group(function () {
    // Route::resource('partners', UserPartnerController::class)->except(['create','store','destroy']);
    Route::get('management-partners', [UserPartnerController::class,'management'])->name('management.partners');
    Route::get('management-partners/{partnerGroup}', [UserPartnerController::class,'show'])->name('management.partners.show');

    Route::get('management-partners/provinces/{province_id}', [UserPartnerController::class,'provinceManagement'])
            ->name('province.management.partners');
    Route::put('management-partners/update-status/{partnerGroup}',[UserPartnerController::class, 'updateStatus'])
            ->name('management.partners.update-status'); 

    Route::get('management-partners/cities/{city_id}', [UserPartnerController::class,'cityManagement'])->name('city.management.partners');
    Route::post('partner/notes/store/{partnerGroup}', [UserPartnerController::class,'storeNote'])->name('partners.store-note');

});