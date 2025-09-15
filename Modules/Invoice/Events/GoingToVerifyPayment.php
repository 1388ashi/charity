<?php


namespace Modules\Invoice\Events;


use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Invoice\App\Models\Payment;

class GoingToVerifyPayment
{
    use Dispatchable, SerializesModels;
    /**
     * Listeners
     * @see CheckStoreOnVerified
     */
    public function __construct(public Payment $payment){}
}
