<?php

return [
    // 短信应用SDK AppID
    'appid' => config('services.sms.app_id'), // 1400开头

    // 短信应用SDK AppKey
    'appkey' => config('services.sms.app_key'),

    // 短信模板ID，需要在短信应用中申请
    'templateId' => 208651,  // NOTE: 这里的模板ID`7839`只是一个示例，真实的模板ID需要在短信控制台中申请

    'smsSign' => "晓轩脱口秀", // NOTE: 这里的签名只是示例，请使用真实的已申请的签名，签名参数使用的是`签名内容`，而不是`签名ID`
];