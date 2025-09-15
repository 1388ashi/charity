<?php


namespace Modules\Invoice\Classes;



class GatewayVerifyResponse implements \Modules\Invoice\Contracts\GatewayVerifyResponse
{
    public function __construct(public bool $success, public string $message = '') {}


    public function getResult(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message
        ];
    }
}
