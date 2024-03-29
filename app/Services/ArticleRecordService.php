<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use App\Model\{Article, ArticleRecord};

class ArticleRecordService
{
    public function insert($id, $ip)
    {
        if (ArticleRecord::where(['article_id' => $id, 'ip' => $ip])->first()) {
            return false;
        }

        Article::where('id', $id)->increment('view');

        $result = $this->getAddress($ip);

        ArticleRecord::create([
            'article_id' => $id,
            'ip' => $ip,
            'lat' => Arr::get($result, 'result.location.lat', ''),
            'lng' => Arr::get($result, 'result.location.lng', ''),
            'nation' => Arr::get($result, 'result.ad_info.nation', ''),
            'province' => Arr::get($result, 'result.ad_info.province', ''),
            'city' => Arr::get($result, 'result.ad_info.city', ''),
            'district' => Arr::get($result, 'result.ad_info.district', ''),
            'adcode' => Arr::get($result, 'result.ad_info.adcode', ''),
        ]);
    }

    /**
     * Notes: 根据ip获取经纬度
     * Date: 2019/8/15 13:41
     * @param $ip
     * @return mixed
     */
    private function getAddress($ip)
    {
        $url = config('services.map_api.api_id') . '?ip=' . $ip . '&key=' . config('services.map_api.key');

        $client = new Client();
        $data = $client->get($url);

        return $result = json_decode($data->getBody(), true);
    }

    /**
     * Notes: 获取全国行政区经纬度
     * Date: 2019/8/15 13:42
     */
    private function getAreaInfo()
    {
        $url = config('services.map_api.list_api_id') . '?key=' . config('services.map_api.key');
    }
}
