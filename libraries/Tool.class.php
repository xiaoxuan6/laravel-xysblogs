<?php

namespace Lib;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Tool
{
    public static function sendEmail($title, $data, $to){

        try{
            \Mail::raw($data, function($message) use($title, $to){
                $message->from(env('MAIL_USERNAME'), env('MAIL_USERNAME'));
                $message->to($to)->subject($title);
            });

            if(count(\Mail::failures()) < 1)
                return true;
            else
                return false;

        }catch (\Exception $e){
            return false;
        }
    }

    /**
     * Notes: 发送评论邮件
     * Date: 2019/5/8 16:53
     * @param $data
     * @param $to
     */
    public static function sendMail($data, $to)
    {
        \Mail::send('email.mail', $data, function($message) use($to){
            $message->from(env('MAIL_USERNAME'), 'James');
            $message->to($to)->subject('James 博客邮件通知');
        });
    }
}
