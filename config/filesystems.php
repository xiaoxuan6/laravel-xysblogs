<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'admin' => [
            'driver' => 'local',
            'root' => public_path('public'),
            'url' => env('APP_URL').'/public',
            'visibility' =>'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ],

        'cosv5' => [
            'driver' => 'cosv5',
            'region'          => env('COS_REGION'),    // 储存地区   https://cloud.tencent.com/document/product/436/6224
            'credentials'     => [
                'appId'     => env('COS_APPID'),    // 开发者访问 COS 服务时拥有的用户维度唯一资源标识，用以标识资源
                'secretId'  => env('COS_SECRET_ID'),    // 开发者拥有的项目身份识别 ID，用以身份认证
                'secretKey' => env('COS_SECRET_KEY'),    // 开发者拥有的项目身份密钥
            ],
            'timeout'         => 60,
            'connect_timeout' => 60,
            'bucket'          => env('COS_BUCKET'),    // COS 中用于存储数据的容器
            'cdn'             => env('COS_CDN'), // 访问地址
            'scheme'          => 'https',
        ],

    ],

];
