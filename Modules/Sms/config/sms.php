<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Driver
    |--------------------------------------------------------------------------
    |
    | This value determines which of the following Sms Company to use.
    | You can switch to a different driver at runtime.
    |
    */
    'default' => app(\Modules\Core\Classes\CoreSettings::class)->get('sms.driver'),
    /*
    |--------------------------------------------------------------------------
    | List of Drivers
    |--------------------------------------------------------------------------
    |
    | These are the list of Config drivers to use for this package.
    | You can change the name. Then you'll have to change
    | it in the map array too.
    |
    */
    'drivers' => [
        'farazsms' => [
            'username'    => app(\Modules\Core\Classes\CoreSettings::class)->get('sms.username'),
            'password'    => app(\Modules\Core\Classes\CoreSettings::class)->get('sms.password'),
            'urlPattern'  => 'https://ippanel.com/patterns/pattern',
            'urlNormal'   => 'https://ippanel.com/services.jspd',
            'from'        => '+983000505',
        ],
        'kavenegar' => [
            'api_key'    => app(\Modules\Core\Classes\CoreSettings::class)->get('sms.api_key'),
            'from'       => app(\Modules\Core\Classes\CoreSettings::class)->get('sms.sender'),
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Maps
    |--------------------------------------------------------------------------
    |
    | This is the array of Classes that maps to Drivers above.
    | You can create your own driver if you like and add the
    | config in the drivers array and the class to use for
    | here with the same name. You will have to extend
    |
    */

    'map' => [
        'farazsms'      => \Modules\Sms\Drivers\Farazsms::class,
        'kavenegar'     => \Modules\Sms\Drivers\Kavenegar::class
    ],
];
