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

use Qcloud\Sms\SmsSingleSender;

class Sms
{
    private $appid;
    private $appkey;
    private $templateId;
    private $smsSign;

    public function __construct()
    {
        $this->appid = config('sms.appid');
        $this->appkey = config('sms.appkey');
        $this->templateId = config('sms.templateId');
        $this->smsSign = config('sms.smsSign');
    }

    // 单发短信
    public function sendSingle($phone, $Code, $time)
    {
        $ssender = new SmsSingleSender($this->appid, $this->appkey);
        $result = $ssender->send(0, '86', $phone, $Code . '为您的登录验证码，请于' . $time . '分钟内填写。', '', '');
        $rsp = json_decode($result, true);

        if ($rsp['errmsg'] == 'OK') {
            return 1;
        }

        return 0;
    }

    // 指定模板ID单发短信
    public function sendTemplate($params = [], $phone, $svr_password)
    {
        if (! is_array($params)) {
            return '参数错误';
        }

        $ssender = new SmsSingleSender($this->appid, $this->appkey);
        $result = $ssender->sendWithParam('86', $phone, $this->templateId, $params, $this->smsSign, '', '');  // 签名参数未提供或者为空时，会使用默认签名发送短信

        $rsp = json_decode($result, true);
        if ($rsp['errmsg'] == 'OK') {
            return '发送成功';
        }

        return '发送失败';
    }
}
