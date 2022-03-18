<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace App\Listeners;

use Lib\Tool;
use App\Events\RegisterSendMail;

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
     * @param object $event
     * @return void
     */
    public function handle(RegisterSendMail $event)
    {
        if (! $event->user->username || ! $event->user->pwd) {
            return false;
        }

        Tool::sendEmail('您收到了一封邮件————普通发送邮件', '博客后台，用户：' . $event->user->username . ', 密码：' . $event->user->pwd . ' 注册成功！', env('MAIL_RECEVIE_USER', '1527736751@qq.com'));
    }
}
