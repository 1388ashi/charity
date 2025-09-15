<?php


namespace Modules\Invoice\Contracts;


use JetBrains\PhpStorm\ArrayShape;

interface GatewayVerifyResponse
{


    #[ArrayShape([
        'success' => 'bool',
        'message' => 'string'
    ])]
    public function getResult(): array;
}
