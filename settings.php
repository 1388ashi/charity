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
        'api_key' => '4F68793747657139716358636C76546D45787135696F636D497A4156464E5175336D2B357064664F6837493D',
        'patterns' => [
            'user_login' => 'user-login',
            'new_help_user' => 'new-help-user',
            'create_companion' => 'create-companion',
            'companion_login' => 'companion-login',
            'help_user_login' => 'help-user-login',
            'create_partner_to_person' => 'create-partner-to-person',
            'create_partner_to_city' => 'create-partner-to-city',
            'change_status_partner' => 'change-status-partner',
        ],
        'new_order' => [
            'dont_send_full_name' => false
        ]
    ],
];
