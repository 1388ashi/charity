<?php

namespace Modules\Invoice\App\Http\Controllers\All;


use App\Http\Controllers\Controller;
use Modules\Invoice\App\Models\Payment;

class GatewayController extends Controller
{
    public function index()
    {
        $gateways = Payment::getAvailableDriversForFront();

        return response()->success('', compact('a'));
    }
}
