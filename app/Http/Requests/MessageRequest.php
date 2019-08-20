<?php

namespace App\Http\Requests;

use App\Rules\AliyunRule;
use App\Rules\CommentRule;

class MessageRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'comment' => ['required', new CommentRule, new AliyunRule],
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
            'comment' => '评论内容',
        ];
    }
}
