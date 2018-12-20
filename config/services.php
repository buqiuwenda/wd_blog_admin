<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\Model\Member::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'youdao' => [
        'domain' => 'http://openapi.youdao.com/api',
        'app_key' =>  env('YOUDAO_ID', ''),
        'app_secret' => env('YOUDAO_KEY', ''),
        'timeout'   => 5,
    ],

    'qiniu' => [
        'domain' => env('QINIU_DOMAIN', 'https://qncdn.buqiuwenda.com'),
        'access_key' => env('QINIU_ACCESS_KEY', ''),
        'secret_key' => env('QINIU_SECRET_KEY', ''),
        'bucket'  => env('QINIU_BUCKET', '')
    ]

];
