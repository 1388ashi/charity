<?php

return [
    'invoice' => [
        'active_drivers' => [
            'virtual' => [],
            'behpardakht' => [
                'config' => [
                    'terminalId' => '',
                    'username' => '',
                    'password' => '',
                ]
            ],
        ]
    ],
    'sms' => [
        'driver' => 'kavenegar',
        'sender' => '1000596446',
        'api_key' => '4C4E6E7A424B6676576D3452382F6D66464E477554647470686445315332446B',
        'patterns' => [
            'verification_code' => 'shopit-verification',
            'new_order' => 'shopit-neworder',
            'change_status' => 'shopit-changestatus',
            'deposit_wallet' => 'deposit-wallet',
            'listen_charge' => 'listen-charge'
        ],
        'new_order' => [
            'dont_send_full_name' => false
        ]
    ],
];
