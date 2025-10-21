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
        'api_key' => '3853687158734D783445694D6B2B632F4957446B47796E696B7679363435634E32433245376159543368673D',
        'patterns' => [
            'user_login' => 'user-login',
            'companion_login' => 'companion-login',
            'help_user_login' => 'help-user-login',
        ],
        'new_order' => [
            'dont_send_full_name' => false
        ]
    ],
];
