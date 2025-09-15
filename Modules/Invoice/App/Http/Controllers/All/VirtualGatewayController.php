<?php

namespace Modules\Invoice\App\Http\Controllers\All;

use App\Http\Controllers\Controller;
use Modules\Invoice\App\Models\VirtualGateway;

class VirtualGatewayController extends Controller
{
    public function pay($id)
    {
        $virtualGateway = VirtualGateway::where('id', $id)->first();
        if (!$virtualGateway) {
            abort(404);
        }

        return view('core::invoice.pay', compact('virtualGateway'));
    }

}
