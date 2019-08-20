<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\WechatTrait;

class WechatPayController extends Controller
{
    use WechatTrait;

    public function index()
    {
        view('pay.index');
    }

    /**
     * Notes: 登录获取openid
     * Date: 2019/5/30 18:27
     * @param Request $request
     * @return mixed
     */
    public function getOpenid(Request $request)
    {
        if(!$code = $request->input('code'))
            dd('参数错误');

        //接口需要的参数
        $params = [
            'appid' => env('DOME_APPID'),
            'secret' => env('DOME_APP_SECRET'),
            'js_code' => $code,
            'grant_type' => 'authorization_code',
        ];

        $response = json_decode($this->https_request('https://api.weixin.qq.com/sns/jscode2session?'.http_build_query($params)), 1);

        if($response['errcode'] != 0)
            dd('登录失败');

        if(!$response['openid'])
            dd('未获取到用户openid');

        return Tool::outData(0, [
            'openid' => $response['openid']
        ]);
    }

    // 文档地址 https://pay.weixin.qq.com/wiki/doc/api/wxa/wxa_api.php?chapter=9_1
    public function pay(Request $request)
    {
        $openid = $request->input('openid');

        $params = [
            'appid'         => env('DOME_APPID'),
            'mch_id'        => env('DOME_MCH_ID'),
            'nonce_str'     => $this->randStr(),
            'body'          => '测试',
            'out_trade_no'  => $this->no(),
            'total_fee'     => 1,                // 订单总金额，单位为分
            'spbill_create_ip'=> $_SERVER['REMOTE_ADDR'],   // 支付ip
            'notify_url'    => '/',   // 回调地址
            'trade_type'    => 'JSAPI',       // 交易类型
            'openid'        => $openid,
        ];
        $params['sign'] = $this->getSign($params);
        $xml = $this->ArrToXml($params);

        $result = $this->https_request('https://api.mch.weixin.qq.com/pay/unifiedorder', $xml);
        $response = $this->xmlToArray($result);
        if($response['return_code' !== 'SUCCESS'] || $response['result_code'] != 'SUCCESS')
            dd('下单失败');

        $datas = [
            'appId' => env('DOME_APPID'),
            'timeStamp' => $this->randStr(),
            'nonceStr' => $response['nonce_str'],
            'package' => 'prepay_id='.$response['prepay_id'],
            'signType' => 'MD5',
        ];
        $datas['paySign'] = $this->getSign($datas);

        return $datas;
    }

    // 支付成功后的回调
    public function notify(Request $request){
        dd($request->all());
    }

}
