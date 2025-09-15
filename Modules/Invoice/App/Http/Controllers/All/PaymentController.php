<?php


namespace Modules\Invoice\App\Http\Controllers\All;


use App\Http\Controllers\Controller;
use Modules\Invoice\App\Models\Payment;

class PaymentController extends Controller
{
    public function verify($gatewayName)
    {
        $driver = config('invoice.drivers')[$gatewayName];
        if (!Payment::isDriverEnabled($gatewayName)) {
            return false;
        }
        $payDriver = new $driver['model']($driver['options'], $gatewayName);
        $transactionId = $payDriver->getTransactionId();
        if (!$transactionId) {
            return response()->error('Transaction Id not found');
        }
        /** @var $payment Payment */
        $payment = Payment::where('gateway', $payDriver->getname())->where('transaction_id', $transactionId)->first();

        if (!$payment) {
            return response()->error('Wrong transaction id');
        }

        return $payment->verify();
    }
}
