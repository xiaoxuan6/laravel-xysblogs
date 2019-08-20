<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use James\AliGreen\AliGreen;

class AliyunRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $ali = AliGreen::getInstance();

        $string = substr($value, 0, 5);
        if(!in_array($string, ['http:', 'https'])){
            $result = $ali->checkText($value);
        }else{
            $result = $ali->checkImg($value);
        }

        if($result['code'] != 200){
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '评论内容非法，文本检测涉嫌涉黄、暴恐、敏感检测等';
    }
}
