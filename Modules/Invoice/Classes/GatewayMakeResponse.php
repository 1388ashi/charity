<?php

namespace Modules\Invoice\Classes;


class GatewayMakeResponse implements  \Modules\Invoice\Contracts\GatewayMakeResponse
{
    public function __construct(public bool $success, public string $transactionId,
                                public string $url, public string $method = 'GET',
                                public array $inputs = [],
                                public string $message = '') {}


    public function getResult(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'url' => $this->url,
            'inputs' => $this->inputs,
            'method' => $this->method
        ];
    }


}
