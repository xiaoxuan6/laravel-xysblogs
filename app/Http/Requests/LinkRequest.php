<?php

namespace App\Http\Requests;

use App\Rules\AliyunRule;

class LinkRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required',
            'url'       => 'required|url',
            'email'     => 'required|email',
            'describe'  => ['required', new AliyunRule()],
        ];
    }

    /**
     * Notes: 属性别名
     * Date: 2019/4/24 15:02
     * @return array
     */
    public function attributes()
    {
        return [
            'name'      => '标题',
            'url'       => '链接',
            'email'     => '邮箱',
            'describe'  => '描述',
        ];
    }

}
