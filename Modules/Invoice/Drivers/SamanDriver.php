<?php

namespace Modules\Invoice\Drivers;
use Illuminate\Http\Request;
use Modules\Core\Classes\CoreSettings;
use Modules\Invoice\Classes\GatewayMakeResponse;
use Modules\Invoice\Classes\GatewayVerifyResponse;
use Modules\Invoice\Classes\PayDriver;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice as ShetabitInvoice;
use Shetabit\Multipay\Payment;
// use \Shetabit\Shopit\Modules\Invoice\Drivers\SamanDriver as BaseSamanDriver;

class SamanDriver extends PayDriver
{
    public function make($amount, string $callback): GatewayMakeResponse
    {
        /** @var Payment $shetabitPayment */
        $shetabitPayment = \Shetabit\Payment\Facade\Payment::via('saman')->callbackUrl($callback);
        $settings = app(CoreSettings::class);
        foreach ($settings->get('invoice.active_drivers.saman.config') as $key => $value) {
            $shetabitPayment->config($key, $value);
        }
        $invoice = (new ShetabitInvoice())->amount($amount);
        $transactionId = null;
        $response = $shetabitPayment->purchase($invoice, function ($driver, $_transactionId) use (&$transactionId) {
            $transactionId = $_transactionId;
        })->pay();

        return new GatewayMakeResponse(
            true,
            $invoice->getUuid(),
            $response->getAction(),
            $response->getMethod(),
            $response->getInputs()
        );
    }

    public function verify(Request $request = null): GatewayVerifyResponse
    {
        try {
            $shetabitPayment = \Shetabit\Payment\Facade\Payment::via('saman');
            $settings = app(CoreSettings::class);
            foreach ($settings->get('invoice.active_drivers.saman.config') as $key => $value) {
                $shetabitPayment->config($key, $value);
            }
            $receipt = $shetabitPayment->amount($this->getPayment()->invoice->getPayAmount())
                ->transactionId($this->getTransactionId($request))->verify();
            $this->getPayment()->tracking_code = $receipt->getReferenceId();
            $this->getPayment()->status = \Modules\Invoice\Entities\Payment::STATUS_SUCCESS;
            $this->getPayment()->save();

            return new GatewayVerifyResponse(true);

        } catch (InvalidPaymentException $exception) {
            $this->getPayment()->invoice->status_detail = $exception->getMessage();
            $this->getPayment()->invoice->save();

            \Log::error('ارور درگاه: ' . $exception->getMessage());
            \Log::error($exception->getTraceAsString());
            return new GatewayVerifyResponse(false, $exception->getMessage());
        }
    }

    public function getTransactionId(Request $request = null): ?string
    {
        return $request?->input('ResNum') ?? request('ResNum');
    }
}
