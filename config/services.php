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
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    // ��̨ github ��¼
    'github' => [
        'client_id' => env('GITHUB_ID'),
        'client_secret' => env('GITHUB_SECRET'),
        'redirect' => env('GITHUB_REDIRECT'),
    ],

    // ǰ̨ github ��¼
    'web_github' => [
        'client_id' => env('WEB_GITHUB_ID'),
        'client_secret' => env('WEB_GITHUB_SECRET'),
        'redirect' => env('WEB_GITHUB_REDIRECT'),
    ],

    // �ٶȷ���
    'baidu_translate' => [
        'appid' => env('BAIDU_TRANSLATE_APPID'),
        'key'   => env('BAIDU_TRANSLATE_KEY'),
    ],

    // ��Ѷ��ͼ
    'map_api' => [
        'list_api_id' => env('TENCENT_MAP_LIST_API'),
        'api_id' => env('TENCENT_MAP_IP_API'),
        'key'   => env('TENCENT_MAP_KEY'),
    ],

    // sms ����
    'sms' => [
        'app_key' => env('SMS_APP_KEY'),
        'app_id' => env('SMS_APP_ID'),
    ],

];
