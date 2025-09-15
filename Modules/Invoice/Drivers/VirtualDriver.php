<?php


namespace Modules\Invoice\Drivers;


use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Invoice\App\Models\VirtualGateway;
use Modules\Invoice\Classes\GatewayMakeResponse;
use Modules\Invoice\Classes\GatewayVerifyResponse;
use Modules\Invoice\Classes\PayDriver;


class VirtualDriver extends PayDriver
{
    public function make($amount, string $callback): GatewayMakeResponse
    {
        $virtualGateway = VirtualGateway::create([
            'amount' => $amount,
            'callback' => $callback,
            'transaction_id' => $transactionId = Str::random(10)
        ]);

        return new GatewayMakeResponse(
            true,
            $transactionId,
            route('virtual-gateway', $virtualGateway->id)
        );
    }

    public function verify(Request $request = null): GatewayVerifyResponse
    {
        if ($request?->input('success') ?? \request('success')) {
            $payment = $this->getPayment();
            $payment->goSuccess();

            return new GatewayVerifyResponse(true);
        } else {
            return new GatewayVerifyResponse(false);
        }
    }

    public function getTransactionId(Request $request = null): ?string
    {
        return $request?->input('transaction_id') ?? request('transaction_id');
    }
}
