<?php

namespace App\Listeners;

use App\Events\RegisterSendMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Lib\Tool;

class RegisterSendMailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(RegisterSendMail $event)
    {
        if(!$event->user->username || !$event->user->pwd){
            return false;
        }

        Tool::sendEmail('您收到了一封邮件————普通发送邮件', "博客后台，用户：".$event->user->username.", 密码：".$event->user->pwd." 注册成功！", env('MAIL_RECEVIE_USER', '1527736751@qq.com'));
    }
}
