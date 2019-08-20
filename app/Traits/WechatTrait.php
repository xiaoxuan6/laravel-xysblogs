<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2019/6/19
 * Time: 18:18
 */
namespace App\Traits;

Trait WechatTrait
{

    /**
     * Notes: 生成唯一订单
     * Date: 2019/6/19 18:26
     * @return string
     */
    public function no()
    {
        return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }

    /**
     * Notes: 生成字符串
     * Date: 2019/6/19 18:21
     * @param int $num
     * @return string
     */
    public function randStr($num = 32)
    {
        $string = "ABCDEFGHIJKLMNOPQRSTUVWHYZabcdefghijklmnopqrstuvwhyz0123456789";

        $str = '';
        for($i = 0; $i < $num ; $i++)
            $str .= $string[rand($i, strlen($string) - 1)];

        return $str;
    }

    /**
     * Notes: 加密
     * Date: 2019/6/19 18:21
     * @param array $data
     * @return string
     */
    public function getSign(array $data)
    {
        ksort($data);
        $str = http_build_query($data).'&key=' . env('DOME_MCH_KEY');
        return strtoupper(urlencode(MD5($str)));
    }

    /**
     * Notes: xml 转数组
     * Date: 2019/6/19 18:21
     * @param null $data
     * @return mixed|string
     */
    public function xmlToArray($data = null)
    {
        if(!$data)  return '';

        $attr = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
        return json_decode(json_encode($attr),true);
    }

    /**
     * Notes: 数组转xml
     * Date: 2019/6/19 18:19
     * @param array $arr
     * @return string
     */
    public function arrToXml(array $arr)
    {
        if(!is_array($arr) || count($arr) == 0) return '';
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    /**
     * Notes: http 请求支持 GET、POST
     * Date: 2019/6/19 18:20
     * @param $url
     * @param null $data
     * @return mixed
     */
    public function https_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        if($data)
        {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}