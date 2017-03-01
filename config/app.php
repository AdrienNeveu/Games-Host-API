<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY', 'SomeRandomString!!!'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */
    'locale' => env('APP_LOCALE', 'en'),
    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),
    /*
    |--------------------------------------------------------------------------
    | Authorized Currencies
    |--------------------------------------------------------------------------
    |
    | The authorized currencies are used by Stripe and the Swap package.
    | Only those can be used across the application. Make sure the currency
    | codes are the same on Stripe and the services used by Swap.
    | Zero-decimal currencies like KRW or JPY are not supported.
    |
    */
    'currencies' => [
        'usd', 'eur', 'aud', 'cad', 'gbp', 'chf', 'brl', 'rub'
    ]
];
