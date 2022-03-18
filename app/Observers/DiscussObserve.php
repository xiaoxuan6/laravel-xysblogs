<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace App\Observers;

use App\Events\ReplySendMail;
use App\Model\{Discuss, Oauth};

class DiscussObserve
{
    public function saved(Discuss $discuss)
    {
        if ($discuss->pid == 0) {
            return false;
        }

        if (! $discuss_p = Discuss::where('id', $discuss->pid)->with('oauth')->first()) {
            return false;
        }

        $discuss_p->content = $discuss->comment;
        $discuss_p->article_id = $discuss->article_id;
        $discuss_p->contact_cc = Oauth::where('id', $discuss->oauth_id)->value('username') ?? 'James';

        event(new ReplySendMail($discuss_p));
    }
}
