<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
return [
    // 阿里云 accessKeyId
    'accessKeyId' => env('ACCESS_KEY_ID'),
    // 阿里云 accessKeySecret
    'accessKeySecret' => env('ACCESS_KEY_SECRET'),
    // 支持的场景有：porn（色情）、terrorism（暴恐）、qrcode（二维码）、ad（图片广告）、 ocr（文字识别）
    'scenes' => ['ad', 'porn', 'terrorism', 'qrcode'],
    // 地区 上海
    'region' => 'cn-shanghai',
];
