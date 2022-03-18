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
use App\Events\ReplySendMail;

class ReplySendMailListener
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
    public function handle(ReplySendMail $event)
    {
        $contact = $event->comments->oauth->email;
        if (! $contact) {
            return false;
        }

        $data = [
            'user' => $contact,                     // 谁发表的评论
            'cc' => $event->comments->contact_cc,   // 谁回复的评论
            'content' => $event->comments->content, // 回复评论内容
            'title' => $event->comments->comment,   // 发表内容
            'article_id' => $event->comments->article_id,   // 发表内容
        ];
        Tool::sendMail($data, $contact);
    }
}
