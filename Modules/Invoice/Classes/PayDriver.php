<?php


namespace Modules\Invoice\Classes;


use Illuminate\Http\Request;
use Modules\Invoice\App\Models\Payment;

abstract class PayDriver
{
    protected Payment $payment;

    public function __construct(protected array $options, protected string $name) {}

    /**
     * @return GatewayMakeResponse
     */
    public abstract function make($amount, string $callback);

    /**
     * @return GatewayVerifyResponse
     */
    public abstract function verify(Request $request = null);

    public abstract function getTransactionId(Request $request = null): ?string;

    public function setPayment(Payment $payment) {
        $this->payment = $payment;

        return $this;
    }

    public function setOptions($arr)
    {
        foreach ($arr as $key => $value) {
            $this->options[$key] = $value;
        }
    }

    public function getPayment()
    {
        return $this->payment;
    }

    public function getName()
    {
        return $this->name;
    }
}
