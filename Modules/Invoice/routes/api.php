<?php

use Illuminate\Support\Facades\Route;
use Modules\Invoice\App\Http\Controllers\All\GatewayController;

\Illuminate\Support\Facades\Route::name('payment.verify')
    ->any('payment/{gateway}/verify', [\Modules\Invoice\App\Http\Controllers\All\PaymentController::class, 'verify']);
\Illuminate\Support\Facades\Route::name('virtual-gateway')
    ->get('virtual-gateway/{virtual_gateway}', [\Modules\Invoice\App\Http\Controllers\All\VirtualGatewayController::class, 'pay']);

Route::superGroup('admin', function (){
    Route::resource('gateways', 'GatewayController')->except(['edit','delete']);
    Route::post('gateways/sort', 'GatewayController@sort');
});




