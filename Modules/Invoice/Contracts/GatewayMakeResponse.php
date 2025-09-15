<?php


namespace Modules\Invoice\Contracts;


use JetBrains\PhpStorm\ArrayShape;

interface GatewayMakeResponse
{
    #[ArrayShape([
        'success' => 'bool',
        'transaction_id' => 'string',
        'message' => 'string',
        'url' => 'string',
        'inputs' => 'array',
        'method' => 'string'
    ])]
    public function getResult(): array;
}
