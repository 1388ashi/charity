<?php


namespace Modules\Invoice\Events;


use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Invoice\App\Models\Payment;
use Modules\Invoice\Contracts\GatewayVerifyResponse;

class PaymentVerified
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Payment $payment,
        public GatewayVerifyResponse $gatewayVerifyResponse,
    ){}
}
