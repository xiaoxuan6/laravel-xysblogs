<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Lib;

use Mail;
use Exception;
use Illuminate\Support\Facades\{Cache, Log};

class Tool
{
    public static function sendEmail($title, $data, $to)
    {
        try {
            Mail::raw($data, function ($message) use ($title, $to) {
                $message->from(env('MAIL_USERNAME'), env('MAIL_USERNAME'));
                $message->to($to)->subject($title);
            });

            if (count(Mail::failures()) < 1) {
                return true;
            }

            return false;
        } catch (Exception $e) {
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
        Mail::send('email.mail', $data, function ($message) use ($to) {
            $message->from(env('MAIL_USERNAME'), 'James');
            $message->to($to)->subject('James 博客邮件通知');
        });
    }
}
