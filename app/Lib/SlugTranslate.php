<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace App\Lib;

use GuzzleHttp\Client;
use Overtrue\Pinyin\Pinyin;

class SlugTranslate
{
    public static function translate($text)
    {
        if (static::isEnglish($text)) {
            return str_slug($text);
        }

        $http = new Client();

        $api = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';
        $appid = config('services.baidu_translate.appid');
        $salt = time();
        $key = config('services.baidu_translate.key');

        // 如果没有配置百度翻译，直接使用拼音
        if (empty($appid) || empty($key)) {
            return static::pinyin($text);
        }

        // http://api.fanyi.baidu.com/api/trans/product/apidoc
        // appid+q+salt+密钥 的MD5值
        $sign = md5($appid . $text . $salt . $key);

        $query = http_build_query([
            'q' => $text,
            'from' => 'zh',
            'to' => 'en',
            'appid' => $appid,
            'salt' => $salt,
            'sign' => $sign,
        ]);
        $url = $api . $query;

        $response = $http->get($url);

        $result = json_decode($response->getBody(), true);
        if (isset($result['trans_result'][0]['dst'])) {
            return str_slug($result['trans_result'][0]['dst']);
        }

        return static::pinyin($text);
    }

    public static function pinyin($text)
    {
        return str_slug(app(Pinyin::class)->permalink($text));
    }

    protected static function isEnglish($text)
    {
        if (preg_match("/\p{Han}+/u", $text)) {
            return false;
        }

        return true;
    }
}
